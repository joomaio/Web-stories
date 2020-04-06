import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ConnectdbService } from 'src/app/connectdb.service';
import { CartService } from 'src/app/cart.service';

@Component({
  selector: 'app-story-detail',
  templateUrl: './story-detail.component.html',
  styleUrls: ['./story-detail.component.css']
})
export class StoryDetailComponent implements OnInit {
  public categories = [];
  public stories = [];
  category: string;
  story: any;
  id: number;
  selectedQty = 1;
  isDisabled = false;
  constructor(
    private dbService: ConnectdbService, 
    private route: ActivatedRoute,
    private cartService: CartService
  ) { }
  ngOnInit() {
    this.route.params.subscribe(params => {
      this.dbService.getStory(+params['id']).subscribe(data => {
        this.story = data;
        if(data['quantity']<1){
          this.isDisabled = true;
        }
      });
    })
  }
  addToCart(id:number, qty: number = 1 ){
    console.log(id);
    console.log(qty);
    this.cartService.addToCart(id, qty);
    window.alert('Your story has been added to the cart!');
  }
}
