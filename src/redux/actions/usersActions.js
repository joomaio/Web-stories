import * as types from "../constants/ActionTypes";
import { callApi } from "../../utils/apiCaller";

//Fetch all stories
export const fetchUsersRequest = () => {
  return dispatch => {
    return callApi("accounts", "GET", null)
      .then(res => {
        dispatch(fetchUsers(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchUsers([]));
      });
  };
};
export const fetchUsers = users => {
  return {
    type: types.FETCH_USER,
    users
  };
};
