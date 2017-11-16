<?php

/**
 * User: Lais Batista
 * Date: 13/10/2017
 * Time: 09:21
 */
namespace src\Controller;

use src\Controller\Controller;
use src\Model\Malote;
use src\Library\App_Exception;
use src\Model\Operadora;

class EstatisticaController extends Controller
{
    public function gerar($request, $response, $args) 
    {
        try {
            $mMalote = new Malote();
            $comboMalote = $mMalote->getAllConfirmado();
            $estatistica = [];
            $params = $request->getQueryParams();
            if (isset($params['malote']) && $params['malote']) {
                $estatistica = $mMalote->getEstatistica($params['malote']);
            }
            $mOperadora = new Operadora();
            $rsOperadora = $mOperadora->getAll();
            $data = [
                'labels' => [],
                'datasets' => [0 => [
                    'label' => 'Por Valor',
                    'data' => [],
                    'borderWidth' => 1
                    ]
                ]
            ];
            $quantidade = [
                'labels' => [],
                'datasets' => [0 => [
                    'label' => 'Por Quantidade',
                    'data' => [],
                    'borderWidth' => 1
                    ]
                ]
            ];
            
            foreach($estatistica as $row) {
                $data['labels'][] = $row->funcionario;
                $quantidade['labels'][] = $row->funcionario;
                
                $data['datasets'][0]['data'][] = $row->valor;
                $data['datasets'][0]['backgroundColor'][] = 'rgba(255, 99, 132, 0.2)';
                $data['datasets'][0]['borderColor'][] = 'rgba(255,99,132,1)';
                
                $quantidade['datasets'][0]['data'][] = $row->qtd_procedimentos;
                $quantidade['datasets'][0]['backgroundColor'][] = 'rgba(54, 162, 235, 0.2)';
                $quantidade['datasets'][0]['borderColor'][] = 'rgba(54, 162, 235, 1)';
            }
            $this->render('administrativo/estatistica/index.phtml', [
                'rsOperadora' => $rsOperadora, 
                'comboMalote' => $comboMalote, 
                'estatistica' => $data,
                'quantidade'  => $quantidade
            ]);

        } catch (App_Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'alert-danger';
            $_SESSION['message_title'] = 'Falhou!';
            return $this->response->withStatus(302)->withRedirect('/estatistica');
        }
    }
    
}