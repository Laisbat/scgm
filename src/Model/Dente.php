<?php
namespace src\Model;

/**
 * Classe Dente
 *
 * @author Lais
 */
class Dente extends \src\Model\Db {
    private $name = 'dente';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_dente = ?";
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
        $sql = "INSERT INTO {$this->name} SET dente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['dente']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_dente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET dente = ? WHERE id_dente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['dente']);
        $statement->bindParam(2, $params['id_dente']);
        
        return $statement->execute();
    }
}


