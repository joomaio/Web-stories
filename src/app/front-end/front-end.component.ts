import { Component, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { CategoryService } from 'src/app/category.service';
import { StoriesService } from '../stories.service';
import { ConnectdbService } from '../connectdb.service';
import { CartService } from '../cart.service';
import { CategoryComponent } from './category/category.component';
import { ShopComponent } from './shop/shop.component';
import { CartComponent } from './cart/cart.component';
import { HomeComponent } from './home/home.component';
import { StoryDetailComponent } from './story-detail/story-detail.component';
import { InvoiceComponent } from './invoice/invoice.component';
import { AuthService } from './../auth.service';


@Component({
  selector: 'app-front-end',
  templateUrl: './front-end.component.html',
  styleUrls: ['./front-end.component.css']
})
export class FrontEndComponent implements OnInit {
  @ViewChild(CategoryComponent, {static: false}) child;

  public categories = [];
  public stories = [];
  searchkey = '';
  
  error:boolean;
  submitted:boolean ;

  //check shop page activate
  isShop = false;
  
  //check home page activate
  isHome = false;

  public login;
  public currentUser;

  constructor(
    private authService: AuthService,
    private activatedRoute:ActivatedRoute,
    private dbService: ConnectdbService,
    storyService: StoriesService,
    private fb: FormBuilder,
    private router: Router,
    private categoryService: CategoryService,
    private cartService: CartService
  ) {
    this.stories = storyService.stories;
    this.currentUser=this.authService.userName;
  }
  ngOnInit() {
    this.dbService.getCategories().subscribe(data => {
      this.categories = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.categoryService.categories = this.categories;
    }); 
    this.dbService.getAcc().subscribe((data) => {
      this.login = data;  
    });

  }
  loginForm = this.fb.group({
    username: ['', [Validators.required, Validators.minLength(4), Validators.maxLength(15)]],
    password: ['', [Validators.required, Validators.minLength(4), Validators.maxLength(15)]]
  })

  get f() { return this.loginForm.controls; }

  onSubmit() {
    this.submitted=true;
    if(this.checkValid()){
      this.authService.login(this.loginForm.value.username, this.loginForm.value.password);
      this.router.navigateByUrl('/admin/story/page/1');
    } else {
      this.error=true;
    }  
  };

  getUser() {
    return this.loginForm.value.username;
  }

  getPassword() {
    return this.loginForm.value.password;
  }
  
  checkValid() {
    for (let i = 0; i < this.login.length; i++) {
      if (this.login[i].username === this.getUser() && this.login[i].password === this.getPassword()) {
        return true;
      }
    };
    return false;
  }

  cartCount(){
    return this.cartService.getItemsCount();
  }
  
  onSearchSubmit(s){
    this.router.navigate(['/search/'+s]);
  }

  onActivate(componentRef){
    if(componentRef instanceof ShopComponent || componentRef instanceof CartComponent 
      || componentRef instanceof StoryDetailComponent || componentRef instanceof InvoiceComponent){
      this.isShop = true;
      this.isHome = false;
    }else if(componentRef instanceof HomeComponent){
      this.isShop = false;
      this.isHome = true;
    }else{
      this.isShop = false;
      this.isHome = false;
    }
  }
}
