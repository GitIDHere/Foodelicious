<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserRecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavouriteRecipeController extends Controller
{
    /**
     * @var UserRecipeService
     */
    private $userRecipeService;


    public function __construct(UserRecipeService $userRecipeService)
    {
        $this->userRecipeService = $userRecipeService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function showFavouriteList(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->userProfile;

        $favouriteList = $this->userRecipeService->getFavourites($profile);

        return view('screens.user.favourites.view')
            ->with('favouriteList', $favouriteList['recipe_list'])
            ->with('favouriteListPager', $favouriteList['pager'])
            ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function searchFavouriteRecipe(Request $request)
    {
        $validated = $request->validate([
            'search_term' => 'nullable|string|min:1|max:60',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $userProfile = $user->userProfile;

        $searchTerm = $request->get('search_term');

        // If the search term is empty, then redirect them to the recipe list
        if(empty($searchTerm)) {
            return redirect()->route('user.recipe.favourites');
        }

        $recipes = $this->userRecipeService->getFavourites($userProfile, $searchTerm);

        return view('screens.user.favourites.view')
            ->with('favouriteList', $recipes['recipe_list'])
            ->with('favouriteListPager', $recipes['pager'])
            ->with('searchTerm', $searchTerm)
            ;
    }
}
