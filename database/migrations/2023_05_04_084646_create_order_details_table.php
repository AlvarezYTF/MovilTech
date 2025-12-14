<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->integer('unitcost');
            $table->integer('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('order_details')) {
            // Drop foreign keys if they exist
            try {
                Schema::table('order_details', function (Blueprint $table) {
                    $table->dropForeign(['order_id']);
                });
            } catch (\Exception $e) {
                // Foreign key might not exist or already dropped
            }
            
            try {
                Schema::table('order_details', function (Blueprint $table) {
                    $table->dropForeign(['product_id']);
                });
            } catch (\Exception $e) {
                // Foreign key might not exist or already dropped
            }
        }
        
        Schema::dropIfExists('order_details');
    }
};
