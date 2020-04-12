import React from "react";
import { Switch, Route, Link } from "react-router-dom";
import Home from "../component/Home";
import NavBar from "../component/layout/NavBar";
import Footer from "../component/layout/Footer";

const Guest = () => {
  return (
    <div>
      <NavBar></NavBar>
      <Switch>
        <Route path="/" component={Home} />
      </Switch>
     <Footer></Footer>
    </div>
  );
};

export default Guest;
