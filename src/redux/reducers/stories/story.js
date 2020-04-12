import * as types from "../../constants/ActionTypes";
const initialState = {};
const story = (state = initialState, action) => {
  switch (action.type) {
    case types.FETCH_STORY:
      return action.story;
    default:
      return state;
  }
};
export default story;
