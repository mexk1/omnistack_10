import React, {useState, useEffect} from 'react';
import api from "../../../services/api";
import M from 'materialize-css';

function FormCadastro (){

  const [techsRender, setTechsRender] = useState([]);
  const [name, setName] = useState([]);
  const [last_name, setLastName] = useState([]);
  const [github_username, setGithubUsername] = useState([]);
  const [techs = [], setTechs] = useState([]);
  const [password, setPassword] = useState([]);
  const [confirmPassword, setConfirmPassword] = useState([]);

  useEffect(() => {
    async function getTechs(){
      const techsRender = await api.get('techs?');
      setTechsRender(techsRender.data);
    }
    getTechs();
  }, [])

  function subscribeDev(e){
    e.preventDefault();
    console.log({
      name,
      last_name,
      github_username,
      techs,
      password,
      confirmPassword
    });

  }

  function updateTechs(e) {
    var select = document.getElementById('selectTechs');
    var tempArray = techs;
  }
  return (
    <div className="row">
          <form id="subscribeDev" onSubmit={subscribeDev}>
              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label >Nome </label>
                  <input 
                    type="text" 
                    placeholder="Seu nome" 
                    name="user[name]" 
                    value={name}
                    onChange={e => setName(e.target.value)}
                  />
                </div>
              </div>

              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label >Sobrenome </label>
                  <input 
                    type="text"
                    placeholder="Sobrenome" 
                    name="user[last_name]"
                    value={last_name}
                    onChange={e => setLastName(e.target.value)}/>
                </div>
              </div>
              
              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label>Github username</label>
                  <input 
                    type="text" 
                    placeholder="Github username"
                    name="user[github_username]"
                    value={github_username}
                    onChange={e => setGithubUsername(e.target.value)}  
                  />
                </div>
              </div>

              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <select 
                    multiple="multiple" 
                    id="selectTechs"
                    name="user[techs][]"
                    value={techs}
                    onChange={e => setTechs(e.target.value)}  
                  >
                    <option value="" disabled ></option>
                    {techsRender.map(tech => (
                          <option key={tech.id} value={tech.id}>{tech.name}</option>
                        )
                      )
                    }
                    
                  </select>
                  <label>Escolha suas tecnologias Favoritas</label>
                </div>
              </div>

              <div className="col s12 m6">
                <div className="input-field col s12 m12 center">
                  <label>Senha</label>
                  <input 
                    type="text" 
                    placeholder="Senha" 
                    type="password" 
                    name="user[password]"
                    value={password}
                    onChange={e => setPassword(e.target.value)}
                />
                </div>
              </div>

              <div className="col s12 m6"> 
                <div className="input-field col s12 m12 center">
                  <label>Confirme a senha</label>
                  <input 
                    type="text" 
                    placeholder="Confirme a senha" 
                    type="password" 
                    name="user[confirm_password]" 
                    value={confirmPassword}
                    onChange={e => setConfirmPassword(e.target.value)}/>
                </div>
              </div>

              <div className="col s12 m12 center center-align">
                <button type="submit" className="btn waves-effect">Enviar</button>
              </div>
          </form> 
        </div>       
      
    )
}

export default FormCadastro;
