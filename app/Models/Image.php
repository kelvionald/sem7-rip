<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'image';
    protected $primaryKey = 'image_id';
    protected $guarded = [];
    public $timestamps = false;

    public function getUrl()
    {
        return env('AWS_ENDPOINT') . '/' . env('AWS_BUCKET') . '/' . $this->yc_key;
    }

    public function toArray()
    {
        $arr = parent::toArray();
        $arr['url'] = $this->getUrl();
        return $arr;
    }
}
