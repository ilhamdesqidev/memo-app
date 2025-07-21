<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // In the migration file
public function up()
{
    Schema::table('memos', function (Blueprint $table) {
        // Remove unused column if exists
        if (Schema::hasColumn('memos', 'divisi_pengirim')) {
            $table->dropColumn('divisi_pengirim');
        }
        
        // Add new column if needed
        if (!Schema::hasColumn('memos', 'dibuat_oleh_user_id')) {
            $table->foreignId('dibuat_oleh_user_id')->constrained('users');
        }
    });
}

public function down()
{
    Schema::table('memos', function (Blueprint $table) {
        $table->string('divisi_pengirim')->nullable();
        $table->dropForeign(['dibuat_oleh_user_id']);
        $table->dropColumn('dibuat_oleh_user_id');
    });
}
};
