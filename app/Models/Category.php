<?php

namespace App\Models;

use App\Transformers\Category\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name_ar','name_en','active','created_at','updated_at'];
    public $transformer = CategoryTransformer::class;
    public function scopeSelection($query){
        return $query->select('id','name_'.app()->getLocale().' as name','active');
    }
}
