<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poems extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function getTitle()
    {
        return $this->title;
    }
}
