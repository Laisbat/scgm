<?php
namespace src\Model;
/**
 * Classe de Procedimento
 *
 * @author Lais
 */
class Procedimento extends \src\Model\Db {
    private $name = 'procedimento';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_procedimento = ?";
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
        $sql = "INSERT INTO {$this->name} SET procedimento = ?, valor = ?, face = ?, fk_especialidade = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['procedimento']);
        $statement->bindParam(2, $params['valor']);
        $statement->bindParam(3, $params['face']);
        $statement->bindParam(4, $params['fk_especialidade']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_procedimento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET fk_funcionario = ?, fk_login = ? WHERE id_procedimento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['procedimento']);
        $statement->bindParam(2, $params['valor']);
        $statement->bindParam(3, $params['face']);
        $statement->bindParam(4, $params['fk_especialidade']);
        $statement->bindParam(5, $params['id_procedimento']);
        return $statement->execute();
    }
}
