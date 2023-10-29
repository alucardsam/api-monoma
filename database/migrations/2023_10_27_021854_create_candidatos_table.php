<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('source')->nullable();
            $table->foreignId('owner')->constrained('usuarios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('created_by')->constrained('usuarios')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
};
