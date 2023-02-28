<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $guarded = [];


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
