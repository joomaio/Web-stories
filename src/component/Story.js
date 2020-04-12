/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect } from "react";
import { connect } from "react-redux";
import { fetchStoryByIDRequest } from "../redux/actions/storiesActions";
import { Link } from "react-router-dom";

const Story = props => {
  const { id } = props.match.params;
  useEffect(() => {
    props.fetchStory(id);
  }, []);
  return (
    <div className="col-lg-9 order-lg-12">
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <nav aria-label="breadcrumb">
              <ol className="breadcrumb">
                <li className="breadcrumb-item">
                  <Link to="/">Trang chủ</Link>
                </li>
                <li className="breadcrumb-item">
                  <Link to={`/category/${props.story.cat_id}`}>
                    {props.story.catname}
                  </Link>
                </li>
                <li className="breadcrumb-item active" aria-current="page">
                  {props.story.name}
                </li>
              </ol>
            </nav>
            <h2>{props.story.name}</h2>
            <img
              alt="binh"
              className="img-thumbnail mb-3"
              src="https://www.upsieutoc.com/images/2020/03/17/img_dummy.jpg"
            />
            <p>{props.story.content}</p>
            <hr />
            <span className="float-right">
              <em>Chuyên mục:</em> {props.story.catname}
            </span>
          </div>
        </div>
      </div>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    story: state.story
  };
};
const mapDispatchToProps = dispatch => {
  return {
    fetchStory: id => {
      dispatch(fetchStoryByIDRequest(id));
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(Story);
