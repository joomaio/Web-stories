/* eslint-disable react-hooks/exhaustive-deps */
import SideBar from "./layout/SideBar";
import Categories from "./Categories";
import Category from "./Category";
import Story from "./Story";
import { Route } from "react-router-dom";
import Search from "./Search";
import React, { useEffect } from "react";
import { connect } from "react-redux";
import { fetchCategoriesRequest } from "../redux/actions/categoriesActions";
import {
  fetchStoriesByCatIDRequest,
  fetchStoriesRequest
} from "../redux/actions/storiesActions";
const Home = props => {
  useEffect(() => {
    props.fetchCategories();
    props.fetchStories();
  }, []);
  return (
    <div>
      {props.location.pathname === "/" ? (
        <section className="jumbotron text-center">
          <div className="container">
            <h1>Website stories</h1>
            <p className="lead text-muted">
              Something short and leading about the collection below—its
              contents, the creator, etc. Make it short and sweet, but not too
              short so folks don’t simply skip over it entirely.
            </p>
          </div>
        </section>
      ) : (
        <div></div>
      )}
      <div className="album py-5 bg-light">
        <div className="container">
          <div className="row">
            <Route exact path="/" component={Categories} />
            <Route exact path="/category/:id" component={Category} />
            <Route exact path="/story/:id" component={Story} />
            <Route exact path="/stories/search/:keyWord" component={Search} />
            <SideBar></SideBar>
          </div>
        </div>
      </div>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    stories: state.stories,
    categories: state.categories,
    storiesPreview: state.storyPreview
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchCategories: () => {
      dispatch(fetchCategoriesRequest());
    },
    fetchStoriesByCatID: (id, page, limit) => {
      dispatch(fetchStoriesByCatIDRequest(id, page, limit));
    },

    fetchStories: () => {
      dispatch(fetchStoriesRequest());
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Home);
