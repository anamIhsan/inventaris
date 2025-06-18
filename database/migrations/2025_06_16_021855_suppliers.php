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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->string('image',200);
            $table->string('address', 255);
            $table->string('phone', 20);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('suppliers');
    }
};
