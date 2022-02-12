<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $rules = [
        'name' => 'required|max:100',
        'is_active' => 'boolean',
    ];

    public function index(Request $request)
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $category = Category::create($request->all());

        return $category->refresh();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->rules);

        $category->update($request->all());

        return $category->refresh();
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent(); //204
    }
}
