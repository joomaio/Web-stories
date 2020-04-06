import { Component, OnInit } from "@angular/core";
import { Story } from "../../../story";
import { ConnectdbService } from "src/app/connectdb.service";
import { BackEndComponent } from "../../back-end.component";
import { Category } from "src/app/category";
import { PassDataService } from "../../pass-data.service";
import { Router, ActivatedRoute } from "@angular/router";
import { HttpClient } from "@angular/common/http";

@Component({
  selector: "app-stories-list",
  templateUrl: "./stories-list.component.html",
  styleUrls: ["./stories-list.component.css"]
})
export class StoriesListComponent implements OnInit {
  storyForm: boolean;
  editStoryForm: boolean;
  story;
  pager = {};
  public stories;
  //Pagination
  pages = [];
  numberOfPages: number;
  currentPage: number;
  numberOfPaginationButton: number;

  constructor(
    private myservice: ConnectdbService,
    private backend: BackEndComponent,
    private subservice: PassDataService,
    private route: ActivatedRoute
  ) {}
  ngOnInit() {
    this.numberOfPaginationButton = 5;
    const n = this.numberOfPaginationButton;
    this.route.params.subscribe(params => {
      this.currentPage = +params.page || 1;
      this.myservice.getStoriesWithPagination(+params.page).subscribe(data => {
        this.stories = Array.from(
          Object.keys(data["result"]),
          k => data["result"][k]
        );
        //Compact pagination
        this.numberOfPages = +data["info"]["numberOfPages"];
        let temp_arr = [];
        if (this.numberOfPages <= n) {
          temp_arr = Array.from(Array(this.numberOfPages), (_e, i) => i + 1);
        } else if (this.currentPage <= n - 1) {
          temp_arr = Array.from(Array(n), (_e, i) => i + 1);
        } else if (this.currentPage > this.numberOfPages - n + 1) {
          temp_arr = Array.from(Array(this.numberOfPages), (_e, i) => {
            if (i >= this.numberOfPages - n) return i + 1;
          }).filter(Boolean);
        } else
          for (
            let i = this.currentPage - Math.floor(n / 2);
            i <= this.currentPage + Math.floor(n / 2);
            i++
          ) {
            if (n % 2 === 0 && i === this.currentPage - Math.floor(n / 2))
              continue;
            else temp_arr.push(i);
          }
        if (temp_arr[temp_arr.length - 1] !== this.numberOfPages) {
          temp_arr.push(-1);
          temp_arr.push(this.numberOfPages);
        }
        this.pages = temp_arr;
        console.log(this.stories);
        //
      });
    });
  }

  deleteStory(story: any) {
    this.myservice
      .deleteStory(story.id, story.cat_id)
      .subscribe(this.stories.splice(this.stories.indexOf(story), 1));
    this.ngOnInit();
  }

  showEditStoryForm(story: Story) {
    this.backend.showEditStoryForm(story);
    this.backend.storyForm = false;
    this.subservice.story = story;
  }
}
