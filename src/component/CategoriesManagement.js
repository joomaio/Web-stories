/* eslint-disable no-restricted-globals */
/* eslint-disable react-hooks/exhaustive-deps */
import React, { useEffect, useState, useReducer } from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";
import {
  fetchCategoriesRequest,
  deleteCategoryRequest,
  fetchCategoriesByNameRequest
} from "../redux/actions/categoriesActions";
const limit = 10;
const CategoriesManagement = props => {
  const [keyWord, setKeyWord] = useState();
  useEffect(() => {
    props.fetchCategories(1, limit);
  }, []);
  //Search
  const onSearch = event => {
    event.preventDefault();
    console.log(keyWord);
    if (keyWord === undefined || keyWord === "") {
      props.fetchCategories(1, limit);
    } else props.onfetchCategoriesByName(keyWord, 1, limit);
  };
  const onChange = event => {
    const { value } = event.target;
    setKeyWord(value);
  };
  //Delete
  const onDelete = category => {
    if (confirm("DELETE?")) props.onDeleteCategory(category);
  };
  //Pagination
  const onChangePage = page => {
    if (keyWord === undefined || keyWord === "")
      props.fetchCategories(page, limit);
    else props.onfetchCategoriesByName(keyWord, page, limit);
  };
  return (
    <div className="container">
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <h2 className="d-inline-block">Danh sách chuyên mục</h2>
            <Link
              to="/admin/category/0"
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
                  <th scope="col">ID</th>
                  <th scope="col">Tên</th>
                  <th scope="col">Mô tả</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                {props.categories.map((element, index) => {
                  return (
                    <tr key={index}>
                      <th scope="row">{element.id}</th>
                      <td>{element.name}</td>
                      <td>{element.description}</td>
                      <td>
                        <button
                          className="btn btn-danger btn-sm mr-1"
                          onClick={() => onDelete(element)}
                        >
                          Xóa
                        </button>
                        <Link
                          to={`/admin/category/${element.id}`}
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
                    <li class="page-item ">
                      <button
                        class="page-link "
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
    categories: state.categories,
    numberOfPages: state.categoryInfo.numberOfPages
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchCategories: (page, limit) => {
      dispatch(fetchCategoriesRequest(page, limit));
    },
    onDeleteCategory: category => {
      dispatch(deleteCategoryRequest(category));
    },
    onfetchCategoriesByName: (name, page, limit) => {
      dispatch(fetchCategoriesByNameRequest(name, page, limit));
    }
  };
};
export default connect(
  mapStateToProps,
  mapDispatchToProps
)(CategoriesManagement);
