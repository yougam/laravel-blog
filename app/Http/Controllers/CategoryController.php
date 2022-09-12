<?php

namespace App\Http\Controllers;

use \App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        //return response()->json([], 200); // 형식을 명확하게 표현, 취향 선호이긴 함
        return Category::all();
    }

    public function create(Request $request) {
        // 간단하게, 실제로는 폼검증도 필요
        return Category::create( $request->only(['name']));
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();

        return $category;
        
    }

    public function delete($id) {
        Category::where('id', $id)->delete();
        return ['message' => '삭제되었습니다.'];
        
    }
}
