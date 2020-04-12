import React, { Component } from "react";
import "./App.css";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Admin from "./pages/Admin";
import Guest from "./pages/Guest";
import Login from "./pages/Login";
export default class App extends Component {
  render() {
    return (
      <Router>
        <Switch>
          <Route path="/login" component={Login} />
          <Route path="/admin" component={Admin} />
          <Route path="/" component={Guest} />
        </Switch>
      </Router>
    );
  }
}

