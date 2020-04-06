import { Component, OnInit } from '@angular/core';
import { ConnectdbService } from '../../connectdb.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Story } from 'src/app/story';
import { CartService } from '../../cart.service';

@Component({
  selector: 'app-story',
  templateUrl: './story-search.component.html',
  styleUrls: ['./story-search.component.css']
})
export class StorySearchComponent implements OnInit {
  searchText: string;
  filterCategory = '';
  filterDateFrom = '';
  filterDateTo = '';

  //pagination
  currentPage:number;
  numberOfPages=[];
  paramsOfPage={};
  pagination = [];

  //ket qua cua tu khoa
  keyResult = '';
  storiesResult: Array<any>;

  //bien luu data
  categories = [];

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private getdb: ConnectdbService,
    private cartService: CartService
  ) { }

  ngOnInit() {
    //this.keyResult = this.searchText = this.route.snapshot.params['s'];
    this.route.params.subscribe( params => {
      this.keyResult = this.searchText = params.s;
      this.currentPage = this.route.snapshot.queryParams['page'] || 1;
      this.getdb.getStoryByNameInSearch(this.searchText, this.currentPage).subscribe(data => {
        this.storiesResult = Array.from(Object.keys(data['result']), k => data['result'][k]);
        this.storiesResult.forEach(s => {
          //hien thi trich doan
          s.content = this.truncate(s.content);
          if(s['quantity']<1){
            s['isDisabled'] = true;
          }else{
            s['isDisabled'] = false;
          }
        })
        this.numberOfPages = Array.from(Array(data['info'].numberOfPages), (e, i) => i + 1);
        this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
      });
    });
    this.getdb.getCategories().subscribe(data => {
      this.categories = Array.from(Object.keys(data['result']), k => data['result'][k]);
    });
  }

  onSubmit(){
    let path = '';
    let params = '';
    let queryObj = {};
    if( +this.filterCategory > 0 ){
      queryObj['cat'] = this.filterCategory;
    }   
    if( this.filterDateFrom.length > 0 ){
      queryObj['from'] = this.filterDateFrom;
    }
    if( this.filterDateTo.length > 0 ){
      queryObj['to'] = this.filterDateTo;
    }
    this.router.navigate(['/search/'+this.searchText],{ queryParams: queryObj });
    
    params = Object.keys(queryObj).map(function(k) {
      return encodeURIComponent(k) + "=" + encodeURIComponent(queryObj[k]);
    }).join('&');
    params = !params ? '':'?'+params;
    path = this.searchText + params;
    
    this.keyResult = this.searchText;
    this.paramsOfPage = queryObj;

    this.getdb.getStoryByNameInSearch(path, 1).subscribe(data => {
      this.storiesResult = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.storiesResult.forEach((s: Story) => {
        //xoa space trong story
        s.content = this.truncate(s.content);
      });
      this.currentPage = 1;
      this.numberOfPages = Array.from(Array(data['info'].numberOfPages), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
    })
  }

  onClickPagination(page: number){
    let path = '';
    let params = '';
    let queryObj = {};
    if( +this.filterCategory > 0 ){
      queryObj['cat'] = this.filterCategory;
    }   
    if( this.filterDateFrom.length > 0 ){
      queryObj['from'] = this.filterDateFrom;
    }
    if( this.filterDateTo.length > 0 ){
      queryObj['to'] = this.filterDateTo;
    }

    params = Object.keys(queryObj).map(function(k) {
      return encodeURIComponent(k) + "=" + encodeURIComponent(queryObj[k]);
    }).join('&');
    params = !params ? '':'?'+params;
    path = this.searchText + params;    

    this.getdb.getStoryByNameInSearch(path, page).subscribe(data => {
      this.storiesResult = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.storiesResult.forEach((s: Story) => {
        //xoa space trong story
        s.content = this.truncate(s.content);
        let time = new Date(s.created_time);
        s.created_time = time.toLocaleDateString();
      });
      this.currentPage = page;
      this.numberOfPages = Array.from(Array(data['info'].numberOfPages), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
      if( page > 1 ){
        queryObj['page'] = page;
      }
      this.router.navigate(['/search/'+this.searchText],{ queryParams: queryObj });
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

  truncate(str, quantity:number = 10) {
    return str.split(" ").splice(0, quantity).join(" ");
  }

  addToCart(id:number, qty: number = 1 ){
    // let count = this.stories.filter((obj) => obj.storyid === id).length;
    // console.log(count);
    this.cartService.addToCart(id, qty);
    window.alert('Your story has been added to the cart!');
  }
}
