const cors = require("cors");
const express = require("express");
const bodyParser = require("body-parser");
const app = express();
app.use(cors());

// const express = require("express");
// const app = express();
require("dotenv").config();
app.use(bodyParser.json());
app.use(
  bodyParser.urlencoded({
    extended: true
  })
);
app.get("/", (req, res) => {
  res.json({
    message: "Application boot"
  });
});
require("./app/routes/routes.js")(app);
app.listen(3000, () => {
  console.log("server is running on port 3000.");
});
