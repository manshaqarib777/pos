<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVersionToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('version');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->string('version', 20)->default('1.88')->after('locale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('version');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->string('version', 20)->default('1.5')->after('locale');
            $table->timestamps();
        });
    }
}
