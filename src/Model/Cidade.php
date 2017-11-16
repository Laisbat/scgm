<?php
namespace src\Model;

/**
 * Classe Cidade
 *
 * @author Lais
 */
class Cidade extends \src\Model\Db {
    private $name = 'cidade';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_cidade = ?";
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
        $sql = "INSERT INTO {$this->name} SET nome = ?, fk_uf = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        $statement->bindParam(2, $params['fk_uf']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_cidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET nome = ?, fk_uf = ? WHERE id_cidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        $statement->bindParam(2, $params['fk_uf']);
        $statement->bindParam(3, $params['id_cidade']);
        
        return $statement->execute();
    }
}


