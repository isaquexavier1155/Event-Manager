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
        Schema::table('compradores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_campanha')->after('numeros_escolhidos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compradores', function (Blueprint $table) {
            $table->dropColumn('id_campanha');
        });
    }
};
