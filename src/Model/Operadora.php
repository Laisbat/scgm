<?php
namespace src\Model;

/**
 * Classe de Operadora
 *
 * @author Lais
 */
class Operadora extends \Src\Model\Db {
    private $name = 'operadora';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_operadora = ?";
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
        $sql = "INSERT INTO {$this->name} SET operadora = ?, telefone = ?, cnpj = ?, email = ?, razao_social = ?, codigo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['operadora']);
        $statement->bindParam(2, $params['telefone']);
        $statement->bindParam(3, $params['cnpj']);
        $statement->bindParam(4, $params['email']);
        $statement->bindParam(5, $params['razao_social']);
        $statement->bindParam(6, $params['codigo']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_operadora = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET operadora = ?, telefone = ?, cnpj = ?, email = ?, razao_social = ?, codigo = ? WHERE id_operadora = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['operadora']);
        $statement->bindParam(2, $params['telefone']);
        $statement->bindParam(3, $params['cnpj']);
        $statement->bindParam(4, $params['email']);
        $statement->bindParam(5, $params['razao_social']);
        $statement->bindParam(6, $params['codigo']);
        $statement->bindParam(7, $params['id_operadora']);
        return $statement->execute();
    }
}
