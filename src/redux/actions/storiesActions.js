import * as types from "../constants/ActionTypes";
import { callApi } from "../../utils/apiCaller";

//Fetch all stories
export const fetchStoriesRequest = (
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  return dispatch => {
    return callApi(`stories?page=${page}&limit=${limit}`, "GET", null)
      .then(res => {
        dispatch(fetchStories(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchStories([]));
      });
  };
};
export const fetchStories = data => {
  return {
    type: types.FETCH_STORIES,
    stories: data.result,
    info: data.info
  };
};
//Fetch story by ID
export const fetchStoryByIDRequest = id => {
  return dispatch => {
    return callApi(`story/${id}`, "GET", null)
      .then(res => {
        dispatch(fetchStoryByID(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchStoryByID([]));
      });
  };
};

export const fetchStoryByID = story => {
  return {
    type: types.FETCH_STORY,
    story
  };
};

//Fetch stories by catID
export const fetchStoriesByCatIDRequest = (
  id,
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  return dispatch => {
    return callApi(`stories/${id}?page=${page}&limit=${limit}`, "GET", null)
      .then(res => {
        dispatch(fetchStories(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchStories([]));
      });
  };
};

//Delete Story
export const deleteStoryRequest = story => {
  return async dispatch => {
    const res = await callApi(
      `story/${story.id}?cat_id=${story.cat_id}`,
      "DELETE",
      null
    );
    dispatch(deleteStory(res.data));
  };
};

export const deleteStory = story => {
  return {
    type: types.DELETE_STORY,
    story
  };
};

//List All Stories
export const listAllStories = () => {
  return {
    type: types.EDIT_STORY
  };
};

//Get story to edit
export const fetchStoryToEditRequest = id => {
  return dispatch => {
    return callApi(`story/${id}`, "GET", null).then(res => {
      dispatch(fetchStoryToEdit(res.data));
    });
  };
};

export const fetchStoryToEdit = story => {
  return {
    type: types.EDIT_STORY,
    story
  };
};

//Update story

export const updateStoryRequest = (story, id, cat_id) => {
  return dispatch => {
    return callApi(`story/${id}?cat_id=${cat_id}`, "PUT", {
      ...storyExample,
      ...story
    }).then(res => {
      dispatch(updateStory(res.data, id));
    });
  };
};

export const updateStory = (story, id) => {
  return {
    type: types.UPDATE_STORY,
    story: { id, ...story }
  };
};

//Search stories by name

export const fetchStoriesByNameRequest = (
  name,
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  return dispatch => {
    return callApi(
      `stories/search/${name}?page=${page}&limit=${limit}`,
      "GET",
      null
    )
      .then(res => {
        dispatch(fetchStories(res.data));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchStories([]));
      });
  };
};

//Search stories by name & catID
export const fetchStoriesByNameAndCatIDRequest = (
  name,
  catID,
  fromDate,
  toDate,
  page = 1,
  limit = Number.MAX_SAFE_INTEGER
) => {
  const urlCatID =
    catID === "" || catID === null || catID === undefined
      ? ""
      : `cat=${catID}&`;
  return dispatch => {
    return callApi(
      `stories/search/${name}?${urlCatID}page=${page}&limit=${limit}`,
      "GET",
      null
    ).then(res => {
      dispatch(filterStories(res.data, fromDate, toDate));
    });
  };
};
export const filterStories = (data, fromDate, toDate) => {
  const stories = data.result;
  let filterStories = [];
  if ((fromDate === null) & (toDate === null)) filterStories = stories;
  if (fromDate === null)
    stories.forEach(element => {
      if (element.created_time <= toDate) filterStories.push(element);
    });
  if (toDate === null)
    stories.forEach(element => {
      if (element.created_time >= fromDate) filterStories.push(element);
    });
  else
    stories.forEach(element => {
      if (element.created_time >= fromDate && element.created_time <= toDate)
        filterStories.push(element);
    });
  return {
    type: types.FETCH_STORIES,
    stories: filterStories,
    info: data.info
  };
};
//Add Story
const storyExample = {
  name: "",
  feature_img: "",
  status: "publish",
  created_time: "0000-00-00 00:00:00",
  created_user: 2,
  last_modified_time: "0000-00-00 00:00:00",
  last_modified_user: 2
};

export const addStoryRequest = (story, cat_id) => {
  return async dispatch => {
    try {
      await callApi(`stories/${cat_id}`, "POST", {
        ...storyExample,
        ...story
      });
    } catch (err) {
      console.log(err);
    }
  };
};

//Fetch stories preview
export const fetchStoriesPreviewRequest = () => {};

export const fetchPreview = () => {
  return async dispatch => {
    const res = await callApi(`categories`, "GET", null);
    res.data.result.forEach(e => {
      dispatch(fetchStoryPreviewRequest(e.id));
    });
  };
};
export const fetchStoryPreviewRequest = id => {
  return dispatch => {
    return callApi(`stories/${id}?page=1&limit=3`, "GET", null)
      .then(res => {
        dispatch(fetchStoriesPreview(res.data.result, id));
      })
      .catch(err => {
        console.log(err);
        dispatch(fetchStoriesPreview([]));
      });
  };
};
export const fetchStoriesPreview = (stories, id) => {
  return {
    type: types.FETCH_STORIES_PREVIEW,
    stories,
    id
  };
};
