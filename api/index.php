<?php
    require_once "config.php";
    require_once "classes/Response.php";
    require_once "classes/DataBaseConnection.php";
    require_once "util/functions.php";

    //RESTFUL
    global $_DELETE;
    global $_PUT;

    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
        parse_str(file_get_contents('php://input'), $_DELETE);
    }
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT')) {
        parse_str(file_get_contents('php://input'), $_PUT);
    }


    //ENVIRONMENT
    if(ENVIRONMENT == 'DEV'){
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);
    }else{
        ini_set('display_errors', 'off');
        error_reporting(0);
    }
    
    $classResponse = new Response;

    $request = [];
    $params = [];
    $controller = '';

    $request =  !empty($_GET['request']) ? explode('/',  $_GET['request']) : [];
    $method = $_SERVER['REQUEST_METHOD'];

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
        if(sizeof($str) < 2){
           $classResponse->bad_request("Parametros invalidos");
        }
        $str = urldecode(end($str));
        parse_str($str, $params);

    }else{
        $params = json_decode(file_get_contents('php://input'), true);
        if(!$params){
            $classResponse->bad_request("Parametros invalidos");
        }
    }

    safe_params($params);

    spl_autoload_register('call_controller');
    $Dinamic_Object = new $controller;
    $return = call_user_func_array([$Dinamic_Object, $method], [$params]);
    
    if(!$return && !is_array($return)){
        $classResponse->bad_request("Erro na api, contate a administração");
    }else{
        $classResponse->success_callback($return);
    }


    function call_controller($controller){
        $path = __DIR__ . '/application/controllers/' . ucfirst($controller) . '.php';
        if (is_file($path)) {
            include_once $path;
        }
    }