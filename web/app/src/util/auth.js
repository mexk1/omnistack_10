import React from 'react';

function is_logged(){
  
  var id = sessionStorage.getItem("@devradar/user/id");
  
  if(id){
    return true;
  }

  
}

export default is_logged;