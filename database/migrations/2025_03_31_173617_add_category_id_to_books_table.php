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
    Schema::table('books', function (Blueprint $table) {
        $table->unsignedBigInteger('category_id')->nullable();

        // Si tu veux faire une vraie relation :
        // $table->foreign('category_id')->references('id')->on('categories');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('books', function (Blueprint $table) {
        // $table->dropForeign(['category_id']); // à décommenter si tu as mis la foreign key
        $table->dropColumn('category_id');
    });
}

};
