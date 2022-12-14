<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;
use App\Notifications\PublicArticle;
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
        $articles = Cache::remember('articles:all'.$currentPage, 2000, function(){
            return Article::latest()->paginate(5);
        });
        return response($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('create', [self::class]);
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
        Cache::forget('articles:all');
        $caches = DB::table('cache')->whereRaw('`key` GLOB :name', ['name'=>'*[0-9]'])->get();
        foreach($caches as $cache){
            Cache::forget($cache->key);
            // Log::alert($cache);
        }
        $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $article = new Article();
        $article->date = request('date');
        $article->name = request('title');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $result = $article->save();
        $user = User::where('id', '!=', auth()->id())->get();
        if ($result){
            Notification::send($user, new PublicArticle($article));
            PublicArticleEvent::dispatch($article->name);
        }
        return response($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (isset($_GET['notify'])){
            auth()->user()->notifications()->where('id', $_GET['notify'])->first()->markAsRead();
        }
        
        $article = Cache::rememberForever('article:'.$id.'_show', function()use($id){
            return Article::FindOrFail($id);
        });
        $comment = Comment::whereColumn([
                                ['article_id', $id],
                                ['accept', 1]
                            ])->latest()->paginate(4);
        return response()->json(['article' => $article, 'comments'=>$comment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', [self::class]);
        $article = Article::FindOrFail($id);
        return response()->json(['article' => $article]);
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
        if ($article->save()) Cache::flush();
        return response($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete', [self::class]);
        $article = Article::FindOrFail($id);
        Comment::where('article_id', $id)->delete();
        Cache::flush();
        return response($article->delete());
    }
}
