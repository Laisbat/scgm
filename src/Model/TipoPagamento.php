<?php

/**
 * Classe de TipoPagamento
 *
 * @author Lais
 */
class TipoPagamento extends \src\Model\Db {
    private $name = 'tipo_pagamento';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_tipo = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->name}"; 
        $statement = self::$db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET tipo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['tipo']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_tipo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET tipo = ? WHERE id_tipo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['tipo']);
        $statement->bindParam(2, $params['id_tipo']);
        return $statement->execute();
    }
}
