<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id'];

    protected $fillable = [
        '_id', 'owner', 'origin', 'title', 'description', 'public', 'instrument', 'syllabus', 'type',
    ];

    protected $casts = [
        'public' => 'boolean',
    ];

}