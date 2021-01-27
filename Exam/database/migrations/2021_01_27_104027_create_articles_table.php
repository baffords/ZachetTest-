<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{

    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
          $table->id();
          $table->string('short_text');
          $table->string('text');
          $table->string('author_name');
          $table->timestamps();  });
    }
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
