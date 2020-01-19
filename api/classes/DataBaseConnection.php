<?php

class DataBaseConnection{
    private $dsn;
    private $is_insert = false;

    function __construct($is_insert = false){
      
      $this->is_insert = $is_insert;
      $this->dsn = DB_DBMS.":dbname=".DB_NAME.";host=".DB_HOST.";port=3308";
      
    }

    function runQuery($sql, $args = []){
      
      try{
        $data_base_handle = new PDO($this->dsn, DB_USERNAME, DB_PASSWORD);
      }catch(PDOException $e){
        var_dump( $this->dsn);
        return 'Connection failed: ' . $e->getMessage();
      }

      //database log
      $log = fopen("database.log", "a");
      fwrite($log, "\n");
      fwrite($log, $sql."\n");
      fwrite($log, "Args => ".print_r($args, true));
      fwrite($log, "\n");

      foreach($args as $value){
        //to be fixed
        $sql = $this->str_replace_first(':?', $value, $sql);
        
      }
      
      $query = $data_base_handle->prepare($sql);
      $success = $query->execute();
      
      if(!$success){
        fwrite($log, "SQL ERRORS => ".print_r($query->errorInfo(), true));
      }
      $data = $query->fetchAll(PDO::FETCH_ASSOC);



      if($this->is_insert){
        return $data_base_handle->lastInsertId();
      }

      return $data; 
    }

    private function str_replace_first($from, $to, $content){
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }

  }