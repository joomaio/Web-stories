import React from "react";
import { Route, Link, NavLink, useRouteMatch } from "react-router-dom";
import CategoriesManagement from "../component/CategoriesManagement";
import StoriesManagement from "../component/StoriesManagement";
import CategoryForm from "../component/CategoryForm";
import StoryForm from "../component/StoryForm";

let Admin = ({ match }) => {
  return (
    <div>
      <Nav></Nav>
      <div className="album py-5 bg-light">
        <Route
          exact
          path={`${match.path}/categories`}
          component={CategoriesManagement}
        ></Route>
        <Route
          exact
          path={`${match.path}/stories`}
          component={StoriesManagement}
        ></Route>
        <Route
          exact
          path={`${match.path}/category/:id`}
          component={CategoryForm}
        ></Route>
        <Route
          exact
          path={`${match.path}/story/:id`}
          component={StoryForm}
        ></Route>
      </div>
      <footer className="text-muted">
        <div className="container">
          <p className="float-right">
            <Link onClick={() => window.scrollTo(0, 0)}>Back to top</Link>
          </p>
          <p>2020 © Webstories</p>
        </div>
      </footer>
    </div>
  );
};
let Nav = () => {
  let { url } = useRouteMatch();
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
                <NavLink
                  className="nav-link"
                  activeClassName="active"
                  to={`${url}/categories`}
                >
                  Quản lý chuyên mục <span className="sr-only"></span>
                </NavLink>
              </li>
              <li className="nav-item ">
                <NavLink
                  className="nav-link"
                  activeClassName="active"
                  to={`${url}/stories`}
                >
                  Quản lý truyện <span className="sr-only"></span>
                </NavLink>
              </li>
            </ul>
            <ul className="navbar-nav">
              <li className="nav-item active">
                <Link className="nav-link" to="/">
                  Đăng xuất
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  );
};
export default Admin;
