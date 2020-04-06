import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { HomeComponent } from './front-end/home/home.component';
import { StoryComponent } from './front-end/story/story.component';
import { CategoryComponent } from './front-end/category/category.component';
import { FrontEndComponent } from './front-end/front-end.component';
import { StorySearchComponent } from './front-end/story-search/story-search.component';
import { BackEndComponent } from './back-end/back-end.component';
import { StoriesComponent } from './back-end/stories/stories.component';
import { StoriesFormComponent } from './back-end/stories-form/stories-form.component';
import { CategoriesComponent } from './back-end/categories/categories.component';
import { CategoryFormComponent } from './back-end/category-form/category-form.component';
import { CategorySearchResultComponent } from './back-end/categories/category-search-result/category-search-result.component';
import { CategoriesListComponent } from './back-end/categories/categories-list/categories-list.component';
import { StoriesListComponent } from './back-end/stories/stories-list/stories-list.component';
import { StorySearchResultComponent } from './back-end/stories/story-search-result/story-search-result.component';
import { OrdersComponent } from './back-end/orders/orders.component';
import { OrderFormComponent } from './back-end/order-form/order-form.component';
import { CartComponent } from './front-end/cart/cart.component';
import { ShopComponent } from './front-end/shop/shop.component';
import { StoryDetailComponent } from './front-end/story-detail/story-detail.component';
import { InvoiceComponent } from './front-end/invoice/invoice.component';
import { AuthGuardService } from './auth-guard.service';

const routes: Routes = [
  {
    path: '', component: FrontEndComponent,
    children: [
      { path: '', component: HomeComponent, },
      { path: 'story/:str_id', component: StoryComponent },
      { path: 'cat/:cat_id', component: CategoryComponent },
      { path: 'search/:s', component: StorySearchComponent },
      { path: 'cart', component: CartComponent },
      { path: 'shop', component: ShopComponent },
      { path: 'story-detail/:id', component: StoryDetailComponent },
      { path: 'invoice', component: InvoiceComponent }
    ]
  },
  {
    path: 'admin', component: BackEndComponent,canActivate : [AuthGuardService],
    children: [
      { path: 'story', component: StoriesComponent, children:
        [
          { path: '', component: StoriesListComponent },
          { path: 'page/:page', component: StoriesListComponent },
          { path: 'search/:keyword/:page', component: StorySearchResultComponent }
        ]
      },
      { path: 'story/0', component: StoriesFormComponent },
      { path: 'story/:id', component: StoriesFormComponent },
      { path: 'cat/id', component: CategoryFormComponent },
      { path: 'cat/:id', component: CategoryFormComponent },
      {
        path: 'cat', component: CategoriesComponent, children: [
          { path: '', component: CategoriesListComponent },
          { path: 'page/:page', component: CategoriesListComponent },
          { path: 'search/:keyword/:page', component: CategorySearchResultComponent },
        ]
      },
      { path: 'orders', component: OrdersComponent },
      { path: 'order/:id', component: OrderFormComponent }
    ]
  },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
