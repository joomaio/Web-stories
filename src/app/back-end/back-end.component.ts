import { Component, OnInit } from '@angular/core';
import { ConnectdbService } from 'src/app/connectdb.service';
import { Story } from '../story';
import { CategoryService } from '../category.service';
import { Category } from '../category';
import { PassDataService } from './pass-data.service';
import { AuthService } from './../auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-back-end',
  templateUrl: './back-end.component.html',
  styleUrls: ['./back-end.component.css']
})
export class BackEndComponent implements OnInit {
  stories : Story[];
  categories: Category[];
  storyForm: boolean = false;
  catForm: boolean = false;
  editStoryForm: boolean = false;
  editCatForm: boolean = false;
  isNewStory: boolean;
  isNewCat: boolean;
  newStory: any = {};
  newCat: any = {};
  editedStory: any = {};
  editedCat: any = {};

  constructor(
    private authService:AuthService, 
    private router:Router,
    private myservice: ConnectdbService,
    private catService: CategoryService,
    private subservice : PassDataService
    ) {
    this.stories = subservice.stories;
  }
  ngOnInit() {
    
  }

  logout() {
    this.authService.logoutUser();
    this.router.navigate(['']);
  }
  showAddStoryForm() {
    this.storyForm = true;
  }

  showAddCatForm() {
    /*
    if (this.categories.length) {
      this.newCat = {};
    }
    */
    this.catForm = true;
    this.isNewCat = true;
  }

  showEditStoryForm(story: Story) {
    if (!story) {
      this.storyForm = false;
      return;
    }
    this.editStoryForm = true;
  }

  showEditCatForm(category: Category) {
    if (!category) {
      this.catForm = false;
      return;
    }
    this.editCatForm = true;
  }
  
  saveCat(category: Category) {
    if (this.isNewCat) {
      this.catService.addItem(category);
    }
    this.catForm = false;
  }

  updateCat(story: Story) {
    this.catService.updateItem(this.editedCat)
    this.editCatForm = false;
    this.editedCat = {};
  }
}
