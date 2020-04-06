import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Category } from './category';
@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  private _categories = [];
  constructor(private http: HttpClient) {
  }
  get categories() {
    return this._categories;
  }
  set categories(categories: Category[]) {
    this._categories = categories;
  }
  getData(): Promise<any[]> {
    return new Promise<any[]>(resolve => {
      this.http.get('assets/categories.json').subscribe(data => {
        this._categories = Array.from(Object.keys(data), k => data[k]);
        resolve();
      });
    });
  }
  addItem(category: Category): void {
    this._categories.push(category);
  }
  deleteItem(category: Category): void {
    this._categories.forEach((item, index) => {
      if (item === category) this._categories.splice(index, 1);
    });
  }
  updateItem(category: Category): void {
    this._categories.forEach(item => {
      if (item.id === category.id) item = category;
    });
  }
}
