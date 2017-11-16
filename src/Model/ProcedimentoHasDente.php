<?php

/**
 * Classe de ProcedimentoHasDente
 *
 * @author Lais
 */
class ProcedimentoHasDente extends \src\Model\Db {
    private $name = 'procedimento_has_dente';
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET id_procedimento = ?, id_dente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_procedimento']);
        $statement->bindParam(2, $params['id_dente']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete(array $params)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_procedimento = ? AND id_dente = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_procedimento']);
        $statement->bindParam(2, $params['id_dente']);
        return $statement->execute();
    }    
}
