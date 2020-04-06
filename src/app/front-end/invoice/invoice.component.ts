import { Component, OnInit } from '@angular/core';
import { CartService } from 'src/app/cart.service';
import { ConnectdbService } from 'src/app/connectdb.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-invoice',
  templateUrl: './invoice.component.html',
  styleUrls: ['./invoice.component.css']
})
export class InvoiceComponent implements OnInit {
  invoice = {};
  items = [];
  stories = [];
  datenow = new Date();

  //subtotal
  cartSubTotal = 0;

  hasInvoice = false;
  
  constructor(
    private cart: CartService,
    private router: Router,
    private getdb: ConnectdbService
  ) { }

  ngOnInit() {
    this.invoice = this.cart.getInvoice();
    this.hasInvoice = (Object.keys(this.invoice).length === 0) ? false:true;
    if(this.hasInvoice){
      this.items = Object.values(this.invoice['orderItems']);
      this.items.forEach(item => {
        this.getdb.getStory(item.id).subscribe(story =>{
          story['qty'] = item.qty;        
          story['total'] = story['qty']*story['price'];        
          this.cartSubTotal += story['total'];       
          this.stories.push(story);
        });
      });
    }
  }

  printInvoice(){
    window.print();
  }
}
