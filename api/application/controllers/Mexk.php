<?php

  class Mexk {

    function getAll()
    {
      return (new DataBaseConnection)->runQuery(
        "SELECT * FROM $this->table"
      );
    }

    function getBy($params = []){
      $conn = new DataBaseConnection;
      $args = [];

      $fields = isset($params['fields']) && !empty($params['fields']) ? $params['fields'] : '*';
      $where = isset($params['WHERE']) && !empty($params['WHERE']) ? $params['WHERE'] : [];
      $join = isset($params['JOIN']) && !empty($params['JOIN']) ? $params['JOIN'] : [];
      $group_by = isset($params['GROUP BY']) && !empty($params['GROUP BY']) ? $params['GROUP BY'] : [];
      $order_by = isset($params['ORDER BY']) && !empty($params['ORDER BY']) ? $params['ORDER BY'] : [];
      
      $sql = "SELECT ";
      $sql .= implode(', ', $fields);
      $sql .= " FROM {$this->table} ";

      $this->queryJoin($join, $sql, $args);
      $this->queryWhere($where, $sql, $args);
      $this->queryGroupBy($group_by, $sql, $args);
      $this->queryOrderBy($order_by, $sql, $args);

      $result = $conn->runQuery($sql, $args);
      return $result;
    }

    function insertOne($data = []){
      $conn = new DataBaseConnection($insert = true);
      $sql = "INSERT INTO $this->table ( ";
      $args = [];
      
      $this->removeInvaliFields($data);
      if(sizeof($data) < 1){
        return false;
      }

      $loop_iterator = 0;
      foreach($data as $field => $value){
        $sql .= " :? ";
        $args[] = $field;
        if($loop_iterator < (sizeof($data) - 1)){
          $sql .= ", ";
        }
        $loop_iterator++;
      }

      $sql .= " ) VALUES (";
      $loop_iterator = 0;
      foreach($data as $field => $value){

        if(is_string($value)){
          $sql .= " ':?' ";
        }else{
          $sql .= " :? ";
        }

        $args[] = $value;
        if($loop_iterator < (sizeof($data) - 1)){
          $sql .= ", ";
        }
        $loop_iterator++;
      }
      $sql .= " ) ";

      $result = $conn->runQuery($sql, $args);
     
      return $result;
    }

    private function removeInvaliFields(&$fields){
      $conn = new DataBaseConnection;
      $sql = 'SELECT COLUMN_NAME as columns FROM information_schema.columns WHERE table_schema="'.DB_NAME.'" AND table_name="'.$this->table.'"';
      $db_columns = $conn->runQuery($sql);

      $aux = [];
      foreach($db_columns as $column){
        array_push($aux, $column['columns']);
      }
      $db_columns = $aux;
      
      foreach($fields as $field => $values){
        if(!in_array($field, $db_columns)){
          unset($fields[$field]);
        }
      }
    }

    function getById($id, $fields = ["*"]){
      $conn = new DataBaseConnection;
      $fields = implode(', ', $fields);

      $sql = "SELECT {$fields} FROM {$this->table} WHERE {$this->table}.id = :? ";

      $result = $conn->runQuery($sql, [$id]);
      $result = end($result);
      return $result;
    }

    function update($ids = [], $params = []){
      $conn = new DataBaseConnection;
      $sql = "UPDATE {$this->table} SET ";
      $args = [];
      $where = [];
      $where[]['id'] = is_array($ids) ? $ids : [$ids]; 

      $loop_counter = 0;
      foreach($params as $field => $value){ 
        if(is_string($value)){
          $sql .= " :? = ':?'";
        }else{
          $sql .= " :? = :?";
        }
        $args[] = $field;
        $args[] = $value;
        if($loop_counter < (sizeof($params) - 1)){
          $sql .= ", ";
        }
        $loop_counter++;
      }

      $this->queryWhere($where, $sql, $args);
      $result = $conn->runQuery($sql, $args);
      
      return  $result;
    }

    private function queryJoin($join = [], &$sql){
      //Join's are made only by devs, so don't need the $args
      foreach($join as $type => $table){
        $sql .= " {$type} ";
        foreach($table as $t => $on){
          $sql .= " {$t} ON ";
          foreach($on as $o => $cond){
            for($i= 0; $i < sizeof($cond); $i++){
              if($i > 0){
                $sql .= " AND ";
              }
              $sql .= " {$o} = {$cond[$i]}";
            }
          }
        }
      }

    }

    private function queryWhere($where, &$sql, &$args){

      $first_where_flag = false;

      if(isset($where['LIKE']) && !empty($where['LIKE'])){
        
        $like = $where['LIKE'];
        $first_where_flag = true;
        $sql .= " WHERE ";

        foreach($like as $l => $field){
          foreach($field as $field_name => $cond){
            for($i = 0; $i < sizeof($cond); $i++){
              if($i > 0){
                $sql .= " AND ";
              }
  
              $sql .= " {$field_name} LIKE :? ";
              $args[] = $cond[$i];
  
            }
          }
         
        }
        unset($where['LIKE']);
      }

      foreach($where as $w => $field){
        
        if($first_where_flag){
          $sql .= " AND ";
          $first_where_flag = true;
        }else{
          $sql .= " WHERE ";
        }
        
        foreach($field as $field_name => $values){
          if(sizeof($values) == 1){
            $sql .= " :? = ";
            $args[] = $field_name;
            $sql .= " :? ";
            $args[] = end($values);
          }else{
            for($i = 0; $i < sizeof($values); $i++){
  
              if($i == 0 ){
                $sql .= " :? IN ( ";
                $args[] = $field_name;
              }
  
              $args[] = $values[$i];
              $sql .= ":?";
  
              if($i < (sizeof($values) - 1)){
                $sql .= ", ";
              }

              if($i == (sizeof($values) - 1)){
                $sql .= " ) ";
              }

            }
          }
        }
      }
    }

    private function queryGroupBy($group_by, &$sql, &$args){

      for($i = 0; $i < sizeof($group_by); $i++){
        if($i == 0){
          $sql .= " GROUP BY ";
        }

        $sql .= " :? ";
        $args[] = $group_by[$i];
        
        if($i < (sizeof($group_by) - 1)){
          $sql .= ", ";
        }
      }
      
    }

    private function queryOrderBy($order_by, &$sql, &$args){

      for($i = 0; $i < sizeof($order_by); $i++){
        if($i == 0){
          $sql .= " ORDER BY ";
        }
        foreach($order_by[$i] as $field => $direction){

          $sql .= " :? ";
          $args[] = $field;
          $sql .= " :? ";
          $args[] = $direction;

        }
        if($i < (sizeof($order_by) - 1)){
          $sql .= ", ";
        }

      }
      
    }

  }