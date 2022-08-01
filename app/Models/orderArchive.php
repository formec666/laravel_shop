<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderArchive extends Model
{
    use HasFactory;
    protected $table = 'order_archive';

    public function scopeFilter($query, array $filters){
        if ($filters['search']??false){
            $query->where('status','like', '%'.request('search').'%')
            ->orWhere('invoiceName','like', '%'.request('search').'%')
            ->orWhere('address','like', '%'.request('search').'%')
            ->orWhere('invoiceAddress','like', '%'.request('search').'%')
            ->orWhere('email','like', '%'.request('search').'%')
            ->orWhere('archived_by','like', '%'.request('search').'%')
            ->orWhere('user_id','like', '%'.request('search').'%')
            ->orWhere('name','like', '%'.request('search').'%');
        }

    }
}
