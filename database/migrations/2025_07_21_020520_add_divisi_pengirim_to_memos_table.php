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
    Schema::table('memos', function (Blueprint $table) {
        $table->string('divisi_pengirim')->after('divisi_tujuan');
    });
}

public function down()
{
    Schema::table('memos', function (Blueprint $table) {
        $table->dropColumn('divisi_pengirim');
    });
}
};
