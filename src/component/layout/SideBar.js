import React from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
const SideBar = props => {
  return (
    <div className="col-lg-3 order-lg-1">
      <div className="sidebar">
        <div className="widget">
          <h4>Chuyên mục</h4>
          <ul className="nav flex-column">
            {props.categories.map((element, index) => {
              return (
                <li className="nav-item" key={index}>
                  <Link className="nav-link" to={`/category/${element.id}`}>
                    {element.name}
                  </Link>
                </li>
              );
            })}
          </ul>
        </div>
      </div>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    categories: state.categories
  };
};
export default connect(mapStateToProps, null)(SideBar);
