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
        // Verifica si la tabla 'notes' existe y añade la columna.
        Schema::table('notas', function (Blueprint $table) {
            // 1. Crear la columna 'user_id'
            // unsignedBigInteger es el tipo de datos que coincide con el ID de la tabla 'users'.
            $table->unsignedBigInteger('user_id')->after('id'); // Colócala después de 'id'

            // 2. Establecer la clave foránea
            // Esto asegura que cada 'user_id' en 'notes' debe existir en la tabla 'users'.
            // También establece el comportamiento ON DELETE CASCADE: si un usuario es eliminado,
            // todas sus notas asociadas también se eliminarán automáticamente.
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Define cómo revertir la migración (eliminar la columna y la clave foránea).
        Schema::table('notes', function (Blueprint $table) {
            // Eliminar la clave foránea primero
            $table->dropForeign(['user_id']); 
            
            // Eliminar la columna
            $table->dropColumn('user_id');
        });
    }
};
