<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Normalize french variant to english canonical values
        DB::table('annee_scolaires')->where('statut', 'active')->update(['statut' => 'actif']);
        DB::table('annee_scolaires')->where('statut', 'inactif')->update(['statut' => 'inactif']);


        DB::table('frais')->where('statut', 'active')->update(['statut' => 'actif']);
        DB::table('frais')->where('statut', 'inactive')->update(['statut' => 'inactif']);
    }

    public function down()
    {
        // revert normalization
        DB::table('annee_scolaires')->where('statut', 'active')->update(['statut' => 'actif']);
        DB::table('annee_scolaires')->where('statut', 'inactive')->update(['statut' => 'inactif']);


        DB::table('frais')->where('statut', 'active')->update(['statut' => 'actif']);
        DB::table('frais')->where('statut', 'inactive')->update(['statut' => 'inactif']);
    }
};
