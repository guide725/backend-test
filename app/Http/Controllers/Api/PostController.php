<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAuth', ['except'=>['show','index']]);
        // $this->middleware('auth:api', ['except'=>['show','index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $size = 10;
        $p = request('p') ? request('p') : 1;  
        $skip = ($p - 1) * $size;
        $data = Post::where('published', '1')->orderBy('created_at', 'desc')->offset($skip)->limit($size)->get();
        if (count($data) == 0){
            return response()->json(['status'=>false , "message"=>"Bad request"],400);
        }
            return response()->json(["status"=>true , "data"=>$data , "cuttent_page"=>$p ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['author'] = Auth::guard('api')->user()->username;
        $validator = Validator::make($request->all(), [
            'title'=>'required|min:3' , 'content'=>'required|min:3' ,  'published'=>'required' ,'author'=>"required"
        ]);
        if ($validator->fails()){
            return response()->json(["status"=>false , "message"=>$validator->errors()],400);
        }
        Post::create($request->all());
        return response()->json(["status"=>true , "data"=>$validator , "message"=>"create success"], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Post::where('id', $id)->firstOrFail();
        if (count($data) == 0){
            return response()->json(['status'=>false , "message"=>"Bad request"],400);
        }
        // $newDateFormat = $data->created_at->format('d/m/Y H:i:s');
        return response()->json(["status"=>true , "data"=> $data , "message"=>"success"], 200);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required|min:3' , 'content'=>'required|min:3' ,  'published'=>'required'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $post->update($request->all());
        return response()->json(["status"=>true , "data"=>$request->all() , "message"=>"publish success"], 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function published($id)
    {
        // I didn't check if it was published or not
        $data = Post::where('id', $id)->update(['published' => 1]);
        if ($data == 1){
            return response()->json(["status"=>true , "message"=>"publish success"], 200);
        }
        return response()->json(["status"=> false , "message"=>"Bad request"], 400);

        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(["status"=>true , "data"=> $id , "message"=>"destroy success"], 200);
    }
}
