<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pharmacist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacist', function (Blueprint $table) {
            $table->char('id',36)->unique();
            $table->string('full_name');
            $table->string('email');
            $table->date('dob');
            $table->char('gender',6);
            $table->char('tel_number',10);
            $table->text('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharmacist');
    }
}
