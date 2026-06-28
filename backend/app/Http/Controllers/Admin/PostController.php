<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Services\PostWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function __construct(private PostWorkflowService $workflow)
    {
        $this->authorizeResource(Post::class, 'post', [
            'except' => ['submit', 'unpublish', 'transition'],
        ]);
    }

    /** @return array<string, string> */
    protected function resourceAbilityMap(): array
    {
        return [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'view',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }

    public function index(Request $request)
    {
        $query = Post::with(['categories', 'authorUser'])
            ->forUser($request->user())
            ->latest();

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($request->boolean('mine') && $request->user()->isWriter()) {
            $query->where('user_id', $request->user()->id);
        }

        $posts = $query->paginate(20)->withQueryString();

        return view('admin.posts.index', [
            'posts' => $posts,
            'statuses' => PostStatus::cases(),
            'currentStatus' => $status,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return view('admin.posts.form', [
            'post' => null,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $data = $this->validatePost($request);
        $user = $request->user();

        $post = Post::create([
            ...$data,
            'user_id' => $user->id,
            'author' => $data['author'] ?? $user->name,
            'status' => PostStatus::Draft->value,
        ]);

        $this->syncRelations($post, $request);
        $this->workflow->logCreated($post, $user);

        return redirect()->route('admin.posts.show', $post)->with('success', 'Article saved as draft.');
    }

    public function show(Post $post)
    {
        $post->load(['categories', 'tags', 'authorUser', 'reviewer', 'publisher', 'workflowEvents.user']);

        return view('admin.posts.show', [
            'post' => $post,
            'workflowEvents' => $post->workflowEvents,
        ]);
    }

    public function edit(Post $post)
    {
        $post->load(['categories', 'tags', 'authorUser', 'reviewer', 'workflowEvents.user']);

        $user = auth()->user();
        $allowedTransitions = $this->workflow->allowedTransitions($post, $user);

        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'allowedTransitions' => $allowedTransitions,
            'workflowEvents' => $post->workflowEvents,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $this->validatePost($request, $post);

        $post->update($data);
        $this->syncRelations($post, $request);

        return redirect()->route('admin.posts.show', $post)->with('success', 'Article updated.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Article deleted.');
    }

    public function submit(Request $request, Post $post)
    {
        $this->authorize('submit', $post);

        $request->validate(['submission_notes' => 'nullable|string|max:2000']);

        try {
            $this->workflow->submit($post, $request->user(), $request->input('submission_notes'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Article submitted for editorial review.');
    }

    public function unpublish(Request $request, Post $post)
    {
        $this->authorize('unpublish', $post);

        $request->validate(['note' => 'nullable|string|max:5000']);

        try {
            $this->workflow->unpublish($post, $request->user(), $request->input('note'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Article archived and removed from the public site.');
    }

    public function transition(Request $request, Post $post)
    {
        $this->authorize('transition', $post);

        $allowed = collect($this->workflow->allowedTransitions($post, $request->user()))
            ->map(fn (PostStatus $status) => $status->value)
            ->all();

        $validated = $request->validate([
            'status' => ['required', Rule::in($allowed)],
            'note' => 'nullable|string|max:5000',
        ]);

        $to = PostStatus::from($validated['status']);

        try {
            $this->workflow->transition($post, $request->user(), $to, $validated['note'] ?? null);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Workflow updated to '.$to->label().'.');
    }

    private function validatePost(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug'.($post ? ",{$post->id}" : ''),
            'excerpt' => 'nullable|string|max:2000',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
        ]);

        if ($request->user()->isEditor()) {
            $data['featured'] = $request->boolean('featured');
        }

        return $data;
    }

    private function syncRelations(Post $post, Request $request): void
    {
        $post->categories()->sync($request->input('categories', []));
        $post->tags()->sync($request->input('tags', []));
    }
}
