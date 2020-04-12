/* eslint-disable react-hooks/exhaustive-deps */
import { connect } from "react-redux";
import React, { useState, useEffect } from "react";
import {
  addStoryRequest,
  fetchStoryToEditRequest,
  updateStoryRequest
} from "../redux/actions/storiesActions";
import {
  fetchCategoriesRequest,
} from "../redux/actions/categoriesActions";
import { useParams } from "react-router-dom";
const StoryForm = props => {
  const { id } = useParams();
  const [state, setState] = useState({
    name: "",
    content: ""
  });
  useEffect(() => {
    console.log("componentDidMount");
    props.fetchCategories();
    if (id !== "0") {
      props.fetchStory(id);
    } else {
      props.storyEditing.name = "";
      props.storyEditing.content = "";
    }
  }, []);
  useEffect(() => {
    console.log("componentWillReceiveProps");
    setState({
      name: props.storyEditing.name,
      content: props.storyEditing.content
    });
  }, [props.storyEditing]);
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
    console.log(state);

    id !== "0"
      ? props.updateStory(
          {
            name: state.name,
            content: state.content
          },
          id,
          state.cat_id
        )
      : props.addStory(
          {
            name: state.name,
            content: state.content,
            status: "publish"
          },
          state.cat_id
        );
    props.history.goBack();
  };
  return (
    <div className="container">
      <div className="search-result">
        <div className="row">
          <div className="col-12">
            <h2 className="mb-3">
              {id !== "0" ? "Chỉnh sửa truyện" : "Thêm mới truyện"}
            </h2>
            <form className="w-50" onSubmit={onSubmit}>
              <div className="form-group">
                <label htmlFor="inputEmail4">Tên</label>
                <input
                  type="text"
                  className="form-control"
                  name="name"
                  value={state.name}
                  onChange={onChange}
                />
              </div>
              <div className="form-group">
                Thể loại:
                <select
                  name="id_cat"
                  className="custom-select"
                  // eslint-disable-next-line react/jsx-no-duplicate-props
                  name="cat_id"
                  onChange={onChange}
                >
                  <option>Thể loại</option>
                  {props.categories.map(e => {
                    return <option value={e.id}>{e.name}</option>;
                  })}
                </select>
              </div>

              <div className="form-group">
                <label htmlFor="inputPassword4">Nội dung</label>
                <textarea
                  rows={10}
                  className="form-control"
                  name="content"
                  value={state.content}
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
    storyEditing: state.storyEditing,
    categories: state.categories
  };
};
const mapDispatchToProps = (dispatch, props) => {
  return {
    fetchCategories: (page, limit) => {
      dispatch(fetchCategoriesRequest(page, limit));
    },
    addStory: (story, cat_id) => {
      dispatch(addStoryRequest(story, cat_id));
    },
    fetchStory: id => {
      dispatch(fetchStoryToEditRequest(id));
    },
    updateStory: (story, id, cat_id) => {
      dispatch(updateStoryRequest(story, id,cat_id));
    }
  };
};
export default connect(mapStateToProps, mapDispatchToProps)(StoryForm);
