<?php

/**
 * Classe de PagamentoHasTipoPagamento
 *
 * @author Lais
 */
class PagamentoHasTipoPagamento extends \src\Model\Db {
    private $name = 'procedimento_has_tipo_pagamento';
    
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET id_pagamento = ?, id_tipo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_pagamento']);
        $statement->bindParam(2, $params['id_tipo']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete(array $params)
    {
        $sql = "DELETE FROM {$this->name} WHERE id_pagamento = ? AND id_tipo = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['id_pagamento']);
        $statement->bindParam(2, $params['id_tipo']);
        return $statement->execute();
    }    
}
