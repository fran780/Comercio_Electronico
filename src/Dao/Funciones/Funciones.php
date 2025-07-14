<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function getFunciones(
        string $partialDescription = "",
        string $status = "",
        string $type = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT fncod, fndsc, fnest, fntyp,
                   CASE WHEN fnest = 'ACT' THEN 'Activo' ELSE 'Inactivo' END as fnestDsc
                   FROM funciones";
        $sqlstrCount = "SELECT COUNT(*) as count FROM funciones";

        $conditions = [];
        $params = [];

        if ($partialDescription != "") {
            $conditions[] = "fndsc LIKE :partialDescription";
            $params["partialDescription"] = "%" . $partialDescription . "%";
        }

        if (in_array($status, ["ACT", "INA"])) {
            $conditions[] = "fnest = :status";
            $params["status"] = $status;
        }

        if ($type != "") {
            $conditions[] = "fntyp = :type";
            $params["type"] = $type;
        }

        if (count($conditions) > 0) {
            $where = " WHERE " . implode(" AND ", $conditions);
            $sqlstr .= $where;
            $sqlstrCount .= $where;
        }

        if (!in_array($orderBy, ["fncod", "fndsc", "fntyp", ""])) {
            throw new \Exception("Invalid orderBy value");
        }

        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $total = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = max(ceil($total / $itemsPerPage), 1);
        if ($page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }
        $sqlstr .= " LIMIT " . max(0, $page * $itemsPerPage) . ", " . $itemsPerPage;

        $funciones = self::obtenerRegistros($sqlstr, $params);
        return ["funciones" => $funciones, "total" => $total, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getFuncionById(string $fncod)
    {
        $sqlstr = "SELECT fncod, fndsc, fnest, fntyp FROM funciones WHERE fncod = :fncod";
        $params = ["fncod" => $fncod];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
                   VALUES (:fncod, :fndsc, :fnest, :fntyp)";
        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $sqlstr = "UPDATE funciones SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp WHERE fncod = :fncod";
        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteFuncion(string $fncod)
    {
        $sqlstr = "DELETE FROM funciones WHERE fncod = :fncod";
        $params = ["fncod" => $fncod];
        return self::executeNonQuery($sqlstr, $params);
    }
}
