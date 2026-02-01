<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up()
{
    
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->string('customer_name');
        $table->string('customer_email');
        $table->text('comment');
        $table->unsignedTinyInteger('rating')->default(5);
        $table->boolean('is_approved')->default(false);
        $table->timestamps();
    });

}

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};