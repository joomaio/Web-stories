const Order = require("../models/order.model.js");

// Create and Save a new Order
exports.addOrder = (req, res) => {
  if (!req.body) {
      res.status(400).send({
          message: "Content can not be empty!"
      });
  }
  
  //set created_time is current
  let today = new Date();
  let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
  let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
  let currentTime = date+' '+time;

  const order = new Order({
    customer_name: req.body.orderName,
    address: req.body.orderAddress,
    phone: req.body.orderPhone,
    email: req.body.orderEmail,
    note: req.body.orderMessege,
    created_time: currentTime,
    total: req.body.orderTotal,
    status: req.body.orderStatus
  });

  //stories in cart
  let items = req.body.orderItems;
  
  Order.createOrder(order, items, (err, data) => {
    if (err)
      res.status(500).send({
        message: err.message || "Some error occurred while creating the Order."
      });
    else res.send(data);
  });
};

// Get all orders
exports.getAllOrders = (req, res) => {
  const from = req.query.from || null;
  const to = req.query.to || null;
  const limit = req.query.limit || 10;
  const page = req.query.page || 1;
  const offset = (page - 1) * limit;
  let numberOfPages;
  const result = {};
  Order.getAllOrders(from, to, limit, offset, (err, data) => {
    if (err)
      res.status(500).send({
          message: err.message || "Some error occurred while retrieving orders."
      });
    else {
      
      res.send(data);
    }
  })
}

// Delete a Order with the specified storyId in the request
exports.deleteOrder = (req, res) => {
  Order.removeOrder(req.params.id, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Order with id ${req.params.id}.`
        });
      } else {
        res.status(500).send({
          message: "Could not delete Order with id " + req.params.id
        });
      }
    } else {      
      res.send({ message: `Order was deleted successfully!` });
    }
  });
};

// Get all orders
exports.getOrderByID = (req, res) => {
  Order.getOrderByID(req.params.id, (err, data) => {
    if (err) {
      if (err.kind === "not_found") {
        res.status(404).send({
          message: `Not found Order with id ${req.params.id}.`
        });
      } else {
        res.status(500).send({
          message: "Error retrieving Order with id " + req.params.id
        });
      }
    } else res.send(data);
  });
}

// Update a Order identified by the StoryId in the request
exports.updateOrder = (req, res) => {
  // Validate Request
  if (!req.body) {
    res.status(400).send({
      message: "Content can not be empty!"
    });
  }

  Order.updateOrder(
    req.params.id,
    req.body,
    (err, data) => {
      if (err) {
        if (err.kind === "not_found") {
          res.status(404).send({
            message: `Not found Order with id ${req.params.id}.`
          });
        } else {
          res.status(500).send({
            message: "Error updating Order with id " + req.params.id
          });
        }
      } else res.send(data);
    }
  );
};
