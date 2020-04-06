import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Story } from './story';
@Injectable({
  providedIn: 'root'
})
export class StoriesService {
  private _stories = [];
  constructor(private http: HttpClient) {
  }
  get stories() {
    return this._stories;
  }
  getData(): Promise<any[]> {
    return new Promise<any[]>(resolve => {
      this.http.get('assets/stories.json').subscribe(data => {
        this._stories = Array.from(Object.keys(data), k => data[k]);
        resolve();
      });
    });
  }
  addItem(story: Story): void {
    this._stories.push(story);
  }
  deleteItem(story: Story): void {
    this._stories.forEach((item, index) => {
      if (item === story) this._stories.splice(index, 1);
    });
  }
}

