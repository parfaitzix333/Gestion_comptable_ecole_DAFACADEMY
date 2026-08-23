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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->foreignId('eleve_id');
            $table->foreignId('frais_id');
            $table->foreignId('classe_id');
            $table->foreignId('annee_scolaire_id');
            $table->date('date_limite');
            $table->string('mode_paiement'); // ex: "Espèces", "Mobile Money", "Virement"
            $table->string('devise', 10)->default('$');
            $table->enum('statut', ['acompte', 'payé'])->default('acompte');
            $table->string('montant_en_lettre')->nullable();
            $table->timestamps();

            // Un élève ne peut payer qu'une seule fois un frais spécifique
            $table->unique(['eleve_id', 'frais_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
