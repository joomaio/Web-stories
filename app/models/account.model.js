const sql = require("./db.js");

class Account {
    constructor(account) {
        this.id = account.id;
        this.username = account.name;
        this.description = account.description;
        this.status = account.status;
    }
    static getAll=(result)=>{
        sql.query("SELECT * FROM accounts", (err, res) =>{
            if (err) {
                console.log("error: ", err);
                result(null, err);
                return;
              }
          
              console.log("stories: ", res);
              result(null, res);
        });
    } 
}
module.exports = Account;