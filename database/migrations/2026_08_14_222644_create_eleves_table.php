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
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->date('date_n');
            $table->string('lieu_n');
            $table->string('responsable');
            $table->string('tel_responsable');
            $table->text('adresse')->nullable();
            $table->foreignId('classe_id');
            $table->foreignId('annee_scolaire_id');
            $table->string('ecole_provenance')->nullable();
            $table->string('photo')->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->timestamps();

            // Un élève ne peut être inscrit qu'une seule fois par année
            $table->unique(['matricule', 'annee_scolaire_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
