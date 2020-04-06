import { Component, OnInit } from '@angular/core';
import { ConnectdbService } from 'src/app/connectdb.service';
import { Story } from '../../story';
import { BackEndComponent } from '../back-end.component';
import { PassDataService } from '../pass-data.service';
import { Router, ActivatedRoute } from '@angular/router';
import { StoryService } from '../story.service';

@Component({
  selector: 'app-stories-form',
  templateUrl: './stories-form.component.html',
  styleUrls: ['./stories-form.component.css']
})
export class StoriesFormComponent implements OnInit {
  storyID: number;
  editStory: {};
  constructor(
    private myservice: ConnectdbService,
    private backend: BackEndComponent,
    private router: Router,
    private subservice: PassDataService,
    private storieservice : StoryService,
    private activatedRoute : ActivatedRoute
  ) { 
    if(backend.editStoryForm == true){
      
      this.editStory = { name: subservice.story.name, content: subservice.story.content };
    }
    
    
  }
  ngOnInit() {
    this.storyID = +this.activatedRoute.snapshot.params['id'];
  }


  getCheckAdd() {
    return this.backend.storyForm;
  }

  getCheckEdit() {

    return this.backend.editStoryForm;

  }

  onSubmitAdd(formData) {
    this.myservice.addStory(
      new Story( 
        'image',
        new Date().toLocaleDateString()+' '+ new Date().toLocaleTimeString(),
        1,
        new Date().toLocaleDateString()+' '+ new Date().toLocaleTimeString(),
        1,
        formData.name,
        formData.content,
        90,
        20,
        1,
        'cat')
    ).subscribe(
      response => {
        console.log(response);
      },
      error => {
        console.log(error);
      });
    this.router.navigate(["/admin/story"])
  }

  onSubmitEdit(formData) {
    this.myservice.updateStory(
      new Story( 
        this.subservice.story.feature_img,
        this.subservice.story.created_time,
        this.subservice.story.created_user,
        new Date().toLocaleDateString()+' '+ new Date().toLocaleTimeString(),
        2,
        formData.name,
        formData.content,
        this.subservice.story.price,
        this.subservice.story.quantity,
        this.subservice.story.cat_ID,
        this.subservice.story.catname),this.storyID
      ).subscribe(
      response => {
        console.log(response);
      },
      error => {
        console.log(error);
      });
      this.router.navigate(["/admin/story"])
  }

} 
