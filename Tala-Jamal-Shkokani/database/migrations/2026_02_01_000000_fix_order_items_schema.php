<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'product_name')) {
                $table->string('product_name')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('order_items', 'size')) {
                $table->string('size')->nullable()->after('price');
            }
            if (!Schema::hasColumn('order_items', 'color')) {
                $table->string('color')->nullable()->after('size');
            }
            if (!Schema::hasColumn('order_items', 'total')) {
                $table->decimal('total', 10, 2)->default(0)->after('price');
            }
            if (!Schema::hasColumn('order_items', 'product_variant_id')) {
                $table->unsignedBigInteger('product_variant_id')->nullable()->after('product_id');
                // Adding foreign key constraint if possible, or just index
                $table->index('product_variant_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('order_items', 'product_name'))
                $columns[] = 'product_name';
            if (Schema::hasColumn('order_items', 'size'))
                $columns[] = 'size';
            if (Schema::hasColumn('order_items', 'color'))
                $columns[] = 'color';
            if (Schema::hasColumn('order_items', 'total'))
                $columns[] = 'total';
            if (Schema::hasColumn('order_items', 'product_variant_id'))
                $columns[] = 'product_variant_id';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
