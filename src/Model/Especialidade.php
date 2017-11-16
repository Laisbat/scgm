<?php
namespace src\Model;

/**
 * Classe Especialidade
 *
 * @author Lais
 */
class Especialidade extends \src\Model\Db {
    private $name = 'especialidade';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_especialidade = ?";
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
        $sql = "INSERT INTO {$this->name} SET especialidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['especialidade']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_especialidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET especialidade = ? WHERE id_especialidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['especialidade']);
        $statement->bindParam(2, $params['id_especialidade']);
        
        return $statement->execute();
    }
}
