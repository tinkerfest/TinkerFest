<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('full_name');
            $table->string('email', 191);
            $table->string('team_id');
            $table->string('avatar')->nullable();
            $table->string('gender')->nullable();
            $table->string('birthday')->nullable();
            $table->string('mobile_number')->nullable();
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
        Schema::dropIfExists('members');
    }
}
