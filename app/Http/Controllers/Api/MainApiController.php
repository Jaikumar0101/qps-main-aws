<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainApiController extends Controller
{

    public function getPostsSelect2Data(Request $request)
    {
        $search = $request->has('search')?$request->input('search'):null;

        if(checkData($search))
        {
           $data =  BlogPost::select(['id',DB::raw("title as text")])
                ->where('title','LIKE',"%{$search}%")
                ->orderBy('id','desc')
                ->limit(20)
                ->get(['id','text'])
                ->toArray();
        }
        else
        {
            $data = BlogPost::select(['id',DB::raw("title as text")])
                ->orderBy('id','desc')
                ->limit(20)
                ->get(['id','text'])
                ->toArray();
        }
        return response()->json([
            'success'=>true,
            'data'=>$data,
        ]);
    }

}
