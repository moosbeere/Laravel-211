<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PublicArticleNotify;

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
        return view('articles.index', ['articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [self::class]);
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
        $this->authorize('create', [self::class]);
        
        $request->validate([
            'date' => 'date|required',
            'title' => 'required',
            'text' => 'required',
        ]);

        $article = new Article();
        $article->date = $request->date;
        $article->name = request('title');
        $article->shortDesc = request('annot');
        $article->desc = request('text');
        $result = $article->save();
        $users=User::where('id', '!=', auth()->id())->get();
        if ($result){
            Notification::send($users, new PublicArticleNotify($article));
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if(isset($_GET['notify'])){
            
            auth()->user()->notifications()->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $comments = Comment::whereColumn([
            ['article_id', $article->id],
            ['accept', 1]
            ])->latest()->get();
        return view('articles.show', ['article'=>$article, 'comments'=>$comments]);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $this->authorize('update', [self::class, $article]);
        return view('articles.edit', ['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->authorize('update', [self::class, $article]);
        $request->validate([
            'date' => 'date|required',
            'title' => 'required',
            'text' => 'required',
        ]);

        $article->date = request('date');
        $article->name = request('title');
        $article->shortDesc = request('annot');
        $article->desc = request('text');
        $article->save();
        return redirect()->route('article.show',['article'=>$article->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', [self::class, $article]);
        Comment::where('article_id', $article->id)->delete();
        $article->delete();
        return redirect()->route('main');
    }
}
