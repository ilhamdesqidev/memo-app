<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfPathToMemosTable extends Migration
{
    public function up()
    {
        Schema::table('memos', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('signed_at');
        });
    }

    public function down()
    {
        Schema::table('memos', function (Blueprint $table) {
            $table->dropColumn('pdf_path');
        });
    }
}