<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('stock_adjustments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('book_id')->constrained()->onDelete('cascade');
    $table->integer('previous_stock');
    $table->integer('quantity_change');
    $table->integer('new_stock');
    $table->string('reason')->nullable();
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('stock_adjustments');
    }
};