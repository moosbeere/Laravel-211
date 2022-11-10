<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(){
        $articles = Article::paginate(5);
        return view('articles/index', ['articles' => $articles]);
    }

    public function create(){
        return view('articles/create');
    }
    
    public function store(){
        $article = new Article();
        $article->name = request('name');
        $article->date = request('date');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
    }

    public function show($id){
        //
    }
}
