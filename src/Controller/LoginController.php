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
use src\Model\Login;

class LoginController extends Controller
{
    public function logar(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $mLogin = new Login();
        $dados  = $request->getParsedBody();
        if (!trim($dados['usuario']) || !trim($dados['senha'])) {
            $erro = "Preencha o usuário e senha para prosseguir.";
            $_SESSION['mensagem_erro'] = $erro;
            return $response->withRedirect('/');
        }

        $rLogin = $mLogin->get($dados['usuario'], hash('sha256', $dados['senha']));
        if (!$rLogin) {
            $erro = "Usuário ou senha inválidos.";
            $_SESSION['mensagem_erro'] = $erro;
            return $response->withRedirect('/');
        }
        $_SESSION['usuario'] = $rLogin;
        return $response->withRedirect('/administrativo');
    }
    
    public function deslogar(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        unset($_SESSION['usuario']);
        return $response->withRedirect('/');
    }
}