<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use App\Events\PublicArticle;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\PublicArticleNotify;
use App\Models\User;
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
        return response()->json($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('articles.create');
        return response('1', 201);
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
        $caches = DB::table('cache')
                ->whereRaw('`key` GLOB :name', ['name'=>'*[0-9]'])
                ->get();
        foreach($caches as $cache){
            // Log::alert($cache->key);
            Cache::forget($cache->key);
        }
        
        $request->validate([
            'name' => 'required',
            'annotation' => 'required'
        ]);

        $article = new Article();
        // $article->date = request('date');
        $article->date = $request->date;
        $article->name = request('name');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $result = $article->save();
        $users = User::where('id', '!=', auth()->id())->get();
        if ($result){
            Notification::send($users, new PublicArticleNotify($article));
            PublicArticle::dispatch($article);
        }
        return response()->json($article, 201);

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
        $comments = Comment::where([
                        ['article_id',$id],
                        ['accept', 1]
                    ])->latest()->get();
        return view('articles.show', ['article'=>$article, 'comments'=>$comments]);
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
        return view('articles.edit', ['article'=>$article]);
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
            'date' => 'required|date',
            'name' => 'required',
            'annotation' => 'required',
        ]);
        $article = Article::FindOrFail($id);
        $article->date = request('date');
        $article->name = request('name');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        if ($article->save()) Cache::forget('article:'.$id.'_show');
        return redirect('/articles/'.$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id){
        Cache::flush();
        $article = Article::FindOrFail($id);
        Comment::where('article_id', $id)->delete();
        $article->delete();
        return redirect('/');
    }
}
