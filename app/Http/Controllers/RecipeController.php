<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Stock;

class RecipeController extends Controller
{

    /**
     * Possible Recipes.
     * 
     * @OA\Get(
     *     path="/api/recipes-possible",
     *     summary="Possible Recipes",
     *     @OA\Response(response="200", description="Success"),
     * )
     */
    public function displayPossibleRecipes()
    {

        $recipes = Recipe::all();

        $dspRcps = [];

        foreach ($recipes as $recipe) {

            $this->checkStockForRecipe($recipe) ? $dspRcps[] = [
                'recipe' => $recipe,
                'status' => 'Available Recipe',
            ] : $dspRcps[] = [
                'recipe' => $recipe,
                'status' => 'This Recipe missing products or products does not in stock',
            ];
        }

        return response()->json(['possible_recipes' => $dspRcps], 200);
    }



    /**
     * Confirm the stock for the recipe.
     *
     * @OA\Post(
     *     path="/api/valid-recipe",
     *     summary="Confirm the stock for the recipe",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="recipe_id", type="integer"),
     *         )
     *     ),
     *     @OA\Response(response="200", description="Stock was successfully reduced after the recipe was validated"),
     *     @OA\Response(response="422", description="Validation failures or insufficient stock"),
     * )
     */
    public function validRecipe(StoreRecipeRequest $request)
    {

        $recipe = Recipe::findOrFail($request->input('recipe_id'));

        if ($this->checkStockForRecipe($recipe)) {
            $this->changeQuantityOfStock($recipe);
            return response()->json(['message' => 'Stock was successfully reduced after the recipe was validated'], 200);
        } else {
            return response()->json(['message' => 'Validation failures or insufficient stock'], 422);
        }
    }


    private function checkStockForRecipe(Recipe $recipe)
    {
        foreach ($recipe->products as $product) {
            $stock = Stock::where('product_id', $product->id)->first();

            if (!$stock || $stock->quantity <= 0) {
                return false;
            }
        }
        return true;
    }


    private function changeQuantityOfStock(Recipe $recipe)
    {
        foreach ($recipe->products as $product) {
            $stock = Stock::where('product_id', $product->id)->first();

            if ($stock && $stock->quantity > 0) {
                $stock->update(['quantity' => $stock->quantity - 1]);
            }
        }
    }
}
