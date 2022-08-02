<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Writeoff extends Model
{
    use HasFactory;

    public function storage(){
        return $this->hasOne(StorageSpace::class);
    }
    

    public function item(){
        return $this->hasOne(Item::class);
    }

    public function madeBy(){
        return $this->hasOne(User::class);
    }
}
