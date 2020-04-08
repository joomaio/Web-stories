const sql = require("./db.js");

// constructor
const Story = function(story) {
  this.name = story.name;
  this.content = story.content;
  this.feature_img = story.feature_img;
  this.status = story.status;
  this.created_time = story.created_time;
  this.created_user = story.created_user;
  this.last_modified_time = story.last_modified_time;
  this.last_modified_user = story.last_modified_user;
  this.price = story.price;
  this.quantity = story.quantity;
};

Story.create = (newStory, result) => {
  sql.query("INSERT INTO stories SET ?", newStory, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);
      return;
    }

    console.log("created story: ", { id: res.insertId, ...newStory });
    result(null, { id: res.insertId, ...newStory });
  });
};

Story.findById = (storyID, result) => {
  sql.query(
    `SELECT s.*, c.id as cat_id,c.name as catname FROM stories AS s 
  JOIN story_of_category AS soc ON soc.id_story = s.id JOIN categories AS c ON c.id=soc.id_cat 
  WHERE s.id = ${storyID}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(err, null);
        return;
      }
      if (res.length) {
        console.log("found story: ", res);
        result(null, res[0]);
        return;
      }
      result(
        {
          kind: "not_found"
        },
        null
      );
    }
  );
};

Story.findByCatID = (catID, limit, offset, result) => {
  sql.query(
    `SELECT s.*,c.name as catname FROM stories AS s 
  JOIN story_of_category AS soc ON soc.id_story = s.id JOIN categories AS c ON c.id=soc.id_cat 
  WHERE soc.id_cat=${catID} ORDER BY s.name DESC LIMIT ${limit} OFFSET ${offset}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      console.log("stories: ", res);
      result(null, res);
    }
  );
};

Story.getNumberOfRecordsInCategory = (catID, result) => {
  sql.query(
    `SELECT count(*) as total FROM stories AS s 
  JOIN story_of_category AS soc ON soc.id_story = s.id JOIN categories AS c ON c.id=soc.id_cat 
  WHERE soc.id_cat=${catID}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      result(null, res[0].total);
    }
  );
};

Story.findByNameInSearch = (
  storyName,
  cat,
  from,
  to,
  limit,
  offset,
  result
) => {
  var catQuery =
    cat != null ? `JOIN story_of_category AS soc ON soc.id_story = s.id` : "";
  var catid = cat != null ? `AND soc.id_cat = ${cat}` : "";

  var fromQuery = from != null ? `AND s.created_time >= '${from}'` : "";
  var toQuery = to != null ? `AND s.created_time <= '${to}'` : "";
  sql.query(
    `SELECT * FROM stories AS s ${catQuery} WHERE s.name like '%${storyName}%' ${catid} ${fromQuery} ${toQuery} COLLATE utf8_general_ci LIMIT ${limit} OFFSET ${offset}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(err, null);
        return;
      }
      console.log("stories result: ", res);
      result(null, res);
    }
  );
};

Story.getNumberOfRecordsInSearch = (storyName, cat, from, to, result) => {
  var catQuery =
    cat != null ? `JOIN story_of_category AS soc ON soc.id_story = s.id` : "";
  var catid = cat != null ? `AND soc.id_cat = ${cat}` : "";

  var fromQuery = from != null ? `AND s.created_time >= '${from}'` : "";
  var toQuery = to != null ? `AND s.created_time <= '${to}'` : "";
  sql.query(
    `SELECT count(*) as total FROM stories AS s ${catQuery} WHERE s.name LIKE '%${storyName}%' ${catid} ${fromQuery} ${toQuery}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      result(null, res[0].total);
    }
  );
};

Story.getConsecutiveRow = (limit, offset, result) => {
  sql.query(
    `SELECT s.*,c.name as catname, c.id as cat_id, acc1.username as create_user_name, acc2.username as last_modified_user_name 
    FROM stories AS s JOIN story_of_category AS soc ON soc.id_story = s.id 
    JOIN categories AS c ON c.id=soc.id_cat 
    JOIN accounts as acc1 on acc1.id = s.created_user 
    JOIN accounts as acc2 on acc2.id = s.last_modified_user 
    ORDER BY s.id 
 limit ${limit} offset ${offset}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      result(null, res);
    }
  );
};

Story.getNumberOfStories = result => {
  sql.query("SELECT count(*) as total FROM stories AS s", (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(null, err);
      return;
    }
    result(null, res[0].total);
  });
};

Story.getAll = result => {
  sql.query("SELECT * FROM stories", (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(null, err);
      return;
    }

    console.log("stories: ", res);
    result(null, res);
  });
};

Story.updateById = (id, story, result) => {
  sql.query(
    "UPDATE stories SET content = ?, name = ? WHERE id = ?",
    [story.content, story.name, id],
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }

      if (res.affectedRows == 0) {
        // not found Story with the id
        result({ kind: "not_found" }, null);
        return;
      }

      console.log("updated story: ", { id: id, ...story });
      result(null, { id: id, ...story });
    }
  );
};

Story.remove = (id, cat_id, result) => {
  sql.query(
    `DELETE FROM story_of_category WHERE id_story = ${id} and id_cat = ${cat_id}`,
    (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(err, null);
        return;
      }
      sql.query("DELETE FROM stories WHERE stories.id = ?", id, (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(null, err);
          return;
        }
        if (res.affectedRows == 0) {
          // not found Story with the id
          result({ kind: "not_found" }, null);
          return;
        }
        console.log("deleted story with id: ", id);
        result(null, res);
      });
    }
  );
};

module.exports = Story;
