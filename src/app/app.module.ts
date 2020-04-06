import { BrowserModule } from '@angular/platform-browser';
import { NgModule, APP_INITIALIZER } from '@angular/core';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './front-end/home/home.component';
import { HttpClientModule } from '@angular/common/http';
import { StoriesFilterPipe } from './front-end/home/stories-filter.pipe';
import { StoryComponent } from './front-end/story/story.component';
import { CategoryComponent } from './front-end/category/category.component';
import { FrontEndComponent } from './front-end/front-end.component';
import { StorySearchComponent } from './front-end/story-search/story-search.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BackEndComponent } from './back-end/back-end.component';
import { StoriesFormComponent } from './back-end/stories-form/stories-form.component';
import { StoriesComponent } from './back-end/stories/stories.component';
import { JwPaginationComponent } from 'jw-angular-pagination';
import { CategoriesComponent } from './back-end/categories/categories.component';
import { CategoryFormComponent } from './back-end/category-form/category-form.component';
import { CategorySearchResultComponent } from './back-end/categories/category-search-result/category-search-result.component';
import { CategoriesListComponent } from './back-end/categories/categories-list/categories-list.component';
import { StoryService } from './back-end/story.service';
import { PassDataService } from './back-end/pass-data.service';
import { CategoryService } from './category.service';
import { StoriesService } from './stories.service';
import { StoriesListComponent } from 'src/app/back-end/stories/stories-list/stories-list.component';
import { StorySearchResultComponent } from 'src/app/back-end/stories/story-search-result/story-search-result.component';
import { CartComponent } from './front-end/cart/cart.component';
import { CartService } from './cart.service';
import { OrdersComponent } from './back-end/orders/orders.component';
import { OrderFormComponent } from './back-end/order-form/order-form.component';
import { ShopComponent } from './front-end/shop/shop.component';
import { StoryDetailComponent } from './front-end/story-detail/story-detail.component';
import { InvoiceComponent } from './front-end/invoice/invoice.component';
import { LoginComponent } from './login/login.component';
import { AuthService } from './auth.service';
import { AuthGuardService } from './auth-guard.service';
import { NgxStripeModule } from 'ngx-stripe';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    StoriesFilterPipe,
    StoryComponent,
    CategoryComponent,
    FrontEndComponent,
    StorySearchComponent,
    BackEndComponent,
    StoriesFormComponent,
    StoriesComponent,
    JwPaginationComponent,
    CategoriesComponent,
    CategoryFormComponent,
    CategorySearchResultComponent,
    CategoriesListComponent,
    StoriesListComponent,
    StorySearchResultComponent,
    CartComponent,
    OrdersComponent,
    OrderFormComponent,
    ShopComponent,
    StoryDetailComponent,
    InvoiceComponent,
    LoginComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    AppRoutingModule,
    HttpClientModule,
    NgxStripeModule.forRoot('pk_test_hFGPrgC6XfM170h987NT2V3000sqsRXyqt'),
  ],
  providers: [
    StoryService,
    PassDataService,
    StoriesComponent,
    BackEndComponent,
    CategoryService,
    CartService,
    AuthService,
    AuthGuardService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
