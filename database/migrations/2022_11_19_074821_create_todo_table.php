<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcat_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('start_time')->nullable();
            $table->string('recurring')->nullable();
            $table->string('who_it_for')->nullable();
            $table->integer('second_signature')->nullable();
            $table->integer('quick_log')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcat_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todo');
    }
}
