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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->date('borrowed_at');
            $table->date('returned_at');
            $table->string('condition', 100);
            $table->enum('status', ['dipinjam', 'dikembalikan']);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('borrowings');
    }
};
