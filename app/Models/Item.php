<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    function isStored(){
        return $this->hasMany(Storage::class);
    }
    function storageSpaces(){
        return $this->hasManyThrough(StorageSpace::class, Storage::class, '');
    }

    public function recipes(){
        return $this->hasMany(Recipe::class, 'output', 'id');
    }
    public function pivotedRecipes(){
        return $this->belongsToMany(Item::class, 'recipes', 'output', 'input')->withPivot('amount', 'id', 'from');
    }
}
