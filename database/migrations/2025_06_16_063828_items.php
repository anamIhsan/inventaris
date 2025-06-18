<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name', 200);
            $table->string('image',200);
            $table->string('condition', 100);
            $table->string('price', 100);
            $table->string('funding_source', 150);
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('items');
    }
};
