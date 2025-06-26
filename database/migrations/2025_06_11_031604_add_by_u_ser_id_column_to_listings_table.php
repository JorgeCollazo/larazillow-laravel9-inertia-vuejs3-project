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
        Schema::table('listings', function (Blueprint $table) {
            $table->foreignIdFor(                   // This enforces that there is a field called by_user_id on listings table that points to an existing user ID
                \App\Models\User::class,
                'by_user_id'
            )->constrained('users');        //->nullable() concatenate it if you were to need a nullable field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};
