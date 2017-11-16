<?php
namespace src\Model;

/**
 * Classe de Login
 *
 * @author Lais
 */
class Login extends \src\Model\Db {
    private $name = 'login';
    
    public function get($usuario, $senha)
    {
        $sql = "SELECT id_login, usuario, perfil FROM {$this->name} WHERE usuario = ? AND senha = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $usuario);
        $statement->bindParam(2, $senha);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET usuario = ?, senha = ?, perfil = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['usuario']);
        $statement->bindParam(2, $params['senha']);
        $statement->bindParam(3, $params['perfil']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_login = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET usuario = ?, senha = ?, perfil = ? WHERE id_login = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['usuario']);
        $statement->bindParam(2, $params['senha']);
        $statement->bindParam(3, $params['perfil']);
        $statement->bindParam(4, $params['id_login']);
        
        return $statement->execute();
    }
}
