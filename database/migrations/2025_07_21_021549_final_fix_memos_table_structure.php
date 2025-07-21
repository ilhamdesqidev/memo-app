<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FinalFixMemosTableStructure extends Migration
{
    public function up()
    {
        Schema::table('memos', function (Blueprint $table) {
            // Check if column exists before trying to add it
            if (!Schema::hasColumn('memos', 'dibuat_oleh_user_id')) {
                $table->unsignedBigInteger('dibuat_oleh_user_id')->nullable()->after('divisi_tujuan');
            }

            // Remove unused column if exists
            if (Schema::hasColumn('memos', 'divisi_pengirim')) {
                $table->dropColumn('divisi_pengirim');
            }
        });

        // Update existing records with a valid user ID
        $defaultUserId = DB::table('users')->value('id') ?? 1; // Get first user or default to 1
        DB::table('memos')
            ->whereNull('dibuat_oleh_user_id')
            ->orWhereNotIn('dibuat_oleh_user_id', DB::table('users')->pluck('id'))
            ->update(['dibuat_oleh_user_id' => $defaultUserId]);

        // Add foreign key constraint
        Schema::table('memos', function (Blueprint $table) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
                WHERE TABLE_NAME = 'memos' 
                AND CONSTRAINT_TYPE = 'FOREIGN KEY'"
            );

            $foreignKeyExists = collect($foreignKeys)->contains(function ($key) {
                return str_contains($key->CONSTRAINT_NAME, 'dibuat_oleh_user_id');
            });

            if (!$foreignKeyExists) {
                $table->foreign('dibuat_oleh_user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('memos', function (Blueprint $table) {
            // Drop foreign key if exists
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS 
                WHERE TABLE_NAME = 'memos' 
                AND CONSTRAINT_TYPE = 'FOREIGN KEY'"
            );

            foreach ($foreignKeys as $key) {
                if (str_contains($key->CONSTRAINT_NAME, 'dibuat_oleh_user_id')) {
                    $table->dropForeign([$key->CONSTRAINT_NAME]);
                }
            }
            
            // Then drop the column
            if (Schema::hasColumn('memos', 'dibuat_oleh_user_id')) {
                $table->dropColumn('dibuat_oleh_user_id');
            }
            
            // Recreate old column if needed
            if (!Schema::hasColumn('memos', 'divisi_pengirim')) {
                $table->string('divisi_pengirim')->nullable();
            }
        });
    }

};
