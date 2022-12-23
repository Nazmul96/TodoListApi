<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcat_id');
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('logs');
    }
}
