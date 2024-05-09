<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleImages_M extends Model
{
    use HasFactory;
    protected $table = 'article_images';
    protected $guarded = [];


    /*******************************************/
    public function article()
    {
        return $this->belongsTo(Articles_M::class, 'article_id_fk', 'id'); // Specify foreign key and local key
    }
}
