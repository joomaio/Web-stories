import * as types from "../../constants/ActionTypes";
const initialState = [];
const storyEditing = (state = initialState, action) => {
  switch (action.type) {
    case types.EDIT_STORY:
      return action.story;
    default:
      return state;
  }
};
export default storyEditing;
