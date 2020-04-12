/* eslint-disable react-hooks/exhaustive-deps */
import { connect } from "react-redux";
import {
  fetchStoriesRequest,
  deleteStoryRequest,
  fetchStoriesByNameRequest
} from "../redux/actions/storiesActions";
import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
const limit = 10;
const StoriesManagement = props => {
  const [keyWord, setKeyWord] = useState();
  useEffect(() => {
    props.fetchStories(1, limit);
  }, []);
  const onDelete = story => {
    // eslint-disable-next-line no-restricted-globals
    if (confirm("DELETE?")) props.onDeleteStory(story);
  };
  const onChange = event => {
    const { value } = event.target;
    setKeyWord(value);
  };
  const onSearch = event => {
    event.preventDefault();
    console.log(keyWord);
    if (keyWord === undefined || keyWord === "") {
      props.fetchStories(1, limit);
    } else props.onfetchStoriesByName(keyWord, 1, limit);
  };
  const onChangePage = page => {
    if (keyWord === undefined) props.fetchStories(page, limit);
    else props.onfetchStoriesByName(keyWord, page, limit);
  };
  return (
    <div className="container">
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <h2 className="d-inline-block">Danh sách truyện</h2>
            <Link
              to="/admin/story/0"
              className="btn btn-primary float-right ml-3"
            >
              Thêm mới
            </Link>
            <form className="d-inline-block float-right" onSubmit={onSearch}>
              <div className="input-group">
                <input
                  type="text"
                  className="form-control"
                  placeholder="Search"
                  aria-label="Recipient's username"
                  aria-describedby="button-addon2"
                  value={keyWord}
                  onChange={onChange}
                />
                <div className="input-group-append">
                  <button
                    className="btn btn-primary"
                    type="submit"
                    id="button-addon2"
                  >
                    Search
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div className="col-12">
            <table className="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">STT</th>
                  <th scope="col">Thể loại</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Thời gian đăng</th>
                  <th scope="col">Người đăng</th>
                  <th scope="col">Lần sửa cuối</th>
                  <th scope="col">Người sửa cuối</th>
                  <th scope="col">Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                {props.stories.map((element, index) => {
                  return (
                    <tr key={index}>
                      <th scope="row"> {element.id} </th>
                      <td>{element.catname}</td>
                      <td>{element.name}</td>
                      <td>{new Date(element.created_time).toLocaleString()}</td>
                      <td>{element.created_user}</td>
                      <td>{new Date(element.last_modified_time).toLocaleString()}</td>
                      <td>{element.last_modified_user}</td>
                      <td>
                        <button
                          className="btn btn-danger btn-sm mr-1"
                          onClick={() => onDelete(element)}
                        >
                          Xóa
                        </button>
                        <Link
                          to={`/admin/story/${element.id}`}
                          className="badge badge-success"
                        >
                          Sửa
                        </Link>
                      </td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
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
      </div>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    stories: state.stories,
    numberOfPages: state.storyInfo.numberOfPages
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchStories: (page, limit) => {
      dispatch(fetchStoriesRequest(page, limit));
    },
    onDeleteStory: story => {
      dispatch(deleteStoryRequest(story));
    },
    onfetchStoriesByName: (name, page, limit) => {
      dispatch(fetchStoriesByNameRequest(name, page, limit));
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(StoriesManagement);
