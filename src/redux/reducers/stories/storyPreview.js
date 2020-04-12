import * as types from "../../constants/ActionTypes";
const initialState = [];
const storyPreview = (state = initialState, action) => {
  switch (action.type) {
    case types.FETCH_STORIES_PREVIEW:
      state[action.id] = [...action.stories];
      return [...state];
    default:
      return [...state];
  }
};
export default storyPreview;
