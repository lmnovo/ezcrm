<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('photo');

            $table->integer('contact_type')->default(0)->comments('0-prospect, 1-client');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->removeColumn('lastname');
            $table->removeColumn('username');
            $table->removeColumn('email');
            $table->removeColumn('latitude');
            $table->removeColumn('longitude');
            $table->removeColumn('photo');
            $table->removeColumn('contact_type');
        });
    }
}
