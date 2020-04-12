/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { connect } from "react-redux";
import { fetchStoriesByNameAndCatIDRequest } from "../redux/actions/storiesActions";
import { Link } from "react-router-dom";
const Search = props => {
  //const limit = 5;
  const queryParams = new URLSearchParams(window.location.search);
  const [state, setState] = useState({
    keyWord: props.match.params.keyWord,
    cat: queryParams.get("cat"),
    fromDate: queryParams.get("from"),
    toDate: queryParams.get("to")
  });
  useEffect(() => {
    props.filterStories(state.keyWord, state.cat, state.fromDate, state.toDate);
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
    props.filterStories(state.keyWord, state.cat, state.fromDate, state.toDate);
    const urlCatID =
      state.cat === "" || state.cat === null || state.cat === undefined
        ? ""
        : `cat=${state.cat}`;
    const urlFromDate =
      state.fromDate === "" ||
      state.fromDate === null ||
      state.fromDate === undefined
        ? ""
        : `&fromDate=${state.fromDate}`;
    const urlToDate =
      state.toDate === "" || state.toDate === null || state.toDate === undefined
        ? ""
        : `&toDate=${state.toDate}`;
    props.history.push({
      pathname: `/stories/search/${state.keyWord}?${urlCatID}${urlFromDate}${urlToDate}`
    });
  };
  return (
    <div className="col-lg-9 order-lg-12">
      <div className="search-form mb-5">
        <h2>Tìm kiếm</h2>
        <form onSubmit={onSubmit}>
          <div className="form-row">
            <div className="form-group col-md-3">
              <label htmlFor="inputCity">Từ khóa</label>
              <input
                type="text"
                className="form-control"
                id="inputCity"
                defaultValue={state.keyWord}
                name="keyWord"
                onChange={onChange}
              />
            </div>
            <div className="form-group col-md-3">
              <label htmlFor="inputState">Chuyên mục</label>
              <select
                value={state.cat}
                className="form-control"
                name="cat"
                onChange={onChange}
              >
                <option selected>Chọn...</option>
                {props.categories.map((element, index) => {
                  return <option value={element.id}>{element.name}</option>;
                })}
              </select>
            </div>
            <div className="form-group col-md-3">
              <label htmlFor="inputZip1">Từ ngày</label>
              <input
                type="date"
                className="form-control"
                name="fromDate"
                value={state.fromDate}
                onChange={onChange}
              />
            </div>
            <div className="form-group col-md-3">
              <label htmlFor="inputZip2">Đến ngày</label>
              <input
                type="date"
                className="form-control"
                name="toDate"
                value={state.toDate}
                onChange={onChange}
              />
            </div>
          </div>
          <button type="submit" className="btn btn-primary">
            Search
          </button>
        </form>
      </div>
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <h2>Kết quả cho từ khóa: {state.keyWord}</h2>
          </div>
          {props.stories.map((element, id) => {
            return (
              <div className="col-lg-4" id={id}>
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
      </div>
    </div>
  );
};

const mapStateToProps = state => {
  return {
    categories: state.categories,
    stories: state.stories
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    filterStories: (name, catID, fromDate, toDate, page, limit) => {
      dispatch(
        fetchStoriesByNameAndCatIDRequest(
          name,
          catID,
          fromDate,
          toDate,
          page,
          limit
        )
      );
    }
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(Search);
