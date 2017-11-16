<?php
namespace src\Model;

/**
 * Classe Funcionario
 *
 * @author Lais
 */
class Funcionario extends \src\Model\Db {
    private $name = 'funcionario';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_funcionario = ?";
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
        $sql = "INSERT INTO {$this->name} SET funcionario = ?, cpf = ?, dt_nascimento = ?, sexo = ?, telefone = ?, email = ?, fk_endereco = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['funcionario']);
        $statement->bindParam(2, $params['cpf']);
        $statement->bindParam(3, $params['dt_nascimento']);
        $statement->bindParam(4, $params['sexo']);
        $statement->bindParam(5, $params['telefone']);
        $statement->bindParam(6, $params['email']);
        $statement->bindParam(7, $params['fk_endereco']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_funcionario = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET funcionario = ?, cpf = ?, dt_nascimento = ?, sexo = ?, telefone = ?, email = ?, fk_endereco = ? WHERE id_funcionario = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['funcionario']);
        $statement->bindParam(2, $params['cpf']);
        $statement->bindParam(3, $params['dt_nascimento']);
        $statement->bindParam(4, $params['sexo']);
        $statement->bindParam(5, $params['telefone']);
        $statement->bindParam(6, $params['email']);
        $statement->bindParam(7, $params['fk_endereco']);
        $statement->bindParam(8, $params['id_funcionario']);
        return $statement->execute();
    }
}
