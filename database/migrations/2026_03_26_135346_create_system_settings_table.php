<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->default('Acme Corporation');
            $table->string('fiscal_year')->default('Jan - Dec');
            $table->string('currency')->default('USD ($)');
            $table->string('time_zone')->default('EST (UTC-5)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};