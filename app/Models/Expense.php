<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters){
        if($filters['max']??false){
            $query->where('amount', '<=', request('max') );
        }
        if($filters['min']??false){
            $query->where('amount', '>=', request('min') );
        }
        if ($filters['search']??false){
            $query->where('description','like', '%'.request('search').'%');
        }
        if($filters['user']??false){
            $query->where('user_id',  request('user') );
        }
        if($filters['until']??false && $filters['since'] ??false){
            $query->whereBetween('created_at', [request('since'), request('until')]);
        }

    }
}
