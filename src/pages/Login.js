/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { fetchUsersRequest } from "../redux/actions/usersActions";
import "../Login.css";
const Login = props => {
  const [state, setState] = useState({
    username: "",
    password: ""
  });
  useEffect(() => {
    props.onFetchUsers();
  }, []);
  const onChange = event => {
    const { name, value } = event.target;
    setState(prev => {
      return {
        ...prev,
        [name]: value
      };
    });
  };
  const onSubmit = event => {
    event.preventDefault();
    let flag = false;
    props.users.forEach(element => {
      if (
        element.username === state.username.toLowerCase() &&
        element.password === state.password
      )
        flag = true;
    });
    flag
      ? props.history.push({ pathname: "/admin/categories" })
      : alert("wrong!");
  };
  return (
    <div className = "div-signin">
      <form className="form-signin" onSubmit={onSubmit}>
        <h1 className="h3 mb-3 font-weight-normal">Sign in</h1>
        <label htmlFor="inputID" className="sr-only">
          ID
        </label>
        <input
          type="username"
          className="form-control"
          placeholder="Username"
          name="username"
          onChange={onChange}
          value={state.name}
          required
          autofocus
        />
        <label htmlFor="inputPassword" className="sr-only">
          Password
        </label>
        <input
          type="password"
          className="form-control"
          placeholder="Password"
          name="password"
          onChange={onChange}
          value={state.password}
          required
        />
        <button className="btn btn-lg btn-primary btn-block" type="submit">
          Sign in
        </button>
      </form>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    users: state.users
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    onFetchUsers: () => {
      dispatch(fetchUsersRequest());
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Login);
