import { Injectable } from "@angular/core";
import { HttpClient, HttpHeaders } from "@angular/common/http";
import { Category } from "./category";
import { Story } from "./story";
import { Order } from "./order";
import { of } from "rxjs";
@Injectable({
  providedIn: "root"
})
export class ConnectdbService {
  private apiUrl = "http://localhost:3000";

  httpOptions = {
    headers: new HttpHeaders({ "Content-Type": "application/json" })
  };

  constructor(private http: HttpClient) {}

  getData(path: string) {
    const url = this.apiUrl + path;
    return this.http.get(url);
  }

  /** GET Categories from the server */
  getCategories() {
    const url = `${this.apiUrl}/categories`;
    return this.http.get(url);
  }
  getCategoriesWithPagination(page: number) {
    const limit = 10;
    const url = `${this.apiUrl}/categories?limit=${limit}&page=${page}`;
    return this.http.get(url);
  }
  /** GET category by id */
  getCategory(id: number) {
    const url = `${this.apiUrl}/category/${id}`;
    return this.http.get(url);
  }

  /** GET category by name and pagination | Search category */
  getCategoryByName(term: string, page: number) {
    const limit = 10;
    if (!term.trim()) {
      // if not search term, return empty hero array.
      return of([]);
    }
    return this.http.get(
      `${this.apiUrl}/categories/search/${term}?limit=${limit}&page=${page}`
    );
  }

  /** POST: add a new category to the server */
  addCategory(cat: Category) {
    return this.http.post(this.apiUrl + "/categories", cat, this.httpOptions);
  }

  /** DELETE: delete the category from the server */
  deleteCategory(cat: Category | number) {
    const id = typeof cat === "number" ? cat : cat.id;
    const url = `${this.apiUrl}/category/${id}`;

    return this.http.delete(url, this.httpOptions);
  }

  /** PUT: update the category on the server */
  updateCategory(cat: Category, catID: number) {
    const url = `${this.apiUrl}/category/${catID}`;
    return this.http.put(url, cat, this.httpOptions);
  }
  /**Pagination Stories */
  getStoriesWithPagination(page: number, limit: number = 8) {
    const url = `${this.apiUrl}/stories?limit=${limit}&page=${page}`;
    return this.http.get(url);
  }
  /**Get Stories by cat ID*/
  getStoriesByCatID(catID: number, page: number, limit: number = 6) {
    const url = `${this.apiUrl}/stories/${catID}?limit=${limit}&page=${page}`;
    return this.http.get(url);
  }
  /** GET Stories from the server */
  getStories() {
    const url = `${this.apiUrl}/stories?limit=0`;
    return this.http.get(url);
  }

  /** GET Story by id */
  getStory(id: number) {
    const url = `${this.apiUrl}/story/${id}`;
    return this.http.get(url);
  }

  /** GET Story by name | Search category */
  getStoryByNameInSearch(term: string, page: number) {
    const limit = 6;
    if (!term.trim()) {
      // if not search term, return empty hero array.
      return of([]);
    }
    if (term.indexOf("?") != -1)
      return this.http.get(
        `${this.apiUrl}/stories/search/${term}&limit=${limit}&page=${page}`
      );
    else
      return this.http.get(
        `${this.apiUrl}/stories/search/${term}?limit=${limit}&page=${page}`
      );
  }

  /** POST: add a new story to the server */
  addStory(story: Story) {
    return this.http.post(this.apiUrl + "/stories", story, this.httpOptions);
  }

  /** DELETE: delete the Story from the server */
  deleteStory(story: Story | number, cat_id: number) {
    const id = typeof story === "number" ? story : story.id;
    const url = `${this.apiUrl}/story/${id}?cat_id=${cat_id}`;
    return this.http.delete(url, this.httpOptions);
  }

  /** PUT: update the story on the server */
  updateStory(cat: Story, storyID: number) {
    const url = `${this.apiUrl}/story/${storyID}`;
    return this.http.put(url, cat, this.httpOptions);
  }
  
  /** GET: get accounts from server */
  getAcc() {
    const url = `${this.apiUrl}/accounts`;

    return this.http.get(url, this.httpOptions);
  }

  /** POST: add a new order to the server */
  addOrder(order) {
    return this.http.post(this.apiUrl + "/order", order, this.httpOptions);
  }

  getAllOrders(page: number = 1, from = null, to = null, limit: number = 10) {
    let dateFrom = from != null ? "&from=" + from : "";
    let dateTo = to != null ? "&to=" + to : "";
    let limitStory = limit != 10 ? "&limit=" + limit : "";
    return this.http.get(
      this.apiUrl + `/orders?page=${page}${dateFrom}${dateTo}${limitStory}`,
      this.httpOptions
    );
  }

  deleteOrder(id: number) {
    let url = this.apiUrl + `/order/${id}`;
    return this.http.delete(url, this.httpOptions);
  }

  /** GET Order by id */
  getOrder(id: number) {
    const url = `${this.apiUrl}/order/${id}`;
    return this.http.get(url);
  }

  /** PUT: update the order on the server */
  updateOrder(order) {
    return this.http.put(`${this.apiUrl}/order/${order['orderID']}`, order, this.httpOptions);
  }
}
