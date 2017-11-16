<?php
namespace src\Model;
/**
 * Classe de GuiaHasProcedimento
 *
 * @author Lais
 */
class GuiaHasProcedimento extends \src\Model\Db {
    private $name = 'guia_has_procedimento';
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET id_guia = ?, id_procedimento = ?, fk_dentista = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_guia']);
        $statement->bindParam(2, $params['id_procedimento']);
        $statement->bindParam(3, $params['fk_dentista']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete(array $params)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_guia = ? AND id_procedimento = ? AND fk_dentista = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_guia']);
        $statement->bindParam(2, $params['id_procedimento']);
        $statement->bindParam(3, $params['fk_dentista']);
        return $statement->execute();
    }    
}
