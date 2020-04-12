import { createStore, combineReducers, applyMiddleware, compose } from "redux";
import categories from "./reducers/categories/categories";
import categoryEditing from "./reducers/categories/categoryEditing";
import stories from "./reducers/stories/stories";
import storyEditing from "./reducers/stories/storyEditing";
import storyPreview from "./reducers/stories/storyPreview";
import categoryInfo from "./reducers/categories/categoryInfo";
import storyInfo from "./reducers/stories/storyInfo";
import storiesPreview from "./reducers/stories/storyPreview";
import story from "./reducers/stories/story";
import users from "./reducers/users/users";

import thunk from "redux-thunk";
const composeEnhancer = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;
const reducers = combineReducers({
  categories,
  categoryEditing,
  categoryInfo,
  stories,
  storyEditing,
  storyPreview,
  storyInfo,
  story,
  storiesPreview,
  users
});
const store = createStore(reducers, composeEnhancer(applyMiddleware(thunk)));
export default store;
