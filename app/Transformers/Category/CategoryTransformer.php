<?php

namespace App\Transformers\Category;

use App\Models\Category;
use App\Traits\GeneralTrait;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    use GeneralTrait;
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id'   => $category->id,
            'name'  => $category->name,
            'active' => (int)$category->active
        ];
    }
}
