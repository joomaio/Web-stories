import { ActivatedRoute } from "@angular/router";
import { ConnectdbService } from "src/app/connectdb.service";
import { Component, OnInit } from "@angular/core";
import { Category } from "src/app/category";
import { CategoryService } from "src/app/category.service";
import { BackEndComponent } from "../../back-end.component";
import { PassDataService } from "../../pass-data.service";
@Component({
  selector: "app-category-search-result",
  templateUrl: "./category-search-result.component.html",
  styleUrls: ["./category-search-result.component.css"]
})
export class CategorySearchResultComponent implements OnInit {
  API_KEY: string;
  categories = [];
  result: any = [];
  catForm: boolean;
  keyWord: string;
  editCatForm: boolean;
  category: Category;
  //Pagination
  pages = [];
  numberOfPages: number;
  currentPage: number;
  numberOfPaginationButton: number;

  constructor(
    private dbService: ConnectdbService,
    private route: ActivatedRoute,
    categoryService: CategoryService,
    private backend: BackEndComponent,
    private passData: PassDataService
  ) {
    this.categories = categoryService.categories;
  }
  ngOnInit() {
    this.result = [];
    this.route.params.subscribe(params => {
      this.keyWord = params.keyword;
      this.numberOfPaginationButton = 5;
      const n = this.numberOfPaginationButton;
      this.dbService
        .getCategoryByName(this.keyWord, +params.page)
        .subscribe(data => {
          this.result = Array.from(
            Object.keys(data["result"]),
            k => data["result"][k]
          );
          this.numberOfPages = +data["info"]["numberOfPages"];
          //Compact Pagination
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
  showAddCatForm() {
    this.backend.showAddCatForm();
    this.backend.editCatForm = false;
  }

  showEditCatForm(category: Category) {
    this.backend.showEditCatForm(category);
    this.backend.catForm = false;
    this.category = category;
    this.passData.category = this.category;
  }
}
