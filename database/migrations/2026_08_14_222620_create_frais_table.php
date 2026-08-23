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
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->decimal('montant', 10, 2);
            $table->foreignId('classe_id');
            $table->foreignId('annee_scolaire_id');
            $table->enum('statut', ['actif', 'inactif'])->default('inactif');
            $table->string('devise', 10)->default('$');
            $table->date('date_limite')->nullable();
            $table->timestamps();

            // Un frais ne peut être défini qu'une fois par classe et par année
            $table->unique(['designation', 'classe_id', 'annee_scolaire_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frais');
    }
};
