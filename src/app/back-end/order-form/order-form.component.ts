import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ConnectdbService } from '../../connectdb.service';
declare var $: any;

@Component({
  selector: 'app-order-form',
  templateUrl: './order-form.component.html',
  styleUrls: ['./order-form.component.css']
})
export class OrderFormComponent implements OnInit {
  /* Create */
  //Total
  cartSubTotal = 0;

  /* Edit */
  //order edit
  editOrder = {};

  //include tax
  afterTax: number;

  //tất cả các cuốn sách
  listItems = [];
  //các cuốn sách đc chọn
  selectedItems = [];

  constructor(
    private getdb: ConnectdbService,
    private router: Router,
    private route: ActivatedRoute
  ) { }

  ngOnInit() {
    this.route.params.subscribe(params => {
      if (+params.id > 0) { //edit order
        this.getdb.getOrder(params.id).subscribe(data => {
          this.editOrder = data;
          this.getdb.getStories().subscribe(stories => {
            this.listItems = Array.from(Object.keys(stories['result']), k => stories['result'][k]);
            $('.selectpicker').selectpicker();
            let total1 = 0;
            this.listItems.forEach(a => {
              this.editOrder['items'].forEach(b => {
                if (b.id_story === a.id) {
                  a['selectedQty'] = b.order_qty;
                  a['subTotal'] = a['selectedQty'] * a.price;
                  total1 += a['subTotal'];
                  this.selectedItems.push(a);
                }
              });
            });
            this.cartSubTotal = total1;
            this.afterTax = +(this.cartSubTotal*1.1).toFixed(2);
          });
        });
      } else { //create order
        this.getdb.getStories().subscribe(stories => {
          this.listItems = Array.from(Object.keys(stories['result']), k => stories['result'][k]);
          $('.selectpicker').selectpicker();
        });
      }
    });
  }

  onSelectItemsSubmit(formValue) {
    var selectStory = JSON.parse(formValue['selected']);
    selectStory['selectedQty'] = 1;
    selectStory['subTotal'] = selectStory['selectedQty'] * selectStory['price'];
    // Do something awesome
    const count = this.selectedItems.filter((obj) => obj.id == selectStory.id).length;
    if (count == 1) {
      this.selectedItems.filter((obj) => {
        if (obj.id === selectStory.id) {
          obj.selectedQty += 1;
          obj.subTotal = obj.selectedQty * obj.price;
          this.updateQty(obj.id, obj.selectedQty);
        }
      });
    } else if (count < 1) {
      this.selectedItems.push(selectStory);
      this.updateQty(selectStory['id'], 1);
    }
  }

  updateQty(storyId, qty) {
    var total1 = 0;
    this.selectedItems.forEach(data => {
      if (data.id === storyId) data.subTotal = qty * data.price;
      total1 += data.subTotal
    });
    this.cartSubTotal = total1;
    this.afterTax = +(this.cartSubTotal*1.1).toFixed(2);
  }

  deleteStory(id) {
    let listAfterDelete = [];
    this.selectedItems.filter((obj) => {
      if (obj.id != id) {
        listAfterDelete.push(obj);
      }
    });
    this.selectedItems = listAfterDelete;
    this.selectedItems.forEach(data => {
      this.updateQty(data.id, data.selectedQty);
    });
  }

  onAddOrEdit(formValue) {
    formValue['orderItems'] = [];
    this.selectedItems.forEach(item => {        
      formValue['orderItems'].push({
        id : item.id,
        qty : item.selectedQty
      });
    });
    if(formValue['orderItems'].length > 0){
      this.route.params.subscribe(params => {
        if (+params.id > 0) { //edit order
          formValue['orderID'] = this.editOrder['id'];
          this.getdb.updateOrder(formValue).subscribe(
            response => {
              window.alert("This order has been updated!");
            },
            error => {
              console.log(error);
            }
          );
        } else { //create order
          // Do something awesome
          formValue['orderMessege'] = formValue['orderMessege'] != null ? formValue['orderMessege'] : '';
          this.getdb.addOrder(formValue).subscribe(
            response => {
              //window.alert("New order is being processed!");
            },
            error => {
              console.log(error);
            }
          );
          this.listItems = [];
          this.router.navigate(['/admin/orders']);
        }
      });
    }else{      
      window.alert("Please select items!");
    }
  }
}
