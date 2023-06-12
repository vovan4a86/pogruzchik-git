<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCraneSparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crane_spares', function (Blueprint $table) {
            $table->id();
            $table->string('cat_root');
            $table->string('cat_child');
            $table->string('cat_grandchild');
            $table->string('cat_translate');
            $table->string('name');
            $table->string('translate');
            $table->string('articul');
            $table->string('parse_image');
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
        Schema::dropIfExists('crane_spares');
    }
}
