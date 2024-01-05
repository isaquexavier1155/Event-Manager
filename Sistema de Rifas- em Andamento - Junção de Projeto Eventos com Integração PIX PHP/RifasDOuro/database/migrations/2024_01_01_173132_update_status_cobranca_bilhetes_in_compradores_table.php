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
        // Atualiza todos os registros existentes para 'ATIVA'
        \DB::table('compradores')->update(['status_cobranca_bilhetes' => 'ATIVA']);
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compradores', function (Blueprint $table) {
            //
        });
    }
};
