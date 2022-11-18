<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('f_name');
            $table->string('l_name');
            $table->string('ff_name')->nullable();
            $table->string('mobile', 11)->unique();
            $table->string('national_code', 10)->unique();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->enum('sex', User::$sex);
            $table->string('password');
            $table->enum('status', User::$statuses)->default(User::INACTIVE);
            $table->enum('role', User::$roles);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('media')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
