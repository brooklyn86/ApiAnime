<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_api');
            $table->string('title');
            $table->string('slug');
            $table->string('link');
            $table->string('formato');
            $table->string('genero');
            $table->string('tipo_ep');
            $table->string('status_anime');
            $table->string('ano_lancamento');
            $table->text('image_dafault');
            $table->text('sinopse');
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
        Schema::dropIfExists('animes');
    }
}
