const Story = require("../models/story.model.js");

// Create and Save a new Story
exports.create = (req, res) => {
  // Validate request
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
  }
  // Create a Story
  const story = new Story({
    name: req.body.name,
    content: req.body.content,
    feature_img: req.body.feature_img,
    status: req.body.status,
    created_time: req.body.created_time,
    created_user: req.body.created_user,
    last_modified_time: req.body.last_modified_time,
    last_modified_user: req.body.last_modified_user
  });
  // Save Story in the database
  Story.create(story, (err, data) => {
    if (err)
      res.status(500).send({
        message: err.message || "Some error occurred while creating the Story."
      });
    else res.send(data);
  });
};

// Pagination
exports.findAllWithPagination = (req, res) => {
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Story.getNumberOfStories((err, data) => {
    if (err)
      res.status(500).send({
        message: err.message || "Some error occurred while retrieving stories."
      });
    else {
      if (limit < 1) {
        numberOfPages = 1;
      } else {
        numberOfPages = Math.ceil(data / limit);
      }
      result.info = {
        numberOfPages: numberOfPages
      };
    }
  });
  Story.getConsecutiveRow(limit, offset, (err, data) => {
    if (err)
      res.status(500).send({
        message: err.message || "Some error occurred while retrieving stories."
      });
    else {
      result.result = data;
      res.json(result);
    }
  });
};

// Find a single Story with a storyId
exports.findOne = (req, res) => {
  Story.findById(req.params.storyId, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Story with id ${req.params.storyId}.`
        });
      } else {
        res.status(500).send({
          message: "Error retrieving Story with id " + req.params.storyId
        });
      }
    } else res.send(data);
  });
};

// Find stories with storyName
exports.findByName = (req, res) => {
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Story.getNumberOfRecordsInSearch(
    req.params.keyWord,
    req.query.cat,
    req.query.from,
    req.query.to,
    (err, data) => {
      if (err)
        res.status(500).send({
          message:
            err.message || "Some error occurred while retrieving categories."
        });
      else {
        numberOfPages = Math.ceil(data / limit);
        result.info = {
          numberOfPages: numberOfPages
        };
      }
    }
  );
  Story.findByNameInSearch(
    req.params.keyWord,
    req.query.cat,
    req.query.from,
    req.query.to,
    limit,
    offset,
    (err, data) => {
      if (err) {
        if (err.kind === "not_found") {
          res.status(404).send({
            message: `Not found Story with name ${req.params.keyWord}.`
          });
        } else {
          res.status(500).send({
            message: "Error retrieving Story with name " + req.params.keyWord
          });
        }
      } else {
        result.result = data;
        res.json(result);
      }
    }
  );
};

// Find stories with catName
exports.findByCatID = (req, res) => {
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Story.getNumberOfRecordsInCategory(req.params.catID, (err, data) => {
    if (err)
      res.status(500).send({
        message:
          err.message || "Some error occurred while retrieving categories."
      });
    else {
      numberOfPages = Math.ceil(data / limit);
      result.info = {
        numberOfPages: numberOfPages
      };
    }
  });
  Story.findByCatID(req.params.catID, limit, offset, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Story with name ${req.params.keyWord}.`
        });
      } else {
        res.status(500).send({
          message: "Error retrieving Story with name " + req.params.keyWord
        });
      }
    } else {
      result.result = data;
      res.json(result);
    }
  });
};

// Update a Story identified by the StoryId in the request
exports.update = (req, res) => {
  // Validate Request
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
  }

  Story.updateById(req.params.storyId, new Story(req.body), (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Story with id ${req.params.storyId}.`
        });
      } else {
        res.status(500).send({
          message: "Error updating Story with id " + req.params.storyId
        });
      }
    } else res.send(data);
  });
};

// Delete a Story with the specified storyId in the request
exports.delete = (req, res) => {
  Story.remove(req.params.storyId, req.query.cat_id, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Story with id ${req.params.storyId}.`
        });
      } else {
        res.status(500).send({
          message: "Could not delete Story with id " + req.params.storyId
        });
      }
    } else {
      res.send({ message: `Story was deleted successfully!` });
    }
  });
};
