<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poems extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($poems) {
            $poem = Poems::query()
                ->where('title', '=', $poems->title)
                ->where('body', '', $poems->body);

            return $poem->exists();
        });
    }

    public function getTitle()
    {
        return $this->title;
    }
}
