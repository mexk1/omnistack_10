import React from "react";
import {BrowserRouter, Route, Switch, Redirect} from "react-router-dom";

//Login
import is_logged from "./util/auth"

//Componensts
import Home from "./routes/Home";
import Dashboard from "./routes/Dashboard";


const NotLogged = ({component: Component, ...rest}) => (
  <Route {...rest} render={props => (
    is_logged() ? (
      <Component {...props} />
    ) : (
      <Redirect to={{pathname: '/', state: {from: props.location}}}/>
    )
  )}/>
) 

const Logged = ({component: Component, ...rest}) => (
  <Route {...rest} render={props => (
    !is_logged() ? (
      <Component {...props} />
    ) : (
      <Redirect to={{pathname: '/dashboard', state: {from: props.location}}}/>
    )
  )}/>
) 

const Routes = () => (
  <BrowserRouter>
    <Switch>
      <Logged exact path="/" component={() => <Home />} />
      <NotLogged exact path="/dashboard"  component={() => <Dashboard />} />
    </Switch>
  </BrowserRouter>
)

export default Routes;