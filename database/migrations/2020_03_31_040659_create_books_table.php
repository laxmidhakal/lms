<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->text('information');
            $table->string('image')->nullable();
            $table->string('image_enc')->nullable();
            $table->string('worksheet')->nullable();
            $table->string('language')->nullable();
            $table->string('bookcode');
            $table->string('corporate_body')->nullable();
            $table->string('edition');
            $table->string('place');
            $table->string('year_of_publication');
            $table->text('physical_description_a');
            $table->text('physical_description_b')->nullable();
            $table->text('series_statement')->nullable();
            $table->text('note')->nullable();
            $table->string('broad_subject_heading');
            $table->text('keywords');
            $table->text('geographical_descriptors');
            $table->text('isbn')->nullable();
            $table->text('issn')->nullable();
            $table->string('country')->nullable();
            $table->string('language_of_text');
            $table->string('meeting')->nullable();
            $table->string('national_union_catologue_no')->nullable();
            $table->string('copyright_no')->nullable();
            $table->string('type_of_material');
            $table->string('accession_no');
            $table->integer('sort_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_pdf')->default(0);
            $table->integer('publisher_id')->unsigned(); // fk to publishers
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->integer('bookrack_id')->unsigned(); // fk to bookracks
            $table->foreign('bookrack_id')->references('id')->on('bookracks');
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
        Schema::dropIfExists('books');
    }
}
