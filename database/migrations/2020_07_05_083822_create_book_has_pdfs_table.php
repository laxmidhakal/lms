<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookHasPdfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_has_pdfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('pdf')->nullable();
            $table->string('pdf_enc')->nullable();
            $table->integer('book_id')->unsigned(); 
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('sort_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->integer('created_by')->unsigned(); 
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
        Schema::dropIfExists('book_has_pdfs');
    }
}
