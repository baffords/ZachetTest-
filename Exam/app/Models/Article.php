<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
protected $fillable = [

  "short_text",
  "text",
  "author_name"
];
}
