<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors_about', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->unique();
            $table->unsignedBigInteger('clerk_id')->unique();
            $table->unsignedBigInteger('expertise_id');
            $table->string('experience');
            $table->text('specialized_fields');
            $table->string('specialty')->nullable();
            $table->string('science_bar')->nullable();
            $table->string('fluent_languages')->nullable();
            $table->string('place_of_degrees_of_degrees')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('clerk_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('expertise_id')
                ->references('id')
                ->on('expertises')
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
        Schema::dropIfExists('doctors_about');
    }
}
