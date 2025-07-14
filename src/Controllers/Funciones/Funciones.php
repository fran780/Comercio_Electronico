<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Utilities\Context;
use Dao\Funciones\Funciones as DaoFunciones;
use Views\Renderer;

class Funciones extends PublicController
{
    private $partialDescription = "";
    private $status = "";
    private $type = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;
    private $viewData = [];
    private $funciones = [];
    private $funcionesCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpFunciones = DaoFunciones::getFunciones(
            $this->partialDescription,
            $this->status,
            $this->type,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        $this->funciones = $tmpFunciones["funciones"];
        $this->funcionesCount = $tmpFunciones["total"];
        $this->pages = $this->funcionesCount > 0 ? ceil($this->funcionesCount / $this->itemsPerPage) : 1;
        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();

        Renderer::render("funciones/funciones", $this->viewData);
    }

    private function getParams(): void
    {
        $this->partialDescription = $_GET["partialDescription"] ?? $this->partialDescription;
        $this->status = $_GET["status"] ?? $this->status;
        $this->type = $_GET["type"] ?? $this->type;

        if ($this->status === "EMP") {
            $this->status = "";
        }

        $this->orderBy = $_GET["orderBy"] ?? $this->orderBy;
        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }

        $this->orderDescending = isset($_GET["orderDescending"]) ? boolval($_GET["orderDescending"]) : $this->orderDescending;
        $this->pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : $this->pageNumber;
        $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : $this->itemsPerPage;
    }

    private function getParamsFromContext(): void
    {
        $this->partialDescription = Context::getContextByKey("funciones_partialDescription");
        $this->status = Context::getContextByKey("funciones_status");
        $this->type = Context::getContextByKey("funciones_type");
        $this->orderBy = Context::getContextByKey("funciones_orderBy");
        $this->orderDescending = boolval(Context::getContextByKey("funciones_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("funciones_page"));
        $this->itemsPerPage = intval(Context::getContextByKey("funciones_itemsPerPage"));
        if ($this->pageNumber < 1) $this->pageNumber = 1;
        if ($this->itemsPerPage < 1) $this->itemsPerPage = 10;
    }

    private function setParamsToContext(): void
    {
        Context::setContext("funciones_partialDescription", $this->partialDescription, true);
        Context::setContext("funciones_status", $this->status, true);
        Context::setContext("funciones_type", $this->type, true);
        Context::setContext("funciones_orderBy", $this->orderBy, true);
        Context::setContext("funciones_orderDescending", $this->orderDescending, true);
        Context::setContext("funciones_page", $this->pageNumber, true);
        Context::setContext("funciones_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialDescription"] = $this->partialDescription;
        $this->viewData["status"] = $this->status;
        $this->viewData["type"] = $this->type;
        $this->viewData["orderBy"] = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"] = $this->pageNumber;
        $this->viewData["itemsPerPage"] = $this->itemsPerPage;
        $this->viewData["funcionesCount"] = $this->funcionesCount;
        $this->viewData["pages"] = $this->pages;
        $this->viewData["funciones"] = $this->funciones;

        $statusKey = "status_" . ($this->status === "" ? "EMP" : $this->status);
        $this->viewData[$statusKey] = "selected";

        $pagination = \Utilities\Paging::getPagination(
            $this->funcionesCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Funciones_Funciones",
            "Funciones_Funciones"
        );

        $this->viewData["pagination"] = $pagination;
    }
}