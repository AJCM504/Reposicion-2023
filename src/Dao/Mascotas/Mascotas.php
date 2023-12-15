<?php 

namespace Dao\Mascotas;

use Dao\Table;

class Mascotas extends Table {

    public static function obtenerMascotas() {
        $sqlstr = "SELECT * from Mascotas";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerMascotaPorId ($id) {
        $sqlstr = "SELECT * from Mascotas where id=:id;";
        $params = ["id"=>$id];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function crearMascota(
        $name,
        $status,
        $edad,
        $raza
    ) {
        $params = [
            "name" => $name,
            "status" => $status,
            "edad" => $edad,
            "raza" => $raza
        ];
        $sqlstr = "INSERT INTO Mascotas (name, status, edad, raza, create_time) values(:name, :status, :edad, :raza, NOW());";
        return self::executeNonQuery($sqlstr, $params);

    }

    public static function actualizarMascota($id, $name, $status, $edad, $raza) {
        $sqlstr = "UPDATE Mascotas set name=:name, status=:status, edad=:edad, raza=:raza where id=:id;";
        $params = [
            "name" => $name,
            "status" => $status,
            "edad" => $edad,
            "raza" => $raza,
            "id" => $id
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteMascota($id) {
        $sqlstr = "DELETE from Mascotas where id=:id;";
        $params = [
            "id" => $id
        ];
        return self::executeNonQuery($sqlstr, $params);
    }
}