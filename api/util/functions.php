<?php

  function debug($data){
    
    echo "<pre>";
    if(is_array($data)){
      print_r($data);
    }else{
      var_dump($data);
    }
    echo "</pre>";

  }

  function safe_params(&$params = []){
    foreach($params as $key => $param){
      if(is_array($params[$key])){
        safe_params($params[$key]);
      }else{
        $params[$key] = addslashes($params[$key]);
      }
    }
  }