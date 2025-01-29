<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Article::with('tags')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'heading' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        $article = Article::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        if($article->tags){
            $article->tags()->sync($request->tags);
        }

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return $article->load('tags');
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
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required',
            'heading' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ]);

        $article->update($request->all());

        if($request->tags){
            $article->tags()->sunc($request->tags);
        }

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}
