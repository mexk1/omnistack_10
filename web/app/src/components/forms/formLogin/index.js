import React, {Component} from 'react';
import M from 'materialize-css';

class FormLogin extends Component{

  componentDidMount(){
    M.updateTextFields();
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  }
  
  login(e){
    e.preventDefault();
  }

  render(){
    return (
      
      <form className="valign-wrapper form__login" onSubmit={this.login}>
        <div className="row">
          <div className="col s12 m12"> 
            <div className="input-field col s12 m12 center">
              <label>Github username</label>
              <input type="text" placeholder="Github username"/>
            </div>
          </div>

          <div className="col s12 m12">
            <div className="input-field col s12 m12 center">
              <label>Senha</label>
              <input type="text" placeholder="Senha" type="password"/>
            </div>
          </div>

          <div className="col s12 m12 center center-align">
            <button type="submit" className="btn waves-effect">Enviar</button>
          </div>
        </div>
      </form>     
      
    )
  }
}

export default FormLogin;
