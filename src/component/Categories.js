/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import { connect } from "react-redux";
import {
  fetchStoriesByCatIDRequest,
  fetchPreview
} from "../redux/actions/storiesActions";

const Categories = props => {
  useEffect(() => {
    props.fetchPreview();
    console.log("component did mount");
  }, []);
  return (
    <div className="col-lg-9 order-lg-12">
      {props.categories.map((element, index) => {
        return (
          <div className="row" key={index}>
            <div className="col-12">
              <h2 className="d-inline-block">{element.name}</h2>
              <Link
                className="btn btn-primary float-right"
                to={`/category/${element.id}`}
              >
                Xem thêm
              </Link>
            </div>
            {props.storiesPreview[element.id] !== undefined ? (
              props.storiesPreview[element.id].map((e, id) => {
                return (
                  <div className="col-lg-4" key={index}>
                    <div className="card mb-4 shadow-sm">
                      <img
                        src="https://www.upsieutoc.com/images/2020/03/17/img_dummy.jpg"
                        width="100%"
                        height="100%"
                        alt="pictur"
                      />
                      <div className="card-body">
                        <div className="d-flex justify-content-between align-items-center">
                          <h5 className="mb-0">
                            <Link to={`/story/${e.id}`}>{e.name}</Link>
                          </h5>
                          <small className="text-muted">
                            {new Date(e.created_time).toLocaleDateString()}
                          </small>
                        </div>
                        <p className="card-text">
                          This is a wider card with supporting text below as a
                          natural lead-in to additional content. This content is
                          a little bit longer.
                        </p>
                      </div>
                    </div>
                  </div>
                );
              })
            ) : (
              <div>nothing</div>
            )}
          </div>
        );
      })}
    </div>
  );
};
const mapStateToProps = state => {
  return {
    stories: state.stories,
    categories: state.categories,
    storiesPreview: state.storiesPreview
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchStoriesByCatID: (id, page, limit) => {
      dispatch(fetchStoriesByCatIDRequest(id, page, limit));
    },
    fetchPreview: () => {
      dispatch(fetchPreview());
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Categories);
