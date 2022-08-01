<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    public function user(){
        return $this->BelongsTo(User::class);
    }

    public function scopeFilter($query, array $filters){
        

        
            $filters=str_split(request('status'));
            foreach($filters as $filter){
                $query->orWhere('status', 'like',  $filter  );//->where('taken_by', 'like', 1)->orWhere('taken_by', 'like', null);
            }
            
             
        
        if ($filters['search']??false){
            $query->where('tags','like', '%'.request('search').'%')
            ->orWhere('description','like', '%'.request('search').'%')
            ->orWhere('name','like', '%'.request('search').'%');
        }
        

    }
}
