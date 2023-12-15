<?php

namespace Controllers\Mascotas;

use Controllers\PublicController;
use Dao\Mascotas\Mascotas as MascotasDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class MascotasForm extends PublicController
{

    private $listUrl = "index.php?page=Mascotas-MascotasList";
    private $mode = 'INS';
    private $viewData = [];
    private $error = [];
    private $xss_token = '';
    private $modes = [
        "INS" => "Creando nueva mascota",
        "UPD" => "Editando %s (%s)",
        "DEL" => "Eliminando %s (%s)",
        "DSP" => "Detalle de  %s (%s)"
    ];
    private $mascota = [
        "id" => -1,
        "name" => "",
        "status" => "ACT",
        "create_time" => "",
        "edad" => 0,
        "raza" => ""
    ];


    public function run(): void
    {
        $this->init();
        if ($this->isPostBack()) {
            if ($this->validateFormData()) {
                $this->mascota["name"] = $_POST["name"];
                $this->mascota["status"] = $_POST["status"];
                $this->processAction();
            }
        }
        $this->prepareViewData();
        $this->render();
    }

    private function init()
    {
        if (isset($_GET["mode"])) {
            if (isset($this->modes[$_GET["mode"]])) {
                $this->mode = $_GET["mode"];
                if ($this->mode !== "INS") {
                    if (isset($_GET["id"])) {
                        $this->mascota = MascotasDAO::obtenerMascotaPorId(intval($_GET["id"]));
                    }
                }
            } else {
                $this->handleError("Oops, el programa no encuentra el modo solicitado, intente de nuevo.");
            }
        } else {
            $this->handleError("Oops, el programa falló, intente de nuevo.");
        }
    }

    private function validateFormData()
    {
        // Validar XSS Data
        if (isset($_POST["xss-token"])) {
            $this->xss_token = $_POST["xss-token"];
            if ($_SESSION["xss_token_mascota_form"] !== $this->xss_token) {
                error_log("MascotasForm: Validacion de XSS Falló");
                $this->handleError("Error al procesar la peticion");
                return false;
            }
        } else {
            error_log("MascotasForm: Validacion de XSS Falló");
            $this->handleError("Error al procesar la peticion");
            return false;
        }

        if (Validators::IsEmpty($_POST["name"])) {
            $this->error["name_error"] = "Campo es requerido";
        }

        if (Validators::IsEmpty($_POST["edad"])) {
            $this->error["edad_error"] = "Campo es requerido";
        }
        if (Validators::IsEmpty($_POST["raza"])) {
            $this->error["raza_error"] = "Campo es requerido";
        }

        if (!in_array($_POST["status"], ["INA", "ACT", "CON"])) {
            $this->error["status_error"] = "Estado de la mascota es inválido.";
        }
        return count($this->error) == 0;
    }

    private function processAction()
    {
        switch ($this->mode) {
            case 'INS':
                if (
                    MascotasDAO::crearMascota(
                        $this->mascota["name"],
                        $this->mascota["status"],
                        $this->mascota["edad"],
                        $this->mascota["raza"]
                    )
                ) {
                    Site::redirectToWithMsg($this->listUrl, "Mascota creada exitosamente.");
                }
                break;
            case 'UPD':
                if (
                    MascotasDAO::actualizarMascota(
                        $this->mascota["id"],
                        $this->mascota["name"],
                        $this->mascota["status"],
                        $this->mascota["edad"],
                        $this->mascota["raza"]
                    )
                ) {
                    Site::redirectToWithMsg($this->listUrl, "Mascota actualizada exitosamente.");
                }
                break;
            case 'DEL':
                if (
                    MascotasDAO::deleteMascota(
                        $this->mascota["id"]
                    )
                ) {
                    Site::redirectToWithMsg($this->listUrl, "Mascota eliminada exitosamente.");
                }
                break;
        }
    }

    private function prepareViewData(){
        $this->viewData["mode"] = $this->mode;
        $this->viewData["mascota"] = $this->mascota;
        if ($this->mode == "INS") {
            $this->viewData["modedsc"] = $this->modes[$this->mode];
        } else {
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->mode],
                $this->mascota["name"],
                $this->mascota["id"],
                $this->mascota["edad"],
                $this->mascota["raza"],
            );
        }
        //setting category Select values
        $this->viewData["mascota"][$this->mascota["status"]."_selected"] = 'selected';
        //add errors from Form Input
        foreach ($this->error as $key => $error){
            $this->viewData["mascota"][$key] = $error;
        }
        $this->viewData["readonly"] = in_array($this->mode, ["DSP","DEL"]) ? 'readonly': '';
        $this->viewData["showConfirm"] = $this->mode !== "DSP"; 

        // Protegiendo de XSS attacks
        $this->xss_token = md5("mascotaForm".date('Ymdhisu'));
        $_SESSION["xss_token_mascota_form"] = $this->xss_token;
        $this->viewData["xss_token"] = $this->xss_token; 
    }

    private function render(){
        Renderer::render("Mascotas/form", $this->viewData);
    }

    private function handleError($errMsg){
        Site::redirectToWithMsg($this->listUrl, $errMsg);
    }
}