<?php
/**
 * Created by PhpStorm.
 * User: Lais Batista
 * Date: 23/06/17
 * Time: 18:31
 */

namespace src\Controller;

use Slim\Container;

abstract class Controller
{
    protected $container;
    protected $view;
    protected $args = [];

    /**
     * Rest constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view      = $container->get('view');
        $this->init();
    }

    /**
     * getter mágico para acessar o container do slim.
     * @param $name
     * @return mixed
     */
    public function __get($name){
        return $this->container->get($name);
    }
    
    public function init()
    {
        if (isset($_SESSION['message'])) {
            $this->args['flash_message_title'] = $_SESSION['message_title'];
            $this->args['flash_message'] = $_SESSION['message'];
            $this->args['flash_message_type'] = $_SESSION['message_type'];
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            unset($_SESSION['message_title']);
        }
    }
    
    protected function render($rota, $args = [])
    {
        if (count($args)) {
            $this->args = array_merge($args, $this->args);
        }
        $this->view->render($this->response, $rota, $this->args);
    }
}