<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_add_approval_fields_to_memos_table.php
public function up()
{
    Schema::table('memos', function (Blueprint $table) {
        $table->string('status')->default('pending');
        $table->foreignId('approved_by')->nullable()->after('status');
        $table->timestamp('approval_date')->nullable()->after('approved_by');
        $table->text('rejection_reason')->nullable()->after('approval_date');
    });
}

public function down()
{
    Schema::table('memos', function (Blueprint $table) {
        $table->dropColumn(['status', 'approved_by', 'approval_date', 'rejection_reason']);
    });
}
};
