<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, callable $next){
    
    $response = $next($request, $response);
    return $response;
});