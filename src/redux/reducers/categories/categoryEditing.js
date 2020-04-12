import * as types from "../../constants/ActionTypes";
const initialState = [];
const categoryEditing = (state = initialState, action) => {
  switch (action.type) {
    case types.EDIT_CATEGORY:
      return action.category;
    default:
      return state;
  }
};
export default categoryEditing;
