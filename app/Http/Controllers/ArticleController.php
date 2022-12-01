<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\Comment;
use App\Notifications\NotifyNewArticle;
use Illuminate\Support\Facades\Notification;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::latest()->paginate(5);
        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $article = new Article();
        $article->date = request('date');
        $article->date = request('date');
        $article->name = request('title');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
        event(new NewArticleEvent($article->name));
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::FindOrFail($id);
        $comments = Comment::where('article_id', $article->id)->latest()->paginate(2);
        return view('articles.show', ['article' => $article, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::FindOrFail($id);
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $article = Article::FindOrFail($id);
        $article->date = request('date');
        $article->name = request('title');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
        return redirect('/article/'.$article->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::FindOrFail($id);
        Comment::where('article_id', $id)->delete();
        $article->delete();
        return redirect('/');
    }
}
