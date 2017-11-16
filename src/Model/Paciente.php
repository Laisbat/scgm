<?php
namespace src\Model;

/**
 * Classe de Paciente
 *
 * @author Lais
 */
class Paciente extends \src\Model\Db {
    private $name = 'paciente';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_paciente = ?";
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
        $sql = "INSERT INTO {$this->name} SET cpf = ?, dt_nascimento = ?, paciente = ?, sexo = ?, telefone = ?, email = ?, fk_operadora = ?, fk_endereco = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cpf']);
        $statement->bindParam(2, $params['dt_nascimento']);
        $statement->bindParam(3, $params['paciente']);
        $statement->bindParam(4, $params['sexo']);
        $statement->bindParam(5, $params['telefone']);
        $statement->bindParam(6, $params['email']);
        $statement->bindParam(7, $params['fk_operadora']);
        $statement->bindParam(8, $params['fk_endereco']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_paciente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET cpf = ?, dt_nascimento = ?, paciente = ?, sexo = ?, telefone = ?, email = ?, fk_operadora = ?, fk_endereco = ? WHERE id_paciente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['cpf']);
        $statement->bindParam(2, $params['dt_nascimento']);
        $statement->bindParam(3, $params['paciente']);
        $statement->bindParam(4, $params['sexo']);
        $statement->bindParam(5, $params['telefone']);
        $statement->bindParam(6, $params['email']);
        $statement->bindParam(7, $params['fk_operadora']);
        $statement->bindParam(8, $params['fk_endereco']);    
        $statement->bindParam(9, $params['id_paciente']);
        return $statement->execute();
    }
}
