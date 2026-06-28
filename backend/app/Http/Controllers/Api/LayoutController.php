<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LayoutService;
use Illuminate\Http\JsonResponse;

class LayoutController extends Controller
{
    public function __construct(private LayoutService $layout)
    {
    }

    public function homepage(): JsonResponse
    {
        return response()->json($this->layout->resolveHomepage());
    }

    public function hub(string $hubSlug): JsonResponse
    {
        abort_unless(in_array($hubSlug, config('editorial_layout.hub_slugs', []), true), 404);

        return response()->json($this->layout->resolveHub($hubSlug));
    }
}
