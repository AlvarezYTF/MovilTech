<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('payment_method_code', 10)->nullable()->after('status');
            $table->string('payment_form_code', 10)->nullable()->after('payment_method_code');
            
            $table->foreign('payment_method_code')->references('code')->on('dian_payment_methods')->onDelete('set null');
            $table->foreign('payment_form_code')->references('code')->on('dian_payment_forms')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['payment_method_code']);
            $table->dropForeign(['payment_form_code']);
            $table->dropColumn(['payment_method_code', 'payment_form_code']);
        });
    }
};

