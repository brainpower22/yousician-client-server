<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $table = 'collections_items';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id'];

    protected $fillable = [
        'collection_id', 'type', 'item_id', 'instrument', 'syllabus'
    ];

}