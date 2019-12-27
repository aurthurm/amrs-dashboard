<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255);
            $table->string('gender',50);
            $table->string('email',255);
            $table->date('dob');
            $table->string('password',500);
            $table->string('mobile_no',255);
            $table->string('alt_mobile_no',255);
            $table->string('address_line1',500);
            $table->string('address_line2',500);
            $table->string('username',255);
            $table->string('status',100);
            $table->string('created_by',255);
            $table->string('updated_by',255);
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
        Schema::dropIfExists('user');
    }
}
