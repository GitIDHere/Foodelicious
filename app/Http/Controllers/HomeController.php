<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $homeService;


    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showHome(Request $request)
    {
        $recipeLimit = 3;

        $homeData = [
            'recent_recipes' => [],
            'most_favourited' => [],
            'most_commented' => []
        ];

        try
        {
            $homeData['recent_recipes'] = $this->homeService->mostRecentRecipes($recipeLimit);
            $homeData['most_commented'] = $this->homeService->mostCommentedRecipes($recipeLimit);
            $homeData['most_favourited'] = $this->homeService->mostFavouritedRecipes($recipeLimit);
        }
        catch (\Exception $exception) {

        }

        return view('screens.home')
            ->with('homeData', $homeData);
    }


}
