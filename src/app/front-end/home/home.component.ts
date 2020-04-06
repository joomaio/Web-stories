import { Component, OnInit } from '@angular/core';
import { Story } from 'src/app/story';
import { Category } from 'src/app/category';
import { ConnectdbService } from 'src/app/connectdb.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  categories = [];
  stories = [];
  constructor( private dbService: ConnectdbService) {}
  ngOnInit() {
    this.dbService.getCategories().subscribe(data => {
      this.categories = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.categories.forEach((cat: Category) => {
        this.dbService.getStoriesByCatID(cat.id,1,3).subscribe(stories => {
          this.stories[cat.id] = Array.from(Object.keys(stories['result']), k => stories['result'][k]);
          this.stories[cat.id].forEach((story: Story) => {
            let time = new Date(story.created_time);
            story.created_time = time.toLocaleDateString();
          });
        });
      });
    });
  }
  getPreviewContent(story: Story): string {
    return story.content.replace(/\s+|\\r|\\n/g, " ").split(" ").splice(0, 20).join(" ") + '...';
  }
}
