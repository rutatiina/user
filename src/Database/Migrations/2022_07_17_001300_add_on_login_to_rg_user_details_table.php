<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnLoginToRgUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rg_user_details', function (Blueprint $table) {
            $table->string('on_login', 250)->after('status')->default('show-dashboard')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rg_user_details', function (Blueprint $table) {
            $table->dropColumn('on_login');
        });
    }
}
