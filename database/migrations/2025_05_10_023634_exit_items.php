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
        Schema::create('exit_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->date('date_out');
            $table->integer('quantity');
            $table->string('location', 255);
            $table->string('recipient', 255);
            $table->text('notes');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('exit_items');
    }
};
