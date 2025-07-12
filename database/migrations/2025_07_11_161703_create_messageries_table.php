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
        Schema::create('messageries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur1_id')->constrained('utilisateurs');
            $table->foreignId('utilisateur2_id')->constrained('utilisateurs');
            $table->json('messages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messageries');
    }
};
