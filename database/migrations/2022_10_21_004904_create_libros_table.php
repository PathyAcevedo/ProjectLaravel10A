<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string("isbn",15)->unique();
            $table->string("title",255);
            $table->date("description")->nullable();
            $table->date("published_date")->nullable();
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("editorial_id");

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('editorial_id')->references('id')->on('editoriales');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libros');
    }
}
