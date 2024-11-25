<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $categories = Category::where('user_id', auth()->id())->orderBy('created_at', 'desc')->when($search, function($query, $search) {
            return $query
                ->where('id', 'like', "%$search%")
                ->orWhere('name', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        })->paginate(20);
        return view('category.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->id();
        $validatedData = $request->validate([
            'name' => 'required|string'
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        if ($request->has('description')) {
            $category->description = $request->input('description');
        }
        $category->user_id = $user_id;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->transactions()->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'category has transactions, Clear relevant fields before executing',
            ]);
        }
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'success',
        ]);
    }
}
