<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW ordenes_vw AS
            SELECT 
                clientes.nombre AS nombre_cliente,
                ordenes.mesa,
                GROUP_CONCAT(CONCAT(platillos.nombre, '(', orden_platillos.cantidad, ')') ORDER BY platillos.nombre SEPARATOR ', ') AS platillos,
                SUM(platillos.precio * orden_platillos.cantidad) AS precio_total,
                ordenes.tipo_orden
            FROM ordenes
            JOIN orden_platillos ON ordenes.id = orden_platillos.orden_id
            JOIN platillos ON orden_platillos.platillo_id = platillos.id
            JOIN clientes ON ordenes.id_cliente = clientes.id
            GROUP BY ordenes.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS ordenes_vw");
    }
};
