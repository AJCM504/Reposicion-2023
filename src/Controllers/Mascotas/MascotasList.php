<?php
namespace Controllers\Mascotas;

use Controllers\PublicController;
use Dao\Mascotas\Mascotas;
use Views\Renderer;

class CategoriasList extends PublicController {
    public function run():void {
        $dataView = [];
        $dataView["mascotas"] = Mascotas::obtenerMascotas();

        Renderer::render('Mascotas/lista', $dataView);
    }
}