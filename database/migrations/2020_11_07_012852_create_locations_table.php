<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
        $table->bigIncrements('id')->comment('ID de identificação da Localização');
            $table->ipAddress('ip')->comment('IP de Acesso');
            $table->decimal('latitude', 10, 8)->comment('Latitude');
            $table->decimal('longitude', 11, 8)->comment('Longitude');
            $table->string('cidade', 100)->comment('Nome da Cidade')->nullable();
            $table->string('estado', 2)->comment('Sigla do Estado')->nullable();
            $table->string('time_zone', 100)->comment('Fuso Horário')->nullable();
            $table->timestamps();
        });

        // PIVO
        Schema::create('location_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('location_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'location_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_user');
        Schema::dropIfExists('locations');
    }
}
