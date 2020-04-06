import { Component, OnInit } from "@angular/core";
import { Category } from "src/app/category";
import { BackEndComponent } from "../../back-end.component";
import { PassDataService } from "../../pass-data.service";
import { ConnectdbService } from "src/app/connectdb.service";
import { ActivatedRoute } from "@angular/router";
@Component({
  selector: "app-categories-list",
  templateUrl: "./categories-list.component.html",
  styleUrls: ["./categories-list.component.css"]
})
export class CategoriesListComponent implements OnInit {
  catForm: boolean;
  editCatForm: boolean;
  category: Category;
  categories = [];
  //Pagination
  pages = [];
  numberOfPages: number;
  currentPage: number;
  numberOfPaginationButton: number;
  
  constructor(
    private dbService: ConnectdbService,
    private backend: BackEndComponent,
    private passData: PassDataService,
    private route: ActivatedRoute
  ) {}
  ngOnInit() {
    this.numberOfPaginationButton = 5;
    const n = this.numberOfPaginationButton;
    this.route.params.subscribe(params => {
      this.currentPage = +params.page || 1;
      this.dbService
        .getCategoriesWithPagination(+params.page)
        .subscribe(data => {
          this.categories = Array.from(
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
  deleteCategory(category: Category) {
    this.dbService.deleteCategory(category).subscribe(() => {
      this.ngOnInit();
    });
  }
  showEditCatForm(category: Category) {
    this.backend.showEditCatForm(category);
    this.backend.catForm = false;
    this.category = category;
    this.passData.category = this.category;
  }
  run() {
    console.log("run");
  }
}
