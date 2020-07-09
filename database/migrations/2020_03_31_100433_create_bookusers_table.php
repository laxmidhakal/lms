<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookusers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->unsigned(); // fk to suppliers
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('borrow_id')->unsigned(); // fk to suppliers
            $table->foreign('borrow_id')->references('id')->on('borrowers');
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
        Schema::dropIfExists('bookusers');
    }
}
