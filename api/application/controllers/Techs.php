<?php

  class Techs extends Mexk{
    var $table = "tech";

    public function get($params = []){
      $success = $this->getBy($params);
      return $success;
    }

  }