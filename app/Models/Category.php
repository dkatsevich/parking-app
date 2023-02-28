<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function scopeProductsByCategory(Builder $builder, $id)
    {
        $allCategories = self::all();

        $list = [$id];

        $this->getCategoriesList($list, $id, $allCategories);

        return Product::whereIn('category_id', $list)->where('qty', '<>', 0)->get();
    }


    private function getCategoriesList(&$list, $id, $allCategories)
    {
        $subCategoriesIdList = $allCategories->where('parent_id', $id)->pluck('id')->toArray();

        $list += $subCategoriesIdList;

        foreach ($subCategoriesIdList  as $subCategoryId) {
            if (count($allCategories->where('parent_id', $subCategoryId))) {
                $this->getCategoriesList($list, $subCategoryId, $allCategories);
            }
        }
    }


    public function scopeTree()
    {
        $allCategories = self::all();
        $rootCategories = $allCategories->whereNull('parent_id');

       $this->formatTree($allCategories, $rootCategories);

        return $rootCategories;
    }


    private function formatTree($allCategories, $categories)
    {
        foreach ($categories as $category) {
            $children = $allCategories->where('parent_id', $category->id)->values();

            if (count($children)) {
                $category->children = $children;
           
                if (count($category->children)) {
                    $this->formatTree($allCategories, $category->children);
                }
            }

           
        }
    }

   
}
