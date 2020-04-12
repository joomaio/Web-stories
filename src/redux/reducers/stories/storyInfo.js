import * as types from "../../constants/ActionTypes";
const initialState = {};
const storyInfo = (state = initialState, action) => {
  switch (action.type) {
    case types.FETCH_STORIES:
      return action.info;
    default:
      return state;
  }
};
export default storyInfo;
