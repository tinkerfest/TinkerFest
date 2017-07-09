<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('post_master', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('p_id');
            $table->string('provider_id');
            $table->text('p_content');
            $table->text('p_short_dec');
            $table->text('p_title');
            $table->text('categories')->nullable();
            $table->string('is_latest')->default('1');
            $table->string('delete')->default('0');
            $table->text('uri')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
