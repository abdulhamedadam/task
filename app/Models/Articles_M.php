<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles_M extends Model
{
    use HasFactory;
    protected $table = 'articles';
    protected $guarded = [];
    /*******************************************/
    public function images()
    {
        return $this->hasMany(ArticleImages_M::class, 'article_id_fk', 'id'); // Specify foreign key and local key
    }
}
