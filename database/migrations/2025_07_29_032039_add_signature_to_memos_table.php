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
        Schema::table('memos', function (Blueprint $table) {
            $table->boolean('include_signature')->default(false);
            $table->string('signature_path')->nullable();
            $table->unsignedBigInteger('signed_by')->nullable();
            $table->timestamp('signed_at')->nullable();
            
            $table->foreign('signed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            //
        });
    }
};
