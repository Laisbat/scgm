<?php

/**
 * Classe de Socio
 *
 * @author Lais
 */
class Socio extends \src\Model\Db {
    private $name = 'socio';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_socio = ?";
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
        $sql = "INSERT INTO {$this->name} SET fk_funcionario = ?, fk_login = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_funcionario']);
        $statement->bindParam(2, $params['fk_login']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_socio = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET fk_funcionario = ?, fk_login = ? WHERE id_socio = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_funcionario']);
        $statement->bindParam(2, $params['fk_login']);
        $statement->bindParam(3, $params['id_socio']);
        return $statement->execute();
    }
}
