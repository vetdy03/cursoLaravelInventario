<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id');
            $table->string('pr_imagen',200)->nullable();
            $table->string('pr_nombre',200)->nullable();
            $table->text('pr_descripcion')->nullable();
            $table->integer('pr_stock')->unsigned();
            $table->date('pr_fecha_reg');
            $table->enum('pr_estado',['ACTIVO','INACTIVO','ELIMINADO'])->default('ACTIVO');

            $table->timestamps();

            $table->unsignedBigInteger('categoria_id')->index('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
