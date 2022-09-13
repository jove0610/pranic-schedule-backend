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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->string('img_ref')->nullable();
            $table->date('date_start');
            $table->date('date_end');
            $table->timestamps();

            $table->index(['office_id', 'course_id', 'date_start', 'date_end']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
