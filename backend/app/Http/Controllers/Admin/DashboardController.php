<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $postQuery = Post::query()->forUser($user);

        if ($user->isEditor()) {
            $stats = [
                ['label' => 'Articles', 'value' => (clone $postQuery)->count(), 'sub' => (clone $postQuery)->where('status', PostStatus::Published->value)->count().' published'],
                ['label' => 'Review Queue', 'value' => Post::inReviewQueue()->count(), 'sub' => 'awaiting approval'],
                ['label' => 'Drafts', 'value' => (clone $postQuery)->where('status', PostStatus::Draft->value)->count(), 'sub' => 'in progress'],
                ['label' => 'Categories', 'value' => Category::count(), 'sub' => Tag::count().' tags'],
            ];

            $reviewQueue = Post::inReviewQueue()->with('authorUser')->latest('updated_at')->take(5)->get();
        } else {
            $stats = [
                ['label' => 'My Articles', 'value' => (clone $postQuery)->count(), 'sub' => (clone $postQuery)->where('status', PostStatus::Published->value)->count().' published'],
                ['label' => 'Drafts', 'value' => (clone $postQuery)->where('status', PostStatus::Draft->value)->count(), 'sub' => 'not yet submitted'],
                ['label' => 'In Review', 'value' => (clone $postQuery)->whereIn('status', [PostStatus::Submitted->value, PostStatus::InReview->value])->count(), 'sub' => 'with editors'],
                ['label' => 'Needs Revision', 'value' => (clone $postQuery)->where('status', PostStatus::ChangesRequested->value)->count(), 'sub' => 'returned to you'],
            ];

            $reviewQueue = collect();
        }

        $recentPosts = (clone $postQuery)->with('authorUser')->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'reviewQueue'));
    }
}
