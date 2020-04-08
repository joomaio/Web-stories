const sql = require("./db.js");

class Category {
  constructor(category) {
    this.id = category.id;
    this.name = category.name;
    this.description = category.description;
    this.status = category.status;
  }
  static create(newCat, result) {
    sql.query("INSERT INTO categories SET ?", newCat, (err, res) => {
      console.log(newCat);
      if (err) {
        console.log("error: ", err);
        result(err, null);
        return;
      }
      console.log("created category: ", {
        id: res.insertId,
        ...newCat
      });
      result(null, {
        id: res.insertId,
        ...newCat
      });
    });
  }
  static getAll(result) {
    sql.query("SELECT * FROM categories", (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      console.log("categories: ", res);
      result(null, res);
    });
  }
  static getConsecutiveRow(limit, offset, result) {
    sql.query(
      `SELECT * FROM categories limit ${limit} offset ${offset}`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(null, err);
          return;
        }
        result(null, res);
      }
    );
  }
  static getNumberOfRecords(result) {
    sql.query("SELECT count(*) as total FROM categories", (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      result(null, res[0].total);
    });
  }
  static getNumberOfRecordsFilterByName(name, result) {
    sql.query(
      `SELECT count(*) as total FROM categories where name like '%${name}%'  collate utf8_general_ci`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(null, err);
          return;
        }
        result(null, res[0].total);
      }
    );
  }
  static findById(categoryID, result) {
    sql.query(
      `SELECT * FROM categories WHERE id = ${categoryID}`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(err, null);
          return;
        }
        if (res.length) {
          console.log("found category: ", res);
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
  }
  static findByNameAndPaginated(categoryName, limit, offset, result) {
    sql.query(
      `SELECT * FROM categories where name like '%${categoryName}%'  collate utf8_general_ci limit ${limit} offset ${offset}`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(err, null);
          return;
        }
        console.log("categories result: ", res);
        result(null, res);
      }
    );
  }
  static updateById(id, category, result) {
    sql.query(
      "UPDATE categories SET  name = ?, description = ?,status=? WHERE id = ?",
      [category.name, category.description, category.status, id],
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(null, err);
          return;
        }
        if (res.affectedRows == 0) {
          result(
            {
              kind: "not_found"
            },
            null
          );
          return;
        }
        console.log("updated category: ", {
            ...category,
            id: id
        });
        result(null, {
          id: id,
          ...category
        });
      }
    );
  }
  static remove(id, result) {
    sql.query("DELETE FROM categories WHERE id = ?", id, (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);
        return;
      }
      if (res.affectedRows == 0) {
        result(
          {
            kind: "not_found"
          },
          null
        );
        return;
      }
      console.log("deleted category with id: ", id);
      result(null, res);
    });
  }
}
module.exports = Category;
