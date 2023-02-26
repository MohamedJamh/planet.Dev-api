<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api','verified']);
    }

    public function index()
    {
        $categories = new CategoryCollection(Category::all());

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        if (Gate::denies('modifie-categories'))
            return response()->json([
                'status' => 'fail',
                'message' => 'you dont have access',
            ], 403);

        if (Category::where('name', $request->name)->exists())
            return response()->json([
                'status' => 'fail',
                'message' => 'category already exist',
            ], 409); // conflict

        $category = Category::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'category' => new CategoryResource($category),
        ], 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => 'succes',
            'category' => new CategoryResource($category),
        ], 200);
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        if (Gate::denies('modifie-categories'))
            return response()->json([
                'status' => 'fail',
                'message' => 'you dont have access',
            ], 403);

        $category = Category::find($id);

        if (!$category)
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found',
            ], 404);

        $category->update($request->all());
        
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'category' => new CategoryResource($category),
        ], 200);
    }

    public function destroy($id)
    {
        if (Gate::denies('modifie-categories'))
            return response()->json([
                'status' => 'fail',
                'message' => 'you dont have access',
            ], 403);

        $category = Category::find($id);

        if (!$category)
            return response()->json([
                'status' => 'fail',
                'message' => 'Category not found',
            ], 404);

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully',
            'category' => new CategoryResource($category),
        ], 200);
    }
}
