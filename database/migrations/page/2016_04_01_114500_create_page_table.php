<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if( !Schema::hasTable('page') ) {
            Schema::create('page', function(Blueprint $table){

                $table->engine = "InnoDB";
                $table->string('id')->primary();
                $table->string('title');
                $table->string('slug');
                $table->text('content');
                $table->string('user_id');

                $table->timestamp('published_at')->nullable()->default(null);
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
        //
        Schema::drop('page');
    }
}
