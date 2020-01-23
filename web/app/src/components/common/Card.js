import React, {Component, useState} from 'react';
import M from 'materialize-css';
import FormCadastro from '../forms/formCadastro';
import FormLogin from '../forms/formLogin';

class Card extends Component{

  constructor(props){
    super(props);
    this.switchFaces = this.switchFaces.bind(this);
  }

  componentDidMount(prevProps, prevState){
    M.updateTextFields();
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems);
  }
  switchFaces = (e) => {
    e.preventDefault();

    var cube = document.getElementById('card-1');
    cube.classList.toggle('card__show-back');

  }
  
  render(){
    return(
      <div className="card" id="card-1">
        <div className="card__face card__face--front">
          <button type="" onClick={this.switchFaces} className="btn">Trocar para Cadastro</button>
          <FormCadastro />
        </div>
        <div className="card__face card__face--back">
          <button type="" onClick={this.switchFaces} className="btn">Trocar para Login</button>
          <FormLogin />
        </div>

        <div className="card__shadow">

        </div>
      </div>
    );
  }
}

export default Card;
