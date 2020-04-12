import * as types from "../../constants/ActionTypes";
const initialState = [];
const stories = (state = initialState, action) => {
  const { id, story } = action;
  switch (action.type) {
    case types.LIST_ALL_STORIES:
      return [...state];
    case types.FETCH_STORIES:
      state = action.stories;
      return [...state];
    case types.ADD_STORY:
      state.push(story);
      return [...state];
    case types.DELETE_STORY:
      state.splice(findIndex(state, id), 1);
      return [...state];
    // case types.UPDATE_CATEGORY:
    //     state[findIndex(state, story.id)] = story;
    //     return [...state];
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

export default stories;
