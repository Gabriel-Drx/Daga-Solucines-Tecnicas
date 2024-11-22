<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArchivoColumnInFacturasTable extends Migration
{
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('archivo', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('archivo', 100)->change();
        });
    }
}
