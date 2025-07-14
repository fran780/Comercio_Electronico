<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Funciones\Funciones as DaoFunciones;
use Utilities\Site;
use Utilities\Validators;

class Funcion extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de %s",
        "INS" => "Nueva Función",
        "UPD" => "Editar %s",
        "DEL" => "Eliminar %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $funcion = [
        "fncod" => "",
        "fndsc" => "",
        "fnest" => "ACT",
        "fntyp" => ""
    ];
    private $funcion_xss_token = "";

    public function run(): void
    {
        try {
            $this->getData();
            if ($this->isPostBack()) {
                if ($this->validateData()) {
                    $this->handlePostAction();
                }
            }
            $this->setViewData();
            Renderer::render("funciones/funcion", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";
        if (isset($this->modeDescriptions[$this->mode])) {
            $this->readonly = $this->mode === "DEL" ? "readonly" : "";
            $this->showCommitBtn = $this->mode !== "DSP";
            if ($this->mode !== "INS") {
                $this->funcion = DaoFunciones::getFuncionById(strval($_GET["fncod"]));
                if (!$this->funcion) {
                    throw new \Exception("No se encontró la Función", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad inválida", 1);
        }
    }

    private function validateData()
    {
        if ($this->mode === "DEL") {
            $this->funcion["fncod"] = strval($_POST["fncod"] ?? "");
            return true;
        }

        $errors = [];
        $this->funcion_xss_token = $_POST["funcion_xss_token"] ?? "";
        $this->funcion["fncod"] = strval($_POST["fncod"] ?? "");
        $this->funcion["fndsc"] = strval($_POST["fndsc"] ?? "");
        $this->funcion["fnest"] = strval($_POST["fnest"] ?? "");
        $this->funcion["fntyp"] = strval($_POST["fntyp"] ?? "");

        if (Validators::IsEmpty($this->funcion["fncod"])) {
            $errors["fncod_error"] = "El código es requerido";
        }
        if (Validators::IsEmpty($this->funcion["fndsc"])) {
            $errors["fndsc_error"] = "La descripción es requerida";
        }
        if (!in_array($this->funcion["fnest"], ["ACT", "INA"])) {
            $errors["fnest_error"] = "El estado es inválido";
        }
        if (Validators::IsEmpty($this->funcion["fntyp"])) {
            $errors["fntyp_error"] = "El tipo es requerido";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->funcion[$key] = $value;
            }
            return false;
        }
        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {
            case "INS":
                $this->handleInsert();
                break;
            case "UPD":
                $this->handleUpdate();
                break;
            case "DEL":
                $this->handleDelete();
                break;
            default:
                throw new \Exception("Modo inválido", 1);
        }
    }

    private function handleInsert()
    {
        $result = DaoFunciones::insertFuncion(
            $this->funcion["fncod"],
            $this->funcion["fndsc"],
            $this->funcion["fnest"],
            $this->funcion["fntyp"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Función creada exitosamente"
            );
        }
    }

    private function handleUpdate()
    {
        $result = DaoFunciones::updateFuncion(
            $this->funcion["fncod"],
            $this->funcion["fndsc"],
            $this->funcion["fnest"],
            $this->funcion["fntyp"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Función actualizada exitosamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = DaoFunciones::deleteFuncion($this->funcion["fncod"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Función eliminada exitosamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["funcion_xss_token"] = $this->funcion_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->funcion["fncod"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $fnestKey = "fnest_" . strtolower($this->funcion["fnest"]);
        $this->funcion[$fnestKey] = "selected";

        $this->viewData["funcion"] = $this->funcion;
    }
}