<?php

/**
 * Classe de Pagamento
 *
 * @author Lais
 */
class Pagamento extends \src\Model\Db {
    private $name = 'pagamento';
    
    public function get($id)
    {
        $sql = "SELECT * FROM {$this->name} WHERE id_pagamento = ?";
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
        $sql = "INSERT INTO {$this->name} SET dt_pagamento = ?, valor = ?, fk_guia"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['dt_pagamento']);
        $statement->bindParam(2, $params['valor']);
        $statement->bindParam(3, $params['fk_guia']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_pagamento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET dt_pagamento = ?, valor = ?, fk_guia WHERE id_pagamento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['dt_pagamento']);
        $statement->bindParam(2, $params['valor']);
        $statement->bindParam(3, $params['fk_guia']);
        $statement->bindParam(4, $params['id_pagamento']);
        return $statement->execute();
    }
}
