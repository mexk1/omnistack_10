<?php 

  class Auth extends Mexk{
    var $table = 'user';

    public function post($params){

      if(!isset($params['github_username']) || !isset($params['password'])){
        return false;
      }

      $fields = [
        'id',
        'name',
        'github_username',
        'last_name'
      ];
      $where[] = [
        'github_username' => '"'.$params['github_username'].'"',
        'password' => '"'.md5($params['password']).'"'
      ];

      $params = [
        'fields' => $fields,
        'WHERE' => $where
      ]; 

      $response = $this->getBy($params);

      if(empty($response)){
        return [
          'status' => 'error',
          'message' => 'Credenciais invalidas'
        ];
      }


      return [
        'status' => 'success',
        'message' => 'Login',
        'data' => end($response)
      ];
    }
  }
  