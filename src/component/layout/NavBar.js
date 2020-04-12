import React, { useState } from "react";
import { NavLink } from "react-router-dom";
import { withRouter } from "react-router";
const NavBar = props => {
  const [keyWord, setKeyWord] = useState();
  const onChange = event => {
    const { value } = event.target;
    setKeyWord(value);
  };
  const onSearch = event => {
    event.preventDefault();
    if (keyWord !== undefined && keyWord !== "")
      props.history.push({ pathname: `/stories/search/${keyWord}` });
    else props.history.push({ pathname: "/" });
  };
  return (
    <header>
      <nav className="navbar navbar-expand-md navbar-dark bg-dark">
        <div className="container">
          <NavLink to="/" className="navbar-brand">
            Webstories
          </NavLink>
          <button
            className="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarCollapse"
            aria-controls="navbarCollapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span className="navbar-toggler-icon" />
          </button>
          <div className="collapse navbar-collapse" id="navbarCollapse">
            <ul className="navbar-nav mr-auto">
              <li className="nav-item ">
                <NavLink activeClassName="active" to="/" className="nav-link">
                  Trang chủ <span className="sr-only">(current)</span>
                </NavLink>
              </li>
              <li className="nav-item ">
                <NavLink
                  activeClassName="active"
                  to="/login"
                  className="nav-link"
                >
                  Login <span className="sr-only"></span>
                </NavLink>
              </li>
              <li className="nav-item ">
                <NavLink
                  activeClassName="active"
                  to="/admin/categories"
                  className="nav-link"
                >
                  Manage <span className="sr-only"></span>
                </NavLink>
              </li>
            </ul>
            <form className="form-inline mt-2 mt-md-0" onSubmit={onSearch}>
              <input
                className="form-control mr-sm-2"
                type="text"
                placeholder="Search"
                aria-label="Search"
                value={keyWord}
                onChange={onChange}
              />
              <button className="btn btn-primary my-2 my-sm-0" type="submit">
                Search
              </button>
            </form>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default withRouter(NavBar);
