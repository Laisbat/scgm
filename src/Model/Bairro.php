<?php
namespace src\Model;

/**
 * Classe Bairro
 *
 * @author Lais
 */
class Bairro extends \src\Model\Db {
    private $name = 'bairro';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_bairro = ?";
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
        $sql = "INSERT INTO {$this->name} SET nome = ?, fk_cidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        $statement->bindParam(2, $params['fk_cidade']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_bairro = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET nome = ?, fk_cidade = ? WHERE id_bairro = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['nome']);
        $statement->bindParam(2, $params['fk_cidade']);
        $statement->bindParam(3, $params['id_bairro']);
        
        return $statement->execute();
    }
}

