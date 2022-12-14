<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Jobs\VeryLongJob;
use App\Http\Controllers\Controller;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('accept', null)->latest()->paginate(10);
        return response($comments);
    }

    public function accept(Comment $comment){
        $comment->accept = 1;
        return response($comment->save());
    }

    public function reject(Comment $comment){
        $comment->accept = 0;
        return response($comment->save());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment = new Comment();
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->article()->associate(request('id'));
        $comment->user()->associate(auth()->user());
        $result = $comment->save();
        $article = Article::where('id', $comment->article_id)->first();
        if ($request){
            VeryLongJob::dispatch($article, $comment);
        }
        return response()->json([
            'article_id'=>request('id'),
            'result'=>$result
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        return response($comment);
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
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->save();
        return response($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        return response()->json([
            'result'=>$comment->delete(),
            'article_id'=>$comment->article_id
        ]);
    }
}
