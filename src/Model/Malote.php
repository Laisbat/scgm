<?php
namespace src\Model;

/**
 * Classe de Malote
 *
 * @author Lais
 */
class Malote extends \src\Model\Db {
    private $name = 'malote';
    
    public function get($id)
    {
        $sql = "SELECT id_malote, dt_envio, valor_recebido, valor_receber, observacao, fk_operadora, status, dt_recebimento FROM {$this->name} WHERE id_malote = ?";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getAll()
    {
        $sql = "SELECT m.id_malote, m.dt_envio, m.dt_recebimento, m.valor_recebido, m.valor_receber, m.status, o.operadora FROM {$this->name} m "
        . "INNER JOIN operadora o on m.fk_operadora = o.id_operadora ORDER BY 1 DESC"; 
        $statement = self::$db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function getAllConfirmado()
    {
        $sql = "SELECT id_malote FROM {$this->name} WHERE status = 'C' "; 
        $statement = self::$db->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
    
    /**
     * 
     * Executa uma inserção no banco, e retorna o ID gerado, OU, falso para erro.
     * @param array $params
     * @return boolean
     */
    public function insert(array $params)
    {
        $sql = "INSERT INTO {$this->name} SET dt_envio = ?, valor_receber = ?, valor_recebido = ?, observacao = ?, fk_operadora = ?, dt_recebimento = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['dt_envio']);
        $statement->bindParam(2, $params['valor_receber']);
        $statement->bindParam(3, $params['valor_recebido']);
        $statement->bindParam(4, $params['observacao']);
        $statement->bindParam(5, $params['fk_operadora']);
        $statement->bindParam(6, $params['dt_recebimento']);
        if ($statement->execute()) {
            return self::$db->lastInsertId();
        }
        return false;
    }
    
    public function delete($id)
    {
        $sql = "UPDATE {$this->name} SET status = 'I' WHERE id_malote = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $id);
        return $statement->execute();
    }    
    
    public function update(array $params)
    {
        $sql = "UPDATE {$this->name} SET valor_receber = ?, valor_recebido = ?, observacao = ?, fk_operadora = ?, status = ?, dt_envio = ?, dt_recebimento = ? WHERE id_malote = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $params['valor_receber']);
        $statement->bindParam(2, $params['valor_recebido']);
        $statement->bindParam(3, $params['observacao']);
        $statement->bindParam(4, $params['fk_operadora']);
        $statement->bindParam(5, $params['status']);
        $statement->bindParam(6, $params['dt_envio']);
        $statement->bindParam(7, $params['dt_recebimento']);
        $statement->bindParam(8, $params['id_malote']);
        return $statement->execute();
    }
    
    public function updateValorRecebido($valorRecebido, $idMalote)
    {
        $sql = "UPDATE {$this->name} SET valor_recebido = ? WHERE id_malote = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $valorRecebido);
        $statement->bindParam(2, $idMalote);
        return $statement->execute();
    }
    
    public function updatesStatus($idMalote, $status = 'C')
    {
        $sql = "UPDATE {$this->name} SET status = ? WHERE id_malote = ?"; 
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $status);
        $statement->bindParam(2, $idMalote);
        return $statement->execute();
    }
    
    public function getEstatistica($idMalote){
        $sql = "SELECT m.id_malote, f.funcionario, SUM(p.valor) AS valor, o.operadora, COUNT(p.id_procedimento) AS qtd_procedimentos
                FROM sgm.malote m 
                INNER JOIN sgm.guia g ON g.fk_malote = m.id_malote
                INNER JOIN sgm.guia_has_procedimento gp ON g.id_guia = gp.id_guia
                INNER JOIN sgm.dentista d ON d.id_dentista = gp.fk_dentista
                INNER JOIN sgm.funcionario f ON f.id_funcionario = d.fk_funcionario 
                INNER JOIN sgm.procedimento p ON gp.id_procedimento = p.id_procedimento
                INNER JOIN sgm.operadora o ON m.fk_operadora = o.id_operadora
                WHERE m.id_malote = ? and g.status = 'P' and m.status = 'C' 
                GROUP BY m.id_malote, f.funcionario, o.operadora;";
        $statement = self::$db->prepare($sql);
        $statement->bindParam(1, $idMalote);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_OBJ);
    }
}
