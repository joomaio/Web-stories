import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { BackEndComponent } from '../back-end.component';
@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {
  searchKey = '';
  constructor(private router: Router, private backend: BackEndComponent) {
  }
  ngOnInit() {
    this.router.navigate(['admin/cat/page', 1]);
  }
  showAddCatForm() {
    this.backend.showAddCatForm();
    this.backend.editCatForm = false;
  }

}
