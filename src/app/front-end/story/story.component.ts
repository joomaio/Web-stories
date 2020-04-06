import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ConnectdbService } from 'src/app/connectdb.service';
import { Category } from 'src/app/category';
import { Story } from 'src/app/story';
import { StoriesService } from 'src/app/stories.service';
import { CategoryService } from 'src/app/category.service';
import { CartService } from 'src/app/cart.service';

@Component({
  selector: 'app-story',
  templateUrl: './story.component.html',
  styleUrls: ['./story.component.css']
})
export class StoryComponent implements OnInit {
  public categories = [];
  public stories = [];
  category: string;
  story: any;
  id: number;
  constructor(private dbService: ConnectdbService, private route: ActivatedRoute) {
  }
  ngOnInit() {
    this.route.params.subscribe(params => {
      this.dbService.getStory(+params['str_id']).subscribe(data => {
        this.story = data;
        console.log(this.story);
      });
    })
  }
}
