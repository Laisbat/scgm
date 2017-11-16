<?php
namespace src\Model;

/**
 * Classe DentistaHasProcedimentos
 *
 * @author Lais
 */
class DentistaHasProcedimento extends \src\Model\Db {
    private $name = 'dentista_has_procedimento';
    
    public function get($idDentista, $idProcedimento)
    {
        $sql = "SELECT * FROM {$this->name} WHERE fk_dentista = ? AND fk_procedimento = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $idDentista);
        $statement->bindParam(2, $idProcedimento);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);
    }
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET fk_dentista = ?, fk_procedimento = ?, data = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_dentista']);
        $statement->bindParam(2, $params['fk_procedimento']);
        $statement->bindParam(3, $params['data']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete(array $params)
    {
        $sql = "DELETE FROM {$this->name} WHERE fk_dentista = ? AND fk_procedimento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_dentista']);
        $statement->bindParam(2, $params['fk_procedimento']);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET data = ? WHERE fk_dentista = ? AND fk_procedimento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['fk_funcionario']);
        $statement->bindParam(2, $params['fk_login']);
        $statement->bindParam(3, $params['id_auxiliar']);
        
        return $statement->execute();
    }
}
