<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('eazy_contacts')) {
            Schema::create('eazy_contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('lastname');
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->string('address');
                $table->string('phone');
                $table->string('other_phone');
                $table->string('latitude');
                $table->string('longitude');
                $table->string('photo');

                $table->integer('contact_type')->default(0)->comments('0-prospect, 1-client');

                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eazy_contacts');
    }
}
