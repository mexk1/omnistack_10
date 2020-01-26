import React, {useState, useEffect} from 'react';
import M from 'materialize-css';
import api from "../../../services/api";
import Routes from "../../../routes";
import { Redirect } from 'react-router-dom';

function FormLogin(){
  const [github_username, setGithubUsername] = useState([]);
  const [password, setPassword] = useState([]); 

  useEffect(() => {
      setGithubUsername('');
      setPassword('');
  },[]);
  
  async function login(e){

    e.preventDefault();

    var object = {
      github_username,
      password
    }

    const response = await api.post('auth', {data: object});
    
    M.toast({html: response.data.message, classes: response.data.status})
    
    if(response.data.status == "success"){

      sessionStorage.setItem("@devradar/user/id", response.data.data.id);
      sessionStorage.setItem("@devradar/user/name", response.data.data.name);
      sessionStorage.setItem("@devradar/user/last_name", response.data.data.last_name);
      window.location.href = '/dashboard';
      
    }

  } 

  return ( 
    <form className="valign-wrapper form__login" onSubmit={login} >
      <div className="row">
        <div className="col s12 m12"> 
          <div className="input-field col s12 m12 center">
            <label>Github username</label>
            <input 
              type="text" 
              placeholder="Github username" 
              value={github_username}
              onChange={e => setGithubUsername(e.target.value)}
            />
          </div>
        </div>

        <div className="col s12 m12">
          <div className="input-field col s12 m12 center">
            <label>Senha</label>
            <input 
              type="text" 
              placeholder="Senha" 
              value={password}
              type="password" 
              onChange={e => setPassword(e.target.value)}/>
          </div>
        </div>

        <div className="col s12 m12 center center-align">
          <button type="submit" className="btn waves-effect">Enviar</button>
        </div>
      </div>
    </form>     
  )  
}

export default FormLogin;
