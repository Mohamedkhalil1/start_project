<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function __construct()
    {
        
    }
    public function index(){
        $categories = Category::selection()->get();
       return  $this->showAll('categories',$categories,1);
    }

    public function show(Request $request){
        $category = Category::Selection()->find($request->id);
        if($category === null){
            return $this->errorResponse("0010",'this is cateory not exist',404);
        }
        return $this->showOne('category',$category);
    }

    public function changeStatus(Request $request){
        $category = Category::Selection()->find($request->id);
        if($category === null){
            return $this->errorResponse("0010",'this is cateory not exist',404);
        }
        $category->active = !$category->active;
        $category->save();
        return $this->successMessage('1000','category has changed successfully');
    }
}
