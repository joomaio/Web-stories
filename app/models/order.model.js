const sql = require("./db.js");

// constructor
class Order {
  constructor(order) {
    this.customer_name = order.customer_name;
    this.address = order.address;
    this.phone = order.phone;
    this.email = order.email;
    this.note = order.note;
    this.created_time = order.created_time;
    this.total = order.total;
    this.status = order.status;
  }; 
  
  static createOrder(newOrder, items, result) {
    sql.query("INSERT INTO orders SET ?", newOrder, (err, res) => {
      if (err) {
        result(err, null);
        return;        
      }

      let order = { id: res.insertId, ...newOrder };      
      order['items'] = items;

      let order_id = res.insertId;
      let orderItems = "";
      let i = 0;
      items.forEach((item) => {
        console.log('qty: ',item['qty']);
        let comma = (i==0) ? '':`,`;
        orderItems += `${comma}('${item['id']}','${order_id}','${item['qty']}')`;
        i++;
        sql.query(`UPDATE stories SET quantity = quantity - ${item['qty']} WHERE id = ${item['id']}`, (err, res) => {
          if (err) {
            result(err, null);
            return;
          }
        });
      });

      sql.query(`INSERT INTO item_of_order (id_story, id_order, order_qty) VALUES ${orderItems};`, (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(err, null);
          return;
        }
      });     

      result(null, order);
      return;
    });   
  };

  static getAllOrders(from, to, limit, offset, result) {    
    var fromQuery = from != null? `AND ord.created_time >= '${from}'`:``;
    var toQuery = to != null? `AND ord.created_time <= '${to} 23:59:59'`:``;

    sql.query(`SELECT * FROM orders as ord WHERE 1=1 ${fromQuery} ${toQuery}`, (err, res) => {
      if (err) {
        result(null, err);
        return;
      }
      let resWithPagination = {};
      let pageCount = Math.ceil(res.length/limit);

      resWithPagination['pages'] = pageCount;
      // console.log("count:",pageCount)
      sql.query(`SELECT * FROM orders AS ord WHERE 1=1 ${fromQuery} ${toQuery} ORDER BY ord.created_time DESC LIMIT ${limit} OFFSET ${offset}`, (err, res) => {
        if (err) {
          result(null, err);
          return;
        }
        resWithPagination['result'] = res;
        result(null, resWithPagination);
        return;
      });
    });
  };
  
  static removeOrder(id, result){
    sql.query(`SELECT * FROM item_of_order AS bio WHERE bio.id_order=${id}`, (err, res) => {
      if (err) {
        result(err, null);
        return;
      }
      res.forEach((item) => {
        sql.query(`UPDATE stories SET quantity = quantity + ${item['order_qty']} WHERE id = ${item['id_story']}`, (err, res) => {
          if (err) {
            result(err, null);
            return;
          }
        });
      });
      sql.query("DELETE t1, t2 FROM orders as t1 INNER JOIN item_of_order as t2 on t1.id = t2.id_order WHERE t1.id=?", id, (err, res) => {
        if (err) {
          result(null, err);
          return;
        }
      });

      result(null, res);
      return;
    });
  };  

  static getOrderByID(orderID, result) {
    var order = {};
    sql.query(`SELECT * FROM orders AS ord WHERE ord.id = ${orderID}`, (err, res) => {
      if (err) {
        result(err, null);
        return;
      }
      if (res.length) {
        order = res[0];
      }else{
        result({
          kind: "not_found"
        }, null);
      }
      sql.query(`SELECT * FROM item_of_order AS bio WHERE bio.id_order=${orderID}`, (err, res) =>{
        if (err) {
          result(err, null);
          return;
        }
        order['items'] = res;
        result(null, order);
      });

    });
  }
  static updateOrder(id, order, result) {
    sql.query(
      "UPDATE orders AS ord SET ord.customer_name = ?, ord.address = ?, ord.phone = ?, ord.email = ?, ord.note = ?, ord.total = ?, ord.status = ? WHERE ord.id = ?",
      [order['orderName'], order['orderAddress'], order['orderPhone'], order['orderEmail'], order['orderMessege'], order['orderTotal'], order['orderStatus'], id],
      (err, res) => {
        if (err) {
          result(null, err);
          return;
        }  
        if (res.affectedRows == 0) {
          // not found order with the id
          result({ kind: "not_found" }, null);
          return;
        }
        sql.query(`SELECT * FROM item_of_order AS bio WHERE bio.id_order=${id}`, (err, res) => {
          if (err) {
            result(err, null);
            return;
          }
          res.forEach((item) => {
            sql.query(`UPDATE stories SET quantity = quantity + ${item['order_qty']} WHERE id = ${item['id_story']}`, (err, res) => {
              if (err) {
                result(err, null);
                return;
              }
            });
          }); 
        });           
        sql.query(`DELETE FROM item_of_order WHERE id_order=${id}`, (err, res) => {
          if (err) {
            result(err, null);
            return;
          }
          let orderItems = "";
          let i = 0;
          order['orderItems'].forEach((item) => {
            let comma = (i==0) ? '':`,`;
            orderItems += `${comma}('${item['id']}','${id}','${item['qty']}')`;
            i++;
            sql.query(`UPDATE stories SET quantity = quantity - ${item['qty']} WHERE id = ${item['id']}`, (err, res) => {
              if (err) {
                result(err, null);
                return;
              }
            });
          });
          sql.query(`INSERT INTO item_of_order (id_story, id_order, order_qty) VALUES ${orderItems};`, (err, res) => {
            if (err) {
              result(err, null);
              return;
            }
          });     
        });      
        result(null, res[0]);
      }
    );
  };
}
module.exports = Order;