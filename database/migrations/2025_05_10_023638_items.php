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
            $table->string('name', 200);
            $table->string('image',200);
            $table->text('specification');
            $table->string('location', 150);
            $table->string('condition', 100);
            $table->integer('quantity');
            $table->string('funding_source', 150);
            $table->text('description')->nullable();
            $table->enum('item_type', ['sarana', 'prasarana']);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('items');
    }
};
