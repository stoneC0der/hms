<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('room_id')->index();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreignId('tenant_id')->index();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->integer('duration');
            $table->date('from');
            $table->date('to');
            $table->boolean('expired');
            $table->char('currency', 3);
            $table->decimal('amount');
            $table->decimal('balance')->nullable(); // negative if owing or positive is has a balance.
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
        Schema::dropIfExists('rents');
    }
}
