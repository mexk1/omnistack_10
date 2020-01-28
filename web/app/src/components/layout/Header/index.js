import React from 'react';
import './style.css';

function Header(props) {
  

  function logout(e){
    e.preventDefault()
    sessionStorage.clear();
    window.location.href = window.location.origin
  }

  return(
    <header className="container">
      <a 
        href="#!" 
        className="circle btn-floating btn-meddium red logout__floating--button"
        onClick={e => logout(e)} 
      >
        <i 
          className="material-icons" 
          style={{}}
        >
          exit_to_app
        </i>
      </a>
    </header>
  )
}

export default Header;