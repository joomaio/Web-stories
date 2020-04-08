module.exports = app => {
  const categories = require("../controllers/category.controller.js");
  app.get("/categories", categories.findAllWithPagination);
  app.post("/categories", categories.create);
  app.get("/category/:categoryId", categories.findOne);
  app.put("/category/:categoryId", categories.update);
  app.delete("/category/:categoryId", categories.delete);
  app.get("/categories/search/:keyWord", categories.findByName);
  const stories = require("../controllers/story.controller.js");
  // Create a new Story
  app.post("/stories", stories.create);
  // Retrieve all stories with pagination
  app.get("/stories", stories.findAllWithPagination);
  // Retrieve a single Story with StoryId
  app.get("/story/:storyId", stories.findOne);
  // Update a Story with storyId
  app.put("/story/:storyId", stories.update);
  // Delete a Story with storyId
  app.delete("/story/:storyId", stories.delete);
  // Search Stories by Name
  app.get("/stories/search/:keyWord", stories.findByName);
  // Search stories with cat ID
  app.get("/stories/:catID", stories.findByCatID);
  const accounts = require("../controllers/account.controller");
  app.get("/accounts", accounts.findAll);
  // Router for order
  const orders = require("../controllers/order.controller");
  // create new order
  app.post("/order", orders.addOrder);
  //get all of orders
  app.get("/orders", orders.getAllOrders);
  //get order by id
  app.get("/order/:id", orders.getOrderByID);
  //delete order
  app.delete("/order/:id", orders.deleteOrder);
  // Update a order with storyId
  app.put("/order/:id", orders.updateOrder);
};
