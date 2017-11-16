<?php
// Routes
$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/logar', src\Controller\LoginController::class . ':logar')
    ->setName('logar');
$app->get('/administrativo', function ($request, $response, $args) {
    return $this->view->render($response, 'administrativo/index.phtml', $args);
})->setName('administrativo');

$app->get('/logout', src\Controller\LoginController::class . ':deslogar')
    ->setName('deslogar');

$app->get('/malote', src\Controller\MaloteController::class . ':index')
    ->setName('malote');
$app->get('/malote/cadastro[/{id}]', src\Controller\MaloteController::class . ':cadastrar')
    ->setName('malote/cadastro');
$app->get('/malote/pagamento/{id}', src\Controller\MaloteController::class . ':pagamento')
    ->setName('malote/pagamento');
$app->post('/malote/salvar', src\Controller\MaloteController::class . ':salvar')
    ->setName('malote/salvar');
$app->post('/malote/salvar-pagamento', src\Controller\MaloteController::class . ':salvarPagamento')
    ->setName('malote/salvar-pagamento');
$app->get('/malote/excluir/{id}', src\Controller\MaloteController::class . ':excluir')
    ->setName('malote/excluir');

$app->get('/estatistica', src\Controller\EstatisticaController::class . ':gerar')
    ->setName('estatistica/gerar');


$app->get('/guia', src\Controller\GuiaController::class . ':index')
    ->setName('guia');
$app->get('/guia/cadastro[/{id}]', src\Controller\GuiaController::class . ':cadastrar')
    ->setName('guia/cadastro');
$app->post('/guia/salvar', src\Controller\GuiaController::class . ':salvar')
    ->setName('guia/salvar');
$app->get('/guia/excluir/{id}', src\Controller\GuiaController::class . ':excluir')
	->setName('guia/excluir');
