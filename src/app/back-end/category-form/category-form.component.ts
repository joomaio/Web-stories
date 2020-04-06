import { Component, OnInit } from '@angular/core';
import { CategoryService } from 'src/app/category.service';
import { Category } from 'src/app/category';
import { BackEndComponent } from '../back-end.component';
import { Router, ActivatedRoute } from '@angular/router';
import { PassDataService } from '../pass-data.service';
import { ConnectdbService } from 'src/app/connectdb.service';
@Component({
  selector: 'app-category-form',
  templateUrl: './category-form.component.html',
  styleUrls: ['./category-form.component.css']
})
export class CategoryFormComponent implements OnInit {
  categories = [];
  catID: number;
  newCat: Category;
  editCategory: {}
  constructor(catService: CategoryService, private router: Router, private backend: BackEndComponent,
    passData: PassDataService, private dbService: ConnectdbService, private activatedRoute: ActivatedRoute) {
    this.categories = catService.categories;
    this.editCategory = { name: passData.category.name, description: passData.category.description };
  }

  ngOnInit() {
    this.catID = +this.activatedRoute.snapshot.params['id'];
  }

  getCheckAdd() {
    return this.backend.catForm;
  }

  getCheckEdit() {
    return this.backend.editCatForm;  
  }

  onClickSubmitAdd(formData: { name: string; content: string; }) {
    this.dbService.addCategory(new Category(formData.name, formData.content)).subscribe(() => {
      this.router.navigateByUrl('/admin/cat/page/1');
    });
  }
  onClickSubmitEdit(formData: { name: string; description: string; }) {
    this.newCat = new Category(formData.name, formData.description);
    this.dbService.updateCategory(new Category(formData.name, formData.description), this.catID).subscribe(() => {
      this.router.navigateByUrl('/admin/cat/page/1');
    });
  }

}
