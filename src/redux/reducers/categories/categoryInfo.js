import * as types from "../../constants/ActionTypes";
const initialState = {};
const categoryInfo = (state = initialState, action) => {
  switch (action.type) {
    case types.FETCH_CATEGORIES:
      return action.info;
    default:
      return state;
  }
};
export default categoryInfo;
