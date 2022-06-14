<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->integer('currency_id')->default(97);
            $table->integer('timezone_id')->default(425);
            $table->string('clock_format')->default('H:i');
            $table->string('date_format')->default('Y-m-d');
            $table->string('datetime_format')->default('Y-m-d H:i');
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
        Schema::dropIfExists('system_settings');
    }
};
