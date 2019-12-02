<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleValidate;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $articles = $q ? Article::where('name', 'like', "%{$q}%")->paginate() : Article::paginate();
        return view('article.index', compact('articles', 'q'));
    }
    
    public function create()
    {
        $article = new Article();
        return view('article.create', compact('article'));
    }
   
    public function store(ArticleValidate $request)
    {
        #$this->validate($request, [
            #'name' => 'required|unique:articles',
            #'body' => 'required|min:5',
        #]);
        $request->validated();
        $article = new Article();
        $article->fill($request->all());
        $article->save();
        #$request->session()->flash('status', 'Article was created!');
        
        return redirect()
            ->route('articles.index')->with('status', 'Article was created!');
    }
    
    public function show(Article $article)
    {
        #$article = Article::findOrFail($id);
        return view('article.show', compact('article'));
    }

    public function edit(Article $article)
    {
        #$article = Article::findOrFail($id);
        return view('article.edit', compact('article'));
    }
   
    public function update(ArticleValidate $request, Article $article)
    {
        #$article = Article::findOrFail($id);
    
        #$this->validate($request, [
            #'name' => 'required|unique:articles,name,' . $article->id,
            #'body' => 'required|min:5'
        #]);
        
        $request->validated();
        $article->fill($request->all());
        $article->save();
        return redirect()
            ->route('articles.index')->with('status', 'Article was updated!');
    }
    
    public function destroy(Article $article)
    {
        #$article = Article::find($id);
        if ($article) {
            $article->delete();
        }
        return redirect()->route('articles.index')->with('status', 'Article was deleted!');
    }
}
