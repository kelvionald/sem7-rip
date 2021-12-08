<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $primaryKey = 'post_id';
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany('App\Models\Image', 'post_id');
    }

    public function toArray()
    {
        $post = parent::toArray();
        $post['images'] = $this->images;
        return $post;
    }
}
