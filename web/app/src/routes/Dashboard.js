import React, {Component} from 'react';
import api from '../services/api';
import M from 'materialize-css';

class Dashboard extends Component{

  constructor(props){
    super(props);

    this.state = {dev: {}}
  }

  componentDidMount(){
    this.loadDev();
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
    // var menu = M.Sidenav.getInstance();
    // menu.isOpen = true;
    // menu.isFixed = true;
    //setTimeout(() => {instances.open() }, 1000);
  }

  async loadDev(){
    const dev = await api.get(`/user/?user_id=${sessionStorage.getItem("@devradar/user/id")}`, {data: ''});
    this.setState({dev: dev.data});
  }

  deslogar(e){
    e.preventDefault()
    sessionStorage.clear();
    window.location.href = window.location.origin
  }

  render(){
    return(
      <>
        <header >
          <a 
            href="#!" 
            className="circle btn-floating btn-meddium red"
            style={{display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'absolute', margin: 'auto', right: '20px', top: '20px'}}
            onClick={e => this.deslogar(e)} 
          >
            <i 
              className="material-icons" 
              style={{}}
            >
              exit_to_app
            </i>
          </a>
        </header>
        <main>
          <ul id="main_menu" className="sidenav">
            <li>
              <div className="user-view center-align">
                <img 
                  className="circle" 
                  src={this.state.dev.avatar_url} 
                  style={{margin: "auto"}}
                />
                <span className="black-text name">{this.state.dev.name}</span>
                <span className="black-text email">{this.state.dev.bio}</span>
              </div>
            </li> 
            <li>
              <div className="divider"></div>
            </li>
          </ul>
          <a href="#" data-target="main_menu" className="sidenav-trigger ">
            <img 
              className="circle btn-floating btn-large" 
              src={this.state.dev.avatar_url} 
              style={{margin: "auto", top: '20px', left: ' 20px'}}
            />
          </a>
        </main>
      </>
    );
  }
}

export default Dashboard;