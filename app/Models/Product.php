<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['tags']??false){
            $query->where('tags', 'like', '%' . request('tags'). '%' );
        }
        if ($filters['search']??false){
            $query->where('tags','like', '%'.request('search').'%')
            ->orWhere('description','like', '%'.request('search').'%')
            ->orWhere('name','like', '%'.request('search').'%');
        }

    }

    public function item(){
        //if($this->item_id != 0){
          return $this->belongsTo(Item::class);  
        //}
        
    }
}
