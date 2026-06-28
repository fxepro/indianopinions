<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\LayoutSlot;
use App\Models\Post;
use App\Services\LayoutService;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function __construct(private LayoutService $layout)
    {
        $this->middleware('permission:'.Permission::ManageLayout->value);
    }

    public function homepage()
    {
        return view('admin.layout.homepage', $this->formData('homepage'));
    }

    public function updateHomepage(Request $request)
    {
        $this->layout->syncHomepage($this->parseAssignments($request, 'homepage'));

        return back()->with('success', 'Homepage layout saved.');
    }

    public function hub(string $hubSlug)
    {
        abort_unless(in_array($hubSlug, config('editorial_layout.hub_slugs', []), true), 404);

        return view('admin.layout.hub', $this->formData('hub', $hubSlug));
    }

    public function updateHub(Request $request, string $hubSlug)
    {
        abort_unless(in_array($hubSlug, config('editorial_layout.hub_slugs', []), true), 404);

        $this->layout->syncHub($hubSlug, $this->parseAssignments($request, 'hub'));

        return back()->with('success', ucfirst(str_replace('-', ' ', $hubSlug)).' hub layout saved.');
    }

    /** @return array<string, mixed> */
    private function formData(string $page, ?string $hubSlug = null): array
    {
        $definitions = config("editorial_layout.{$page}", []);
        $slots = LayoutSlot::query()
            ->where('page', $page)
            ->when($hubSlug, fn ($q) => $q->where('hub_slug', $hubSlug))
            ->when(! $hubSlug, fn ($q) => $q->whereNull('hub_slug'))
            ->get()
            ->groupBy('section');

        $publishedPosts = Post::query()
            ->where('status', PostStatus::Published->value)
            ->with('categories')
            ->latest('published_at')
            ->get();

        return compact('definitions', 'slots', 'publishedPosts', 'page', 'hubSlug');
    }

    /** @return array<string, array<int, int|null>> */
    private function parseAssignments(Request $request, string $page): array
    {
        $definitions = config("editorial_layout.{$page}", []);
        $assignments = [];

        foreach ($definitions as $section => $definition) {
            $count = (int) ($definition['count'] ?? 1);
            $assignments[$section] = [];

            for ($position = 0; $position < $count; $position++) {
                $value = $request->input("slots.{$section}.{$position}");
                $assignments[$section][$position] = $value ? (int) $value : null;
            }
        }

        return $assignments;
    }
}
