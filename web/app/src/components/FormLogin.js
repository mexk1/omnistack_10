import React, { Component } from 'react';
import M from 'materialize-css';


class FormLogin extends Component{

  componentDidMount(){
    M.updateTextFields();
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  }

  render(){
    return (
      <div className="form-wrapper">
        <div className="row">
          <form className="form_login deep-purple lighten-5 center-align">
            <div className="row"> 
              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label >Nome </label>
                  <input type="text" placeholder="Seu nome"/>
                </div>
              </div>

              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label >Sobrenome </label>
                  <input type="text" placeholder="Sobrenome"/>
                </div>
              </div>
              
              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <label>Github username</label>
                  <input type="text" placeholder="Github username"/>
                </div>
              </div>

              <div className="col s12 m12"> 
                <div className="input-field col s12 m12 center">
                  <select multiple >
                    <option value="" disabled ></option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                  </select>
                  <label>Escolha suas tecnologias Favoritas</label>
                </div>
              </div>

              <div className="col s12 m6">
                <div className="input-field col s12 m12 center">
                  <label>Senha</label>
                  <input type="text" placeholder="Senha" type="password"/>
                </div>
              </div>

              <div className="col s12 m6"> 
                <div className="input-field col s12 m12 center">
                  <label>Confirme a senha</label>
                  <input type="text" placeholder="Confirme a senha" type="password"/>
                </div>
              </div>
            </div>
          </form> 
        </div>       
      </div>
    )
  }
}

export default FormLogin;
