import { Component, OnInit } from "@angular/core";
import { Router } from "@angular/router";
import { BackEndComponent } from "../back-end.component";

@Component({
  selector: "app-stories",
  templateUrl: "./stories.component.html",
  styleUrls: ["./stories.component.css"]
})
export class StoriesComponent implements OnInit {
  result;
  searchKey;
  constructor(
    private router: Router,
    private backend: BackEndComponent,
  ) {}
  ngOnInit() {
    this.router.navigate(["admin/story/page", 1]);
  }

  showAddStoryForm() {
    this.backend.showAddStoryForm();
    this.backend.editStoryForm = false;
  }
}
