<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\PostWorkflowService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private PostWorkflowService $workflow)
    {
        $this->middleware('permission:view_review_queue');
    }

    public function index()
    {
        $posts = Post::inReviewQueue()
            ->with(['authorUser', 'categories'])
            ->latest('updated_at')
            ->paginate(20);

        return view('admin.review.index', compact('posts'));
    }

    public function startReview(Post $post)
    {
        $this->authorize('review', $post);

        try {
            $this->workflow->startReview($post, auth()->user());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Review started.');
    }

    public function requestChanges(Request $request, Post $post)
    {
        $this->authorize('review', $post);

        $request->validate(['editorial_notes' => 'required|string|max:5000']);

        try {
            $this->workflow->requestChanges($post, auth()->user(), $request->input('editorial_notes'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Change request sent to the writer.');
    }

    public function reject(Request $request, Post $post)
    {
        $this->authorize('review', $post);

        $request->validate(['editorial_notes' => 'required|string|max:5000']);

        try {
            $this->workflow->reject($post, auth()->user(), $request->input('editorial_notes'));
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Article rejected.');
    }

    public function publish(Post $post)
    {
        $this->authorize('publish', $post);

        try {
            $this->workflow->publish($post, auth()->user());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['workflow' => $e->getMessage()]);
        }

        return back()->with('success', 'Article published.');
    }
}
