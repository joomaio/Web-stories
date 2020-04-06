import { Component, OnInit } from "@angular/core";
import { Story } from "../../../story";
import { ConnectdbService } from "src/app/connectdb.service";
import { BackEndComponent } from "../../back-end.component";
import { PassDataService } from "../../pass-data.service";
import { ActivatedRoute } from "@angular/router";

@Component({
  selector: "app-story-search-result",
  templateUrl: "./story-search-result.component.html",
  styleUrls: ["./story-search-result.component.css"]
})
export class StorySearchResultComponent implements OnInit {
  storyForm: boolean;
  editStoryForm: boolean;
  story: Story;
  stories;

  keyWord: string;
  result;

  //Pagination
  pages = [];
  numberOfPages: number;
  currentPage: number;
  numberOfPaginationButton: number;
  constructor(
    private myservice: ConnectdbService,
    private backend: BackEndComponent,
    private subservice: PassDataService,
    private router: ActivatedRoute
  ) {
    this.stories = subservice.stories;
    this.result = subservice.result;
  }
  ngOnInit() {
    this.result = [];
    this.numberOfPaginationButton = 5;
    const n = this.numberOfPaginationButton;
    this.router.params.subscribe(params => {
      this.keyWord = params.keyword;
      this.currentPage = +params.page || 1;
      this.myservice
        .getStoryByNameInSearch(this.keyWord, +params.page)
        .subscribe(data => {
          this.result = Array.from(
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
          //
        });
    });
  }

  deleteStory(story: any) {
    this.myservice.deleteStory(story.id, story.cat_id).subscribe(
      response => {
        console.log(response);
        this.result.splice(this.result.indexOf(story), 1);
      },
      error => {
        console.log(error);
      }
    );
  }

  showEditStoryForm(story: Story) {
    this.backend.showEditStoryForm(story);
    this.backend.storyForm = false;
    this.story = story;
    this.subservice.story = this.story;
  }
}
