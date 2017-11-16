<?php
/**
 * Created by PhpStorm.
 * User: Lais Batista
 * Date: 11/06/2017
 * Time: 16:24
 */

namespace src\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use src\Controller\Controller;
use src\Model\Guia;
use src\Model\Operadora;
use src\Model\Paciente;
use src\Model\Dentista;
use src\Model\Procedimento;
use src\Library\App_Exception;

class GuiaController extends Controller
{
    public function index(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $mGuia  = new Guia();
        $rsGuia = $mGuia->getAll();
        
        $this->render('administrativo/guia/index.phtml', ['lista' => $rsGuia]);
    }
    
    public function cadastrar($request, $response, $args) 
    {
        try {
            $id = $args['id'] ?? null;
            
            $arGuia = [];
            if ($id) {
                $mGuia = new Guia();
                $arGuia = $mGuia->get($id);
            }
            
            $mOperadora = new Operadora();
            $mPaciente = new Paciente();
            $mDentista = new Dentista();
            $mProcedimento = new Procedimento();
            
            $rsOperadora = $mOperadora->getAll();
            $rsPaciente = $mPaciente->getAll();
            $rsDentista = $mDentista->getAll();
            $rsProcedimento = $mProcedimento->getAll();
            
            $this->render('administrativo/guia/cadastro.phtml', ['rGuia' => $arGuia, 'rsOperadora' => $rsOperadora, 'rsPaciente' => $rsPaciente, 'rsDentista' => $rsDentista, 'rsProcedimento' => $rsProcedimento]);
            
        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'alert-danger';
            $_SESSION['message_title'] = 'Falhou!';
            return $this->response->withStatus(302)->withRedirect('/guia');
        }
    }
    
    public function excluir(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {
            if (!isset($args['id']) && trim($args['id']) == '') {
                throw new App_Exception('Id da guia não informado');
            }

            $guia = new Guia();
            $guia->delete($args['id']);

            $_SESSION['message'] = 'Guia inativada com sucesso!';
            $_SESSION['message_title'] = 'Sucesso!';
            $_SESSION['message_type'] = 'alert-success';
            return $this->response->withRedirect('/guia');
        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_title'] = 'Falhou.';
            $_SESSION['message_type'] = 'alert-danger';
            return $this->response->withRedirect('/guia');
        }
    }
    
    public function salvar($request, $response, $args)
    {
        try {
            $dados = $this->request->getParsedBody();
            $params['vl_total'] = $dados['vl_total'];;
            $params['dt_abertura'] = implode('-', array_reverse(explode('/', $dados['dt_abertura'])));
            $params['dt_vencimento'] = implode('-', array_reverse(explode('/', $dados['dt_vencimento'])));
            $params['status'] = $dados['status'];
            $params['fk_malote'] = $dados['fk_malote'];
            $params['fk_paciente'] = $dados['fk_paciente'];
            $params['fk_dentista'] = $dados['fk_dentista'];
            $params['fk_operadora'] = $dados['fk_operadora'];
            
            $mGuia = new Guia();
            if ($dados['id_guia']) {
                $params['id_guia'] = $dados['id_guia'];
                $mGuia->update($params);
            } else {
                $mGuia->insert($params);
            }
            
            $_SESSION['message'] = 'Guia salva com sucesso!';
            $_SESSION['message_title'] = 'Sucesso!';
            $_SESSION['message_type'] = 'alert-success';
            return $this->response->withStatus(200)->withRedirect('/guia');
        } catch (App_Exception $e) {
            $idGuia = $this->request->getParsedBody()['id_guia'];
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_title'] = 'Falhou.';
            $_SESSION['message_type'] = 'alert-danger';
            if ($idGuia == '') {
                return $this->response->withStatus(200)->withRedirect('/guia/cadastro');
            } else {
                return $this->response->withStatus(200)->withRedirect('/guia/cadastro/'.$idGuia);
            }
        }
    }
}