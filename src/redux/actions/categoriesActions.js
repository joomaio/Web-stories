import * as types from "../constants/ActionTypes";
import { callApi } from "../../utils/apiCaller";
//Fetch Categories
export const fetchCategoriesRequest = (
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  return dispatch => {
    return callApi(`categories?page=${page}&limit=${limit}`, "GET", null)
      .then(res => {
        dispatch(fetchCategories(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchCategories([]));
      });
  };
};
export const fetchCategories = data => {
  return {
    type: types.FETCH_CATEGORIES,
    categories: data.result,
    info: data.info
  };
};
//Add Category
export const addCategoryRequest = category => {
  return dispatch => {
    return callApi("categories", "POST", category)
      .then(res => {
        dispatch(addCategory(res.data));
      })
      .catch(err => {
        console.log(err);
      });
  };
};
export const addCategory = category => {
  return {
    type: types.ADD_CATEGORY,
    category
  };
};
//Delete Category
export const deleteCategoryRequest = category => {
  return async dispatch => {
    const res = await callApi(`category/${category.id}`, "DELETE", null);
    dispatch(deleteCategory(res.data));
  };
};

export const deleteCategory = category => {
  return {
    type: types.DELETE_CATEGORY,
    category
  };
};
//List All Categories
export const listAllCategories = () => {
  return {
    type: types.EDIT_CATEGORY
  };
};

//Get category to edit
export const fetchCategoryToEditRequest = id => {
  return dispatch => {
    return callApi(`category/${id}`, "GET", null).then(res => {
      dispatch(fetchCategoryToEdit(res.data));
    });
  };
};

export const fetchCategoryToEdit = category => {
  return {
    type: types.EDIT_CATEGORY,
    category
  };
};

//Update category

export const updateCategoryRequest = (category, id) => {
  return dispatch => {
    return callApi(`category/${id}`, "PUT", category).then(res => {
      dispatch(updateCategory(res.data, id));
    });
  };
};

export const updateCategory = (category, id) => {
  return {
    type: types.UPDATE_CATEGORY,
    category: { id, ...category }
  };
};
//Search

export const fetchCategoriesByNameRequest = (
  name,
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  return dispatch => {
    return callApi(
      `categories/search/${name}?page=${page}&limit=${limit}`,
      "GET",
      null
    )
      .then(res => {
        dispatch(fetchCategories(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchCategories([]));
      });
  };
};
