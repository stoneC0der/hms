<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 15);
            $table->string('email')->unique()->nullable();
            $table->string('picture')->nullable();
            $table->string('occupation');
            $table->string('where')->comment('Company/School of work or school for student');
            $table->foreignId('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('tenants');
    }
}
