const Category = require("../models/category.model.js");

exports.create = (req, res) => {
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
  }

  const category = new Category({
    name: req.body.name,
    description: req.body.description,
    status: req.body.status
  });

  Category.create(category, (err, data) => {
    if (err)
      res.status(500).send({
        message:
          err.message || "Some error occurred while creating the Category."
      });
    else res.send(data);
  });
};

//Retrieve all Categories from the database & pagination.
exports.findAllWithPagination = (req, res) => {
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Category.getNumberOfRecords((err, data) => {
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
  Category.getConsecutiveRow(limit, offset, (err, data) => {
    if (err)
      res.status(500).send({
        message:
          err.message || "Some error occurred while retrieving categories."
      });
    else {
      result.result = data;
      res.json(result);
    }
  });
};

// Find Categories with categoryName
exports.findByName = (req, res) => {
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Category.getNumberOfRecordsFilterByName(req.params.keyWord, (err, data) => {
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
  Category.findByNameAndPaginated(
    req.params.keyWord,
    limit,
    offset,
    (err, data) => {
      if (err) {
        if (err.kind === "not_found") {
          res.status(404).send({
            message: `Not found Category with name ${req.params.keyWord}.`
          });
        } else {
          res.status(500).send({
            message: "Error retrieving Category with name " + req.params.keyWord
          });
        }
      } else {
        result.result = data;
        res.json(result);
      }
    }
  );
};

// Find a single Category with a categoryId
exports.findOne = (req, res) => {
  Category.findById(req.params.categoryId, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Category with id ${req.params.categoryId}.`
        });
      } else {
        res.status(500).send({
          message: "Error retrieving Category with id " + req.params.categoryId
        });
      }
    } else res.send(data);
  });
};

// Update a Category identified by the categoryId in the request
exports.update = (req, res) => {
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
  }

  Category.updateById(
    req.params.categoryId,
    new Category(req.body),
    (err, data) => {
      if (err) {
        if (err.kind === "not_found") {
          res.status(404).send({
            message: `Not found Category with id ${req.params.categoryId}.`
          });
        } else {
          res.status(500).send({
            message: "Error updating Category with id " + req.params.categoryId
          });
        }
      } else res.send(data);
    }
  );
};

// Delete a Category with the specified categoryId in the request
exports.delete = (req, res) => {
  Category.remove(req.params.categoryId, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Category with id ${req.params.categoryId}.`
        });
      } else {
        res.status(500).send({
          message: "Could not delete Category with id " + req.params.categoryId
        });
      }
    } else
      res.send({
        message: `Category was deleted successfully!`
      });
  });
};

// Delete all Categories from the database.
exports.deleteAll = (req, res) => {
  Category.removeAll((err, data) => {
    if (err)
      res.status(500).send({
        message:
          err.message || "Some error occurred while removing all categories."
      });
    else
      res.send({
        message: `All Categories were deleted successfully!`
      });
  });
};
