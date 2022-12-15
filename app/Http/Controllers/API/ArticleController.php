<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PublicArticleNotify;
use App\Events\PublicArticleEvent;
use App\Http\Controllers\Controller;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPage = request('page');
        $articles = Cache::remember('articles:all1'.$currentPage, 2000, function(){
            return Article::latest()->paginate(5);
        });
        return response($articles, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [self::class]);
        // return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $caches = DB::table('cache')->whereRaw('`key` GLOB :name', ['name' => 'articles:all*[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
        }
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
            PublicArticleEvent::dispatch($article->name);
        }
        return response($article);
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
        $data = Cache::rememberForever('show:'.$article->id, function()use($article){
            $comments = Comment::whereColumn([
                        ['article_id', $article->id],
                        ['accept', 1]
                    ])->latest()->get();
            return ['article'=>$article, 'comments'=>$comments];
        });
        return response($data);       
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
        return response($article);
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
        Cache::forget(DB::table('cache')->whereRaw('`key` GLOB :name', ['name' => 'show:'.$article->id])->first()->key);
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
        return response($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        Cache::flush();
        $this->authorize('delete', [self::class, $article]);
        Comment::where('article_id', $article->id)->delete();
        return response($article->delete());
    }
}
