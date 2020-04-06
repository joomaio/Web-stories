import { Component, OnInit } from '@angular/core';
import { CartService } from '../../cart.service';
import { ConnectdbService } from 'src/app/connectdb.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-shop',
  templateUrl: './shop.component.html',
  styleUrls: ['./shop.component.css']
})
export class ShopComponent implements OnInit {
  stories = [];
  numberOfPages = [];
  currentPage: number;
  pagination = [];

  constructor( 
    private getdb: ConnectdbService,
    private cartService: CartService,
    private route: ActivatedRoute,
    private router: Router
  ) {}
  ngOnInit() {
    this.currentPage = this.route.snapshot.queryParams['page'] || 1;
    this.getdb.getStoriesWithPagination(this.currentPage,6).subscribe(data => {
      this.stories = Array.from(Object.keys(data['result']), k => data['result'][k]);    
      this.numberOfPages = Array.from(Array(data['info'].numberOfPages), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);    
    });
  }
  truncate(str, quantity:number = 10) {
    return str.split(" ").splice(0, quantity).join(" ");
  }
  addToCart(id:number, qty: number = 1 ){    
    this.cartService.addToCart(id, qty);
    window.alert('Your story has been added to the cart!');
  }  
  onClickPagination(page: number){
    this.getdb.getStoriesWithPagination(page, 6).subscribe(data => {
      this.stories = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.stories.forEach(s => {
        //xoa space trong story
        s.content = this.truncate(s.content);
        let time = new Date(s.created_time);
        s.created_time = time.toLocaleDateString();
      });
      this.currentPage = page;
      this.numberOfPages = Array.from(Array(data['info'].numberOfPages), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
      
      this.router.navigate(['/shop'],{ queryParams: {page: page} });
    });
  }
  compactPagination(numberOfPages, currentPage:number){
    let compactPagination = [];
    numberOfPages.forEach(page =>{
      if((currentPage - page <= 2) && (currentPage - page >= -2) || page === 1 || page === numberOfPages.length){   
        if(page === 1 && currentPage >=5){               
          compactPagination.push(page);
          compactPagination.push(-1);
        }else if(page === numberOfPages.length && currentPage <= numberOfPages.length - 4){
          compactPagination.push(-1);     
          compactPagination.push(page);
        }else{          
          compactPagination.push(page);
        }
      }
    });
    return compactPagination;
  }
}
