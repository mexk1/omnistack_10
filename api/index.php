<?php
    global $_DELETE;
    global $_PUT;

    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
        parse_str(file_get_contents('php://input'), $_DELETE);
    }
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
        parse_str(file_get_contents('php://input'), $_PUT);
    }
    
    require_once "config.php";
    require_once "classes/Response.php";
    require_once "classes/Routes.php";
    
    $classResponse = new Response;
    $classRoutes = new Routes;
    

    $request = explode('/', $_GET['request']);
    $controller = '';
    $method = $_SERVER['REQUEST_METHOD'];
    $params = [];

    if(!empty($request[0])){
        $controller = ucfirst($request[0]);
    }else{
        $classResponse->bad_request("End point nao encontrado");
    }

    if(!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])){
        $classResponse->bad_request("Tipo da requisição não suportado");
    }

    if($method == 'GET'){
        $str = explode('?', $_SERVER['REQUEST_URI']);
        $str = end($str);
        parse_str($str, $params);
    }else{
        $params = json_decode(file_get_contents('php://input'), true);
        if(!$params){
            $classResponse->bad_request("Parametros invalidos");
        }
    }

    function call_controller($controller){
        $path = __DIR__ . '/application/controllers/' . ucfirst($controller) . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }

    spl_autoload_register('call_controller');

    $Dinamic_Object = new $controller;

    $return = call_user_func_array([$Dinamic_Object, $method], $params);
    
    if(!$return){
        $classResponse->bad_request("Erro na api, contate a administração");
    }else{
        $classResponse->success_callback($return);
    }