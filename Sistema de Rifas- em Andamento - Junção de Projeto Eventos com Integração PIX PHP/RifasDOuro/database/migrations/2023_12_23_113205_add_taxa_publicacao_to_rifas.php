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
        Schema::table('rifas', function (Blueprint $table) {
            $table->decimal('taxa_publicacao', 10, 2)->before('status_cobranca_taxa_publicacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rifas', function (Blueprint $table) {
            $table->dropColumn('taxa_publicacao');
        });
    }
};
