<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [ 'name', ];

    public function topics()
    {
        // return $this->hasManyThrough(Sub);
    }
}
