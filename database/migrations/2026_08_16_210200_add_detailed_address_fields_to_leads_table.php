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
        Schema::table('leads', function (Blueprint $table) {
            $table->string('origin_street')->nullable()->after('origin');
            $table->string('origin_province')->nullable()->after('origin_street');
            $table->string('origin_postal_code')->nullable()->after('origin_province');
            $table->string('destination_street')->nullable()->after('destination');
            $table->string('destination_province')->nullable()->after('destination_street');
            $table->string('destination_postal_code')->nullable()->after('destination_province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn([
                'origin_street',
                'origin_province',
                'origin_postal_code',
                'destination_street',
                'destination_province',
                'destination_postal_code',
            ]);
        });
    }
};
