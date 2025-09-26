<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = ['name','phone','email','activite'];

    public function contents(){
        return $this->hasMany(Content::class);
    }
}
