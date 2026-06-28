<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IntelligenceBriefService;
use Illuminate\Http\JsonResponse;

class BriefController extends Controller
{
    public function __construct(private IntelligenceBriefService $briefs)
    {
    }

    public function latest(): JsonResponse
    {
        $brief = $this->briefs->resolveLatest();

        abort_if($brief === null, 404);

        return response()->json($brief);
    }

    public function show(string $date): JsonResponse
    {
        if ($date === 'dates') {
            abort(404);
        }

        $brief = $this->briefs->resolveByDate($date);

        abort_if($brief === null, 404);

        return response()->json($brief);
    }

    public function dates(): JsonResponse
    {
        return response()->json([
            'dates' => $this->briefs->publishedDates(),
        ]);
    }
}
