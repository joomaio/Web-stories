import * as types from "../../constants/ActionTypes";
const initialState = [];
const categories = (state = initialState, action) => {
  const { id, category } = action;
  switch (action.type) {
    case types.LIST_ALL_CATEGORIES:
      return [...state];
    case types.FETCH_CATEGORIES:
      state = action.categories;
      return [...state];
    // case types.FETCH_CATEGORY:
    //   state = action.category;
    //   return [...state];
    case types.ADD_CATEGORY:
      state.push(category);
      return [...state];
    case types.DELETE_CATEGORY:
      state.splice(findIndex(state, id), 1);
      return [...state];
    case types.UPDATE_CATEGORY:
      state[findIndex(state, category.id)] = category;
      return [...state];

    default:
      return [...state];
  }
};
const findIndex = (arr, id) => {
  arr.forEach((e, i) => {
    if (e.id === id) return i;
  });
  return -1;
};
export default categories;
