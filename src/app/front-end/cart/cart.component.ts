import { Component, OnInit, ViewChild } from '@angular/core';
import { CartService } from 'src/app/cart.service';
import { ConnectdbService } from 'src/app/connectdb.service';
import { Router } from '@angular/router';
import { FormGroup, FormBuilder, Validators, FormControl } from '@angular/forms';

import { StripeService, StripeCardComponent, ElementOptions, ElementsOptions } from "ngx-stripe";

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrls: ['./cart.component.css']
})
export class CartComponent implements OnInit {
  @ViewChild(StripeCardComponent, {static: false}) card: StripeCardComponent;

  items = [];
  stories = [];

  //subtotal
  cartSubTotal = 0;

  //include tax
  afterTax: number;

  //display payment stripe
  isStripe = false;
  cardOptions: ElementOptions = {
    style: {
      base: {
        iconColor: '#666EE8',
        color: '#31325F',
        lineHeight: '40px',
        fontWeight: 300,
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSize: '18px',
        '::placeholder': {
          color: '#CFD7E0'
        }
      }
    }
  }; 
  elementsOptions: ElementsOptions = {
    locale: 'en'
  };

  //checkout form
  checkoutForm: FormGroup;

  constructor(
    private cart: CartService,
    private getdb: ConnectdbService,
    private router: Router,
    private stripeService: StripeService,
    private fb: FormBuilder
  ) {}

  ngOnInit() {
    this.checkoutForm = this.fb.group({
      orderName: ['', Validators.required],
      orderPhone: ['', Validators.required],
      orderEmail: ['', [Validators.required, Validators.email]],
      orderAddress: ['', Validators.required],
      orderMessege: ['', Validators.required],
      orderStatus: ['', Validators.required],
      orderTotal: ['', Validators.required]
    });
    this.items = this.cart.getItems();
    this.items.forEach((item) => {
      this.getdb.getStory(item.storyid).subscribe((story) => {
        this.stories.push({
          id : story['id'],
          name: story['name'],
          price: story['price'],
          quantity: story['quantity'],
          selectedQty : item.qty,
          subTotal : item.qty*story['price']
        });
        this.cartSubTotal += item.qty*story['price'];
        this.afterTax = +(this.cartSubTotal*1.1).toFixed(2);
      });
    });
    // if(this.isStripe){
      
    // }else{

    // }
  }
   
  updateQty(storyId,qty){
    var total1 = 0;
    this.stories.forEach(data => {
      if(data.id === storyId){
        data.selectedQty = qty;
        data.subTotal = qty*data.price;
      }
      total1 += data.subTotal;
    });
    this.cartSubTotal = total1;
    this.afterTax = +(this.cartSubTotal*1.1).toFixed(2);
  }
  deleteStory(story: number) {
    this.cart.deleteItem(story);    
    this.stories = [];
    this.cartSubTotal = 0;
    this.afterTax = 0;
    this.ngOnInit();
  }

  onSubmit(formValue) {
    formValue['orderItems'] = [];
    this.stories.forEach(item => {        
      formValue['orderItems'].push({
        id : item.id,
        qty : item.selectedQty
      });
    }); 
    if(this.isStripe){
      // checkout vois payment stripe
      formValue['orderStatus'] = "paid";
      this.stripeService
        .createToken(this.card.getCard(), { name })
        .subscribe(result => {
          if (result.token) {
            // Use the token to create a charge or a customer
            // https://stripe.com/docs/charges
            // console.log(result.token.id);            
            this.getdb.addOrder(formValue).subscribe(
              response => {
                // console.log(response);
              },
              error => {
                console.log(error);
              }
            );          
            this.cart.clearCart();
            // window.alert("Success! Your order is being processed!");
            this.cart.setInvoice(formValue);
            this.router.navigate(['/invoice']);
          } else if (result.error) {
            // Error creating the token
            console.log(result.error.message);
          }
        });
    }else{
      // Do something awesome
      formValue['orderStatus'] = "processing";
      this.getdb.addOrder(formValue).subscribe(
        response => {
          // console.log(response);
        },
        error => {
          console.log(error);
        }
      );
      this.cart.clearCart();
      // window.alert("Success! Your order is being processed!");
      this.cart.setInvoice(formValue);
      this.router.navigate(['/invoice']);
    }
  }
  cartCount(){
    return this.cart.getItemsCount();
  }
  onStripePayment(stripe: boolean){
    return this.isStripe = stripe;
  }
}
