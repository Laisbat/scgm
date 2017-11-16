<?php
/**
 * 
 * User: Lais Batista
 * Date: 11/06/2017
 * Time: 16:24
 */

namespace src\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\Controller\Controller;
use src\Model\Malote;
use src\Model\Guia;
use src\Library\App_Exception;
use src\Model\Operadora;

class MaloteController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $mMalote  = new Malote();
        $rsMalote = $mMalote->getAll();
        $arStatus = ['A' => 'Aguardando Envio', 'E' => 'Enviado', 'P' => 'Pago', 'I' => 'Inativo', 'C' => 'Pagamento Confirmado'];
        
        $this->render('administrativo/malote/index.phtml', [
            'lista' => $rsMalote,
            'arStatus' => $arStatus
        ]);
    }
    
    public function cadastrar($request, $response, $args) 
    {
        try {
            $id = $args['id'] ?? null;
            
            $arMalote = [];
            if ($id) {
                $mMalote = new Malote();
                $arMalote = $mMalote->get($id);
            }
            
            $mOperadora = new Operadora();
            $mGuia = new Guia();
            $rsOperadora = $mOperadora->getAll();
            $rsGuia = $mGuia->getAll($id);
            
            $this->render('administrativo/malote/cadastro.phtml', [
                'rMalote' => $arMalote, 
                'rsOperadora' => $rsOperadora, 
                'rsGuia' => $rsGuia
            ]);

        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'alert-danger';
            $_SESSION['message_title'] = 'Falhou!';
            return $this->response->withStatus(302)->withRedirect('/malote');
        }
    }
    
    public function excluir(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {
            if (!isset($args['id']) && trim($args['id']) == '') {
                throw new App_Exception('Id do malote não informado');
            }

            $malote = new Malote();
            $malote->delete($args['id']);

            $_SESSION['message'] = 'Malote inativado com sucesso!';
            $_SESSION['message_title'] = 'Sucesso!';
            $_SESSION['message_type'] = 'alert-success';
            return $this->response->withRedirect('/malote');
        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_title'] = 'Falhou.';
            $_SESSION['message_type'] = 'alert-danger';
            return $this->response->withRedirect('/malote');
        }
    }
    
    public function salvar($request, $response, $args)
    {
        try {
            $mGuia = new Guia();
            $dados = $this->request->getParsedBody();
            if (($dados['status'] == 'E' || $dados['status'] == 'P') && $dados['data_envio']) {
                $params['dt_envio'] = implode('-', array_reverse(explode('/', $dados['data_envio'])));
            } else {
                $params['dt_envio'] = null;
            }
            $vlReceber = 0;
            if (isset($dados['guia'])) {
                foreach ($dados['guia'] as $guia) {
                    $rGuia = $mGuia->get($guia);
                    $vlReceber += $rGuia->vl_total;
                }
            }
            $params['valor_receber'] = $vlReceber;
            $params['observacao'] = $dados['observacao'];
            $params['fk_operadora'] = $dados['operadora'];
            $params['status'] = $dados['status'];
            if ($dados['status'] == 'P' && $dados['data_recebimento']) {
                $params['dt_recebimento'] = implode('-', array_reverse(explode('/', $dados['data_recebimento'])));
            } else {
                $params['dt_recebimento'] = null;
                $params['valor_recebido'] = null;
            }
            
            $mMalote = new Malote();
            if ($dados['id_malote']) {
                $params['id_malote'] = $dados['id_malote'];
                $mMalote->update($params);
            } else {
                $dados['id_malote'] = $mMalote->insert($params);
            }
            
            //Apaga todas as vinculações do malote atual na guia.
            $mGuia->setMaloteNull($dados['id_malote']);
            if (isset($dados['guia'])) {
                foreach ($dados['guia'] as $guia) {
                    $mGuia->updateMalote(['id_guia' => $guia, 'fk_malote' => $dados['id_malote']]);
                }
            }
            
            $_SESSION['message'] = 'Malote salvo com sucesso!';
            $_SESSION['message_title'] = 'Sucesso!';
            $_SESSION['message_type'] = 'alert-success';
            if ($dados['status'] == 'P') {
                return $this->response->withStatus(200)->withRedirect('/malote/pagamento/'. $dados['id_malote']);
            }
            return $this->response->withStatus(200)->withRedirect('/malote');
        } catch (App_Exception $e) {
            $idMalote = $this->request->getParsedBody()['id_malote'];
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_title'] = 'Falhou.';
            $_SESSION['message_type'] = 'alert-danger';
            if ($idMalote == '') {
                return $this->response->withStatus(200)->withRedirect('/malote/cadastro');
            } else {
                return $this->response->withStatus(200)->withRedirect('/malote/cadastro/'.$idMalote);
            }
        }
    }
    
    public function pagamento($request, $response, $args) 
    {
        try {
            $id = $args['id'] ?? null;
            
            $arMalote = [];
            $mMalote = new Malote();
            $arMalote = $mMalote->get($id);
            
            $mOperadora = new Operadora();
            $mGuia = new Guia();
            $rsOperadora = $mOperadora->getAll();
            $rsGuia = $mGuia->getAllPorMalote($id);
            
            
            $this->render('administrativo/malote/pagamento.phtml', [
                'rMalote' => $arMalote, 
                'rsOperadora' => $rsOperadora, 
                'rsGuia' => $rsGuia
            ]);

        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'alert-danger';
            $_SESSION['message_title'] = 'Falhou!';
            return $this->response->withStatus(302)->withRedirect('/malote');
        }
    }
    /**
     * 
     * @param type $request
     * @param type $response
     * @param type $args
     * @return type
     */    
    public function salvarPagamento($request, $response, $args)
    {
        $dados = $this->request->getParsedBody();
        try {
            $mGuia   = new Guia();
            $mMalote = new Malote();            
            $vlPago  = 0;
            
            foreach ($dados['guia'] as $id => $pago) {
                $status = $pago ? 'P' : 'B';
                $mGuia->updateStatus(['status' => $status, 'id_guia' => $id]);
                if ($status == 'P') {
                    $rGuia = $mGuia->get($id);
                    $vlPago += $rGuia->vl_total;
                }
            }
            $mMalote->updateValorRecebido($vlPago, $dados['id_malote']);            
            $mMalote->updatesStatus($dados['id_malote']);            
            
            $_SESSION['message'] = 'Malote salvo com sucesso!';
            $_SESSION['message_title'] = 'Sucesso!';
            $_SESSION['message_type'] = 'alert-success';
            return $this->response->withStatus(200)->withRedirect('/malote');
        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_title'] = 'Falhou.';
            $_SESSION['message_type'] = 'alert-danger';
            return $this->response->withStatus(200)->withRedirect('/malote/cadastro/'. $dados['id_malote']);
        }
    }
}