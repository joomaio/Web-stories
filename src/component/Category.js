/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect } from "react";
import { Link, useParams } from "react-router-dom";
import { fetchStoriesByCatIDRequest } from "../redux/actions/storiesActions";
import { connect } from "react-redux";
const limit = 6;
const Category = props => {
  const { id } = useParams();
  useEffect(() => {
    props.fetchStoriesByCatId(id, 1, limit);
  }, [id]);
  const onChangePage = event => {
    props.fetchStoriesByCatId(id, event, limit);
  };
  return (
    <div className="col-lg-9 order-lg-12">
      <div className="row">
        <div className="col-12">
          <h2 className="d-inline-block">
            {getCategoryName(props.categories, id)}
          </h2>
        </div>
        <div className="row">
          {props.stories.map((element, index) => {
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
                        <Link to={`/story/${element.id}`}>{element.name}</Link>
                      </h5>
                      <small className="text-muted">
                        {new Date(element.created_time).toLocaleDateString()}
                      </small>
                    </div>
                    <p className="card-text">
                      This is a wider card with supporting text below as a
                      natural lead-in to additional content. This content is a
                      little bit longer.
                    </p>
                  </div>
                </div>
              </div>
            );
          })}
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <button
                class="page-link"
                onClick={() => {
                  onChangePage(1);
                }}
                aria-label="Next"
              >
                <span aria-hidden="true">&laquo;</span>
              </button>
            </li>
            {[...Array(props.numberOfPages).keys()].map(element => {
              return (
                <li class="page-item">
                  <button
                    class="page-link"
                    onClick={() => {
                      onChangePage(element + 1);
                    }}
                  >
                    {element + 1}
                  </button>
                </li>
              );
            })}

            <li class="page-item">
              <button
                class="page-link"
                onClick={() => {
                  onChangePage(props.numberOfPages);
                }}
                aria-label="Next"
              >
                <span aria-hidden="true">&raquo;</span>
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  );
};
const getCategoryName = (categories = [], id) => {
  
  let name = "";
  categories.forEach(e => {
    if (e.id === id) name = e.name;
  });
  return name;
};
const mapStateToProps = state => {
  return {
    stories: state.stories,
    categories: state.categories,
    numberOfPages: state.storyInfo.numberOfPages
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchStoriesByCatId: (id, page, limit) => {
      dispatch(fetchStoriesByCatIDRequest(id, page, limit));
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Category);
