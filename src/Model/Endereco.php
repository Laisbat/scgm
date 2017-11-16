<?php
namespace src\Model;

/**
 * Classe Endereco
 *
 * @author Lais
 */
class Endereco extends \src\Model\Db {
    private $name = 'endereco';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_endereco = ?";
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
        $sql = "INSERT INTO {$this->name} SET cep = ?, logradouro = ?, complemento = ?, fk_bairro = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cep']);
        $statement->bindParam(2, $params['logradouro']);
        $statement->bindParam(3, $params['complemento']);
        $statement->bindParam(4, $params['fk_bairro']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_endereco = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SSET cep = ?, logradouro = ?, complemento = ?, fk_bairro = ? WHERE id_endereco = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cep']);
        $statement->bindParam(2, $params['logradouro']);
        $statement->bindParam(3, $params['complemento']);
        $statement->bindParam(4, $params['fk_bairro']);
        $statement->bindParam(5, $params['id_endereco']);
        
        return $statement->execute();
    }
}