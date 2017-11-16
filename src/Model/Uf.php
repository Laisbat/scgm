<?php

/**
 * Classe de Uf
 *
 * @author Lais
 */
class Uf extends \src\Model\Db {
    private $name = 'uf';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_uf = ?";
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
        $sql = "INSERT INTO {$this->name} SET nome = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_uf = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET nome = ? WHERE id_uf = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        $statement->bindParam(2, $params['id_uf']);
        return $statement->execute();
    }
}
