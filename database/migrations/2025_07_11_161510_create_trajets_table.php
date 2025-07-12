<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conducteur_id')->constrained('utilisateurs');
            $table->string('pointDeDepart');
            $table->string('pointDArrivee');
            $table->dateTime('dateHeureDepart');
            $table->float('prixParPlace');
            $table->integer('placesDisponibles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};
