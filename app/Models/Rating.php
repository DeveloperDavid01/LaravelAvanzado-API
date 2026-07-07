<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    prorected $table = 'ratings';

    public function rateable()
    {
        return $this->morphTo();
    }

    public function qualifier()
    {
        return $this->morphTo();
    }
}
