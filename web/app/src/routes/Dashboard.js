import React, {Component} from 'react';
import api from '../services/api';
import M from 'materialize-css';
import DevCard from '../components/common/DevCard';
import Header from '../components/layout/Header';

class Dashboard extends Component{

  constructor(props){
    super(props);

    this.state = {dev: {}, all_devs: []}
  }

  componentDidMount(){
    this.loadDev();
    this.loadAllDevs();
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
  }

  async loadAllDevs(){
    const devs = await api.get('/user/', {data: ''});
    this.setState({all_devs: devs.data.data});
  }

  async loadDev(){
    const dev = await api.get(`/user/?user_id=${sessionStorage.getItem("@devradar/user/id")}`, {data: ''});
    this.setState({dev: dev.data});
  }
  render(){
    return(
      <>
        <Header />
        <main>
          <aside>
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
          </aside>

          <section id="devs" className="container devs">
            {this.state.all_devs.map(dev => {
              if(this.state.dev.id != dev.id || true)
                return ( <DevCard key={dev.id} dev_info={dev}/>);
            })}
          </section>
         
        </main>
      </>
    );
  }
}

export default Dashboard;