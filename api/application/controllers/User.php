<?php

  class User extends  Mexk{
    var $table = "user";
    
    function get($params = []){
      
      $where = [];
      $order_by = [];

      $fields = ['*'];

      if(isset($params['github_username']) && !empty($params['github_username'])){
        
        $aux = [];
        foreach(explode(',', $params['github_username']) as $username){
          $aux[] = '"'.$username.'"';
        }
        $where[]['github_username'] = $aux;
        $aux = [];
      }

      if(isset($params['user_id']) && !empty($params['user_id'])){
        if(sizeof(explode(',', $params['user_id'])) == 1){
          
          $user = $this->getById($params['user_id']);
          if(array_key_exists('password', $user)){
            unset($user['password']);
          }
          return $user;
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
        
        foreach($success as $key => $user){
          if(array_key_exists('password', $user)){
            unset($success[$key]['password']);
          }
        }
        return ['success' => 'error', 'message' => '', 'data' => $success];
      }

      return ['status' => 'error', 'message' => 'Nenhum Usuário encontrado', 'data' => []];
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
        'message' => "Usuario Cadastrado",
        'data' => $this->getById($success, ['id', 'name', 'last_name'])
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