import React, { Component } from 'react';
import './App.css';
import './assets/css/materialize.min.css';
import './assets/css/main.css';
import M from 'materialize-css';

import Card from './components/common/Card';


class App extends Component{

  componentDidMount(){
    M.updateTextFields();
    setTimeout(() => {
      var elems = document.querySelectorAll('select');
      var instances = M.FormSelect.init(elems);
    }, 2000);
  }
  render(){
    return(
      <>
        <header >

        </header>
        <main>
          <Card />
        </main>
      </>
    );
  }
}

export default App;
