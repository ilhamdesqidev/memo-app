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
            // Cek apakah kolom sudah ada sebelum menambahkan
            if (!Schema::hasColumn('memos', 'manager_signed')) {
                $table->boolean('manager_signed')->default(false);
            }
            
            if (!Schema::hasColumn('memos', 'approval_notes')) {
                $table->text('approval_notes')->nullable();
            }
            
            // Tambahan field untuk dual signature
            if (!Schema::hasColumn('memos', 'creator_signature_path')) {
                $table->string('creator_signature_path')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'creator_signed_at')) {
                $table->timestamp('creator_signed_at')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'manager_signature_path')) {
                $table->string('manager_signature_path')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'manager_signed_at')) {
                $table->timestamp('manager_signed_at')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'forwarded_by')) {
                $table->unsignedBigInteger('forwarded_by')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'forwarded_at')) {
                $table->timestamp('forwarded_at')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable();
            }
            
            if (!Schema::hasColumn('memos', 'rejection_date')) {
                $table->timestamp('rejection_date')->nullable();
            }
            
            // Add foreign key constraints if they don't exist
            if (Schema::hasColumn('memos', 'forwarded_by') && !Schema::hasColumn('memos', 'forwarded_by_foreign')) {
                $table->foreign('forwarded_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (Schema::hasColumn('memos', 'rejected_by') && !Schema::hasColumn('memos', 'rejected_by_foreign')) {
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('memos', function (Blueprint $table) {
            // Drop foreign keys first
            if (Schema::hasColumn('memos', 'forwarded_by')) {
                $table->dropForeign(['forwarded_by']);
            }
            
            if (Schema::hasColumn('memos', 'rejected_by')) {
                $table->dropForeign(['rejected_by']);
            }
            
            // Drop columns
            $columnsToRemove = [
                'manager_signed',
                'approval_notes',
                'creator_signature_path',
                'creator_signed_at',
                'manager_signature_path',
                'manager_signed_at',
                'forwarded_by',
                'forwarded_at',
                'rejected_by',
                'rejection_date'
            ];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('memos', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};