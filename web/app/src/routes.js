import React from "react";

import {BrowserRouter, Route, Switch, Redirect} from "react-router-dom";

import Home from "./routes/Home";
import Dashboard from "./routes/Dashboard";

const Routes = () => (
  <BrowserRouter>
    <Switch>
      <Route exact path="/"  component={() => <Home />} />
      <Route exact path="/dashboard"  component={() => <Dashboard />} />
    </Switch>
  </BrowserRouter>
)

export default Routes;