import { Component, OnInit, DoCheck, AfterViewInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ConnectdbService } from '../../connectdb.service';
import { CartService } from '../../cart.service';
import { Story } from '../../story';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})

export class CategoryComponent implements OnInit {
  // public categories = [];
  public stories = [];
  // public newStories = [];
  category: any;
  id: number;
  //pagination
  currentPage: number;
  pages = [];
  numberOfPages: number;
  numberOfPaginationButton: number;
  // selected stories  
  orderStories = [];
  cartCount = 0;

  constructor(
    private dbService: ConnectdbService,
    private cartService: CartService,
    private route: ActivatedRoute,
    private router: Router
  ) { }
  ngOnInit() {
    this.numberOfPaginationButton = 5;
    const n = this.numberOfPaginationButton;
    this.route.params.subscribe(params => {
      this.id = params.cat_id;
      this.currentPage = this.route.snapshot.queryParams['page'] || 1;
      this.dbService.getStoriesByCatID(this.id, this.currentPage).subscribe(data => {
        //Get stories  
        this.stories = Array.from(Object.keys(data['result']), k => data['result'][k]);
        this.stories.forEach((b) => {
          this.category = b.catname;
          if (b['quantity'] < 1) {
            b['isDisabled'] = true;
          } else {
            b['isDisabled'] = false;
          }
          let time = new Date(b.created_time);
          b.created_time = time.toLocaleDateString();
        });
        //Compact Pagination
        this.numberOfPages = +data['info']['numberOfPages'];
        let temp_arr = [];
        if (this.numberOfPages <= this.numberOfPaginationButton) {
          temp_arr = Array.from(Array(this.numberOfPages), (_e, i) => i + 1)
        }
        else
          if (this.currentPage <= n - 1) {
            temp_arr = Array.from(Array(n), (e, i) => i + 1);
          }
          else if (this.currentPage > this.numberOfPages - n + 1) {
            temp_arr = Array.from(Array(this.numberOfPages), (e, i) => {
              if (i >= this.numberOfPages - n)
                return i + 1
            }).filter(Boolean);
          }
          else
            for (var i = this.currentPage - Math.floor(n / 2); i <= this.currentPage + Math.floor(n / 2); i++) { temp_arr.push(i); }
        this.pages = temp_arr;
      });
    });
  }
  onClickPagination(page: number) {
    const n = this.numberOfPaginationButton;
    this.dbService.getStoriesByCatID(this.id, page).subscribe(data => {
      this.stories = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.stories.forEach((b) => {
        if (b['quantity'] < 1) {
          b['isDisabled'] = true;
        } else {
          b['isDisabled'] = false;
        }
        let time = new Date(b.created_time);
        b.created_time = time.toLocaleDateString();
      });
      this.currentPage = page;
      //Compact Pagination
      this.numberOfPages = +data['info']['numberOfPages'];
      let temp_arr = [];
      if (this.numberOfPages <= this.numberOfPaginationButton) {
        temp_arr = Array.from(Array(this.numberOfPages), (_e, i) => i + 1)
      }
      else
        if (this.currentPage <= n - 1) {
          temp_arr = Array.from(Array(n), (e, i) => i + 1);
        }
        else if (this.currentPage > this.numberOfPages - n + 1) {
          temp_arr = Array.from(Array(this.numberOfPages), (e, i) => {
            if (i >= this.numberOfPages - n)
              return i + 1
          }).filter(Boolean);
        }
        else
          for (var i = this.currentPage - Math.floor(n / 2); i <= this.currentPage + Math.floor(n / 2); i++) { temp_arr.push(i); }
      this.pages = temp_arr;
      this.router.navigate(['/cat/' + this.id], { queryParams: { page: page } });
    });
  }
  truncate(str, quantity: number = 10) {
    return str.split(" ").splice(0, quantity).join(" ");
  }

  addToCart(id: number, qty: number = 1) {
    this.cartService.addToCart(id, qty);
    window.alert('Your story has been added to the cart!');
  }
}
