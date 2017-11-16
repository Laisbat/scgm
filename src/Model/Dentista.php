<?php
namespace src\Model;

/**
 * Classe Dentista
 *
 * @author Lais
 */
class Dentista extends \src\Model\Db {
    private $name = 'dentista';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_dentista = ?";
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
        $sql = "INSERT INTO {$this->name} SET cro = ?, fk_funcionario = ?, fk_especialidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cro']);
        $statement->bindParam(2, $params['fk_funcionario']);
        $statement->bindParam(3, $params['fk_especialidade']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_dentista = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET cro = ?, fk_funcionario = ?, fk_especialidade = ? WHERE id_dentista = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cro']);
        $statement->bindParam(2, $params['fk_funcionario']);
        $statement->bindParam(3, $params['fk_especialidade']);
        $statement->bindParam(4, $params['id_dentista']);
        
        return $statement->execute();
    }
}



