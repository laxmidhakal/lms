<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookHasAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_has_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->unsigned(); // fk to suppliers
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('author_id')->unsigned(); // fk to borrowers
            $table->foreign('author_id')->references('id')->on('authors');
            $table->integer('sort_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('created_by')->unsigned(); // fk to users
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_has_authors');
    }
}
