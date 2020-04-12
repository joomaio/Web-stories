import * as types from "../../constants/ActionTypes";
const initialState = {};
const users = (state = initialState, action) => {
  switch (action.type) {
    case types.FETCH_USER:
      return action.users;
    default:
      return state;
  }
};
export default users;
