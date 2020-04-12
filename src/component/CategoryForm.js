/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { connect } from "react-redux";
import {
  addCategoryRequest,
  fetchCategoryToEditRequest,
  updateCategoryRequest
} from "../redux/actions/categoriesActions";
const CategoryForm = props => {
  const { id } = useParams();
  const [state, setState] = useState({
    name: "",
    description: ""
  });
  useEffect(() => {
    console.log("componentDidMount");
    if (id !== "0") {
      props.onFetchCategory(id);
    } else {
      props.categoryEditing.name = "";
      props.categoryEditing.description = "";
    }
  }, []);
  useEffect(() => {
    console.log("componentWillReceiveProps");
    setState({
      name: props.categoryEditing.name,
      description: props.categoryEditing.description
    });
  }, [props.categoryEditing]);

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
    id !== "0"
      ? props.onUpdateCategory({ ...state, status: "publish" }, id)
      : props.onAddCategory({ ...state, status: "publish" });
    props.history.goBack();
  };
  return (
    <div className="container">
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <h2 className="mb-3">
              {id !== "0" ? "Chỉnh sửa chuyên mục" : "Thêm mới chuyên mục"}
            </h2>
            <form className="w-50" onSubmit={onSubmit}>
              <div className="form-group">
                <label htmlFor="inputName">Tên</label>
                <input
                  type="text"
                  className="form-control"
                  name="name"
                  value={state.name}
                  onChange={onChange}
                  required
                />
              </div>
              <div className="form-group">
                <label htmlFor="inputPassword4">Mô tả</label>
                <textarea
                  rows={4}
                  className="form-control"
                  name="description"
                  value={state.description}
                  onChange={onChange}
                />
              </div>
              <button type="submit" className="btn btn-primary">
                {id !== "0" ? "Chỉnh sửa" : "Thêm mới"}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};
const mapStateToProps = state => {
  return {
    categoryEditing: state.categoryEditing
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    onAddCategory: category => {
      dispatch(addCategoryRequest(category));
    },
    onFetchCategory: id => {
      dispatch(fetchCategoryToEditRequest(id));
    },
    onUpdateCategory: (category, id) => {
      dispatch(updateCategoryRequest(category, id));
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(CategoryForm);
