<?php

  class User extends  Mexk{
    var $table = "user";
    
    function get($params = []){
      
      $where = [];
      $order_by = [];

      $fields = ['*'];

      if(isset($params['github_username']) && !empty($params['github_username'])){
        
        $where[]['github_username'] = explode(',', $params['github_username']);

      }

      if(isset($params['user_id']) && !empty($params['user_id'])){
        if(sizeof(explode(',', $params['user_id'])) == 1){
          return $this->getById($params['user_id']);
        }

        $where[]['id'] = explode(',', $params['user_id']);
      }

      if(isset($params['name']) && !empty($params['name'])){
        $temp_array = explode(',', $params['name']);

        foreach($temp_array as $key => $text){
          $temp_array[$key] = "'%$text%'";
        }
        $where["LIKE"][]["CONCAT(users.name, ' ',users.last_name)"] = $temp_array;

      }

      if(isset($params['order_by']) && !empty($params['order_by'])){
        if(isset($params['order']) && !empty($params['order'])){
          $order_by[] = array($params['order_by'] => $params['order']);
        }else{
          return false;
        }
      }

      
      if(isset($params['get']) && $params['get']  == 'all'){
        unset($where);
        //return $this->getAll();
      }

      $params = [
        'WHERE' => $where,
        'ORDER BY' => $order_by,
        'fields' => $fields
      ];

      $success = $this->getBy($params, $fields);

      if(!empty($success)){
        return $success;
      }

      return array('Sem parametros');
    }

    function post($params){
      if(!empty($params['password']) && $params['password'] == $params['confirmPassword']){
        unset($params['confirmPassword']);
        $params['password'] = md5($params['password']);
      }else{
        return [
          'status' => 'error', 
          'message' => "Senhas vazias ou nao conferem"
        ];
      }

      $success = $this->insertOne($params);

      if(! $success ){
        return [
          'status' => 'error', 
          'message' => "erro ao cadastrar"
        ];
      }

      return [
        'status' => 'success', 
        'message' => "Usuario Cadastrado"
      ];
    }

    function put($params = []){
      if(!isset($params['user_id']) || empty($params['user_id'])){
        return false;
      }
      $id = $params['user_id'];
      unset($params['user_id']);

      return $params;
      return $this->update($id, $params);
    }

    function delete($params){
      return 'DELETE';
    }

  }