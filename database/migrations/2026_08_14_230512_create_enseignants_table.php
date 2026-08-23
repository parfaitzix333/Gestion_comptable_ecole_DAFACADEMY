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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('matricule')->unique();
            $table->foreignId('classe_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->timestamps();
            // Un enseignant ne peut être affecté qu'à une seule classe par année
            $table->unique(['user_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
