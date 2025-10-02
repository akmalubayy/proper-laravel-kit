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
        Schema::create('menu_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->references('id')->on('menus')->constrained()->onDelete('cascade')->unsigned();
            $table->foreignId('role_id')->references('id')->on('roles')->constrained()->onDelete('cascade')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_role');
    }
};
