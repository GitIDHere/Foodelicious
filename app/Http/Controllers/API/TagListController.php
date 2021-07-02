<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagListController extends Controller
{
    /**
     * @var TagService
     */
    private $tagService;


    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchUtensils(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string|max:150',
        ]);

        $term = $request->get('term');
        $utensilList = $this->tagService->searchForUtensil($term);

        return new JsonResponse([
            'message' => '',
            'data' => $utensilList,
            'status' => 200,
            'date_time' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get ingredients by matching term
     * @param Request $request
     * @return JsonResponse
     */
    public function searchIngredients(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string|max:150',
        ]);

        $term = $request->get('term');

        $ingredientList = $this->tagService->searchForIngredient($term);

        return new JsonResponse([
            'message' => '',
            'data' => $ingredientList,
            'status' => 200,
            'date_time' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
