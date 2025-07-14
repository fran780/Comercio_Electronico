<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function getRoles(
        string $partialDescription = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT rolescod, rolesdsc, rolesest,
                          CASE WHEN rolesest = 'ACT' THEN 'Activo' ELSE 'Inactivo' END as rolesestDsc
                   FROM roles";
        $sqlstrCount = "SELECT COUNT(*) as count FROM roles";

        $conditions = [];
        $params = [];

        if ($partialDescription !== "") {
            $conditions[] = "rolesdsc LIKE :partialDescription";
            $params["partialDescription"] = "%" . $partialDescription . "%";
        }

        if (in_array($status, ["ACT", "INA"])) {
            $conditions[] = "rolesest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $where = " WHERE " . implode(" AND ", $conditions);
            $sqlstr .= $where;
            $sqlstrCount .= $where;
        }

        if (!in_array($orderBy, ["rolescod", "rolesdsc", ""])) {
            throw new \Exception("Invalid orderBy value");
        }

        if ($orderBy !== "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $total = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = $total > 0 ? ceil($total / $itemsPerPage) : 1;
        if ($page < 0) {
            $page = 0;
        }
        if ($page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

        $roles = self::obtenerRegistros($sqlstr, $params);
        return [
            "roles" => $roles,
            "total" => $total,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getRolById(string $rolescod)
    {
        $sqlstr = "SELECT rolescod, rolesdsc, rolesest FROM roles WHERE rolescod = :rolescod";
        $params = ["rolescod" => $rolescod];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
                   VALUES (:rolescod, :rolesdsc, :rolesest)";
        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $sqlstr = "UPDATE roles SET rolesdsc = :rolesdsc, rolesest = :rolesest WHERE rolescod = :rolescod";
        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteRol(string $rolescod)
    {
        $sqlstr = "DELETE FROM roles WHERE rolescod = :rolescod";
        $params = ["rolescod" => $rolescod];
        return self::executeNonQuery($sqlstr, $params);
    }
}
