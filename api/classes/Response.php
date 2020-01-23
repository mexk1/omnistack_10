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
            header("content-length: ".strlen(json_encode($dados)));
            die(json_encode($dados));
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