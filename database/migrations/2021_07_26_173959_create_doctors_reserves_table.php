<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors_reserves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('expertise_id');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('time_id');
            $table->date('date');
            $table->enum('status', \App\Models\DoctorReserve::$statuses)
                ->default(\App\Models\DoctorReserve::UNVISITED);
            $table->timestamps();

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('expertise_id')
                ->references('id')
                ->on('expertises')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('time_id')
                ->references('id')
                ->on('doctors_times')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors_reserves');
    }
}
