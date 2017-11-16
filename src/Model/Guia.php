<?php

namespace src\Model;

/**
 * Classe Guia
 *
 * @author Lais
 */
class Guia extends \src\Model\Db {

    private $name = 'guia';

    public function get($id) {
        $sql = "SELECT * FROM {$this->name} WHERE id_guia = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_OBJ);
    }

    public function getAll($fkMalote = null) {
        $sql = "SELECT * FROM {$this->name} WHERE fk_malote IS NULL";
        if ($fkMalote) {
            $sql .= " OR fk_malote = ?";
        }
        $sql .= " ORDER BY 1 DESC";
        $statement = self::$db->prepare($sql);
        if ($fkMalote) {
            $statement->bindParam(1, $fkMalote);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAllPorMalote($fkMalote = null) {
        $sql = "SELECT * FROM {$this->name} WHERE fk_malote = ? ORDER BY 1 DESC";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $fkMalote);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }

    public function insert(array $params) {
        $sql = "INSERT INTO {$this->name} SET vl_total = ?, dt_abertura = ?, dt_vencimento = ?, status = ?, fk_malote = ?, fk_paciente = ?, fk_dentista = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['vl_total']);
        $statement->bindParam(2, $params['dt_abertura']);
        $statement->bindParam(3, $params['dt_vencimento']);
        $statement->bindParam(4, $params['status']);
        $statement->bindParam(5, $params['fk_malote']);
        $statement->bindParam(6, $params['fk_paciente']);
        $statement->bindParam(7, $params['fk_dentista']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->name} WHERE id_guia = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }

    public function update(array $params) {
        $sql = "UPDATE {$this->name} SET vl_total = ?, dt_abertura = ?, dt_vencimento = ?, status = ?, fk_malote = ?, fk_paciente = ?, fk_dentista = ? WHERE id_guia = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['vl_total']);
        $statement->bindParam(2, $params['dt_abertura']);
        $statement->bindParam(3, $params['dt_vencimento']);
        $statement->bindParam(4, $params['status']);
        $statement->bindParam(5, $params['fk_malote']);
        $statement->bindParam(6, $params['fk_paciente']);
        $statement->bindParam(7, $params['fk_dentista']);
        $statement->bindParam(8, $params['id_guia']);

        return $statement->execute();
    }

    public function updateMalote(array $params) {
        $sql = "UPDATE {$this->name} SET fk_malote = ? WHERE id_guia = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_malote']);
        $statement->bindParam(2, $params['id_guia']);

        return $statement->execute();
    }

    /**
     * status: A - Aguardando, B - Bloqueado, P - Pago
     * @param array $params
     * @return type
     */
    public function updateStatus(array $params) {
        $sql = "UPDATE {$this->name} SET status = ? WHERE id_guia = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['status']);
        $statement->bindParam(2, $params['id_guia']);

        return $statement->execute();
    }

    public function setMaloteNull($fkMalote) {
        $sql = "UPDATE {$this->name} SET fk_malote = NULL WHERE fk_malote = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $fkMalote);

        return $statement->execute();
    }

}
