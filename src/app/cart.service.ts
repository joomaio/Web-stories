import { Injectable } from '@angular/core';
import { Story } from './story';

@Injectable({
  providedIn: 'root'
})
export class CartService {
  // items = [];
  invoice = {};
  constructor() {
  }
  
  setInvoice(checkoutData){
    this.invoice = checkoutData;
  }

  getInvoice(){
    var invoiceData = this.invoice;
    this.invoice = {};
    return invoiceData;
  }

  addToCart(id: number, qty: number) {
    let existItem = this.getCookies("cartItem"+id);
    let json_str;
    if(existItem.length>0){
      existItem[0].qty += qty;
      json_str = JSON.stringify(existItem[0]);
      this.setCookie("cartItem"+id, json_str,2);
    }else{
      json_str = JSON.stringify({storyid: id, qty: qty});
      this.setCookie("cartItem"+id, json_str,2);
    }
  }

  getItems() {
    return this.getCookies();
  }

  getItemsCount(){
    var ca = document.cookie.split(';');
    var count = 0;
    for(let i=0;i < ca.length;i++) {
      let c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf("cartItem") == 0){
        count += 1;
      }
    }
    return count;
  }

  deleteItem(story: number){   
    this.removeCookie("cartItem"+story);
  }

  clearCart() {    
    let ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
      let c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf("cartItem") == 0){
        this.removeCookie(c.slice(0, c.search('=')));
      }
    }
  }

  setCookie(name, value, days) {
    var expires = "";
    if (days) {
      let now = new Date();
      let time = now.getTime();
      let expireTime = time + days*2400*36000;
      now.setTime(expireTime);
      expires = "; expires="+now.toUTCString();
    }
    document.cookie = name+"="+value+expires+"; path=/";
    this.getItemsCount();
  }
  
  getCookies(name:string = "cartItem") {
    var ca = document.cookie.split(';');
    var cookies = [];
    for(let i=0;i < ca.length;i++) {
      let c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(name) == 0){
        if(c.substring(c.search("=")+1,c.length) != ""){
          cookies.push(JSON.parse(c.substring(c.search("=")+1,c.length)));
        }       
      }
    }
    // console.log(cookies.length);
    return cookies.length>0 ? cookies:[];
  }
  
  removeCookie(name) {
    this.setCookie(name,"",-1);
  }
}
