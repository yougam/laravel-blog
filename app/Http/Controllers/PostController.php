<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        //$posts = Post::orderBy('created_at', 'desc')->get();
        $posts = Post::orderBy('created_at', 'desc')->with(['categories', 'comments'])->get();
        
        // collection 사용예제
        // $filtered = $posts->filter(function($value){
        //     return $value->id%2 === 0;
        // });
        // return $filtered;
        // return $posts->count();
        
        return response()->json($posts);
        //return response()->json( Post::all() );
    }

    public function create( Request $request ) {
        //validate 편의 제공
        // $request->validate([
        //     'subject' => 'required',
        //     'content' => 'required'
        // ]);
        

        // $subject = $request->input('subject');
        // $content = $request->input('content');
        // $post = new Post();
        // $post->subject = $subject;
        // $post->content = $content;
        // $post->save();
        
        
        //Model에서 $fillable를 설정해서 아래와 같이 간단히 표현이 가능
        
        $params = $request->only(['subject', 'content']);
        $post = Post::create($params);
        $ids = $request->input('category_ids');
        $post->categories()->sync($ids); // attach, detach, sync 로 이용, 가능하다면 aync로 이용해서 간단하게
        return response()->json($post);
    }
    
    public function read($id){
        //$post = Post::where('id', $id)->first(); //id를 가지고 first를 가져오는 형식이 많이 사용하기 때문에 축약 형태로 제공 //get()은 여러개를 가져올 수 잇음
        //$post = Post::find($id); //웨에 내용 축약식
        $post = Post::where('id', $id)->with('comments')->first();
        return response()->json($post);
    }

    public function update(Request $request, $id) {
        $post = Post::find($id);
        
        if(!$post) {
            return response()->json(['message' => '조회할 테이터가 없습니다.'], 404);
        }

        $subject = $request->input('subject');
        $content = $request->input('content');
        $ids = $request->input('category_ids');        
        
        if($subject) $post->subject = $subject;
        if($content) $post->content = $content;
        $post->save();
        $post->categories()->sync($ids); // attach, detach, sync 로 이용, 가능하다면 aync로 이용해서 간단하게

        return response()->json($post);
    }


    public function delete($id) {
        // Post::where('id', $id)-> delete(); // 검증하지 않고 삭제를 해달라는 요청(없어도 ok 있는경우 삭제하고 ok일 때)일 경우 이와같이 표현
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => '조회할 테이터가 없습니다.'], 404);
        }
        $post->delete();

        return response()->json(['message' => '삭제되었습니다.']);
        
    }
}
