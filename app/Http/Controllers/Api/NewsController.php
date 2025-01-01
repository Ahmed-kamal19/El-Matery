<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\App;

use App\Models\Faq;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsListResource;
use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    public function show($id)
    {
        try
        {
            $news                      = News::find($id);
    
            return new NewsResource($news);
        } catch (\Exception $e)
        {
            return $this->failure(message: $e->getMessage());
        }
    }


    public function index(){
        $news = News::all();
        return NewsListResource::collection($news);
    }

}
