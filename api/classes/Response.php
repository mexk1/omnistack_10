<?php

    class Response {
        var $messages = [];
        var $data = [];
        var $type= [];
        
        const ERROR = 'error';
        const SUCCESS = 'success';
        
        function __contruct(){

        }

        function success_callback($dados){
            die(json_encode(
                    array(
                        'status' => 'success',
                        'code' => '200',
                        'dados' => $dados
                    )   
                )
            );
        }
        
        function bad_request($m = ""){
            die(json_encode(
                    array(
                        'status' => 'error',
                        'code' => 'bad_request',
                        'message' => $m
                    )   
                )
            );
        }
    }