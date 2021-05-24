<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
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
     * Get ingredients by matching term
     * @param Request $request
     * @return JsonResponse
     */
    public function ingredientList(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string|max:150',
        ]);

        $term = $request->get('term');

        $ingredientList = $this->tagService->getListByTerm(Ingredient::class, 'name', $term);

        $list = [];
        foreach ($ingredientList as $ingredient){
            $list[] = $ingredient['name'];
        }

        return new JsonResponse([
            'message' => '',
            'data' => $list,
            'status' => 200,
            'date_time' => now()->format('Y-m-d H:i:s')
        ]);
    }
}
