import { Injectable, OnInit } from '@angular/core';
import { Story } from '../story';
import { HttpClient } from '@angular/common/http';

const baseUrl = 'http://localhost:3000';

@Injectable()
export class StoryService {
  

  constructor(private http: HttpClient){
  }

  getAllStories() {
    return this.http.get(`${baseUrl}/stories`);
  }

  getStory(id : number){
    return this.http.get(`${baseUrl}/story/${id}`);
  }

  addStory(story: Story) {
    return this.http.post(`${baseUrl}/stories`,story);
  }

  updateStory(story: Story) {
    return this.http.put(`${baseUrl}/story/${story.id}`,story);
  } 
  
  deleteStory(id : number){
    return this.http.delete(`${baseUrl}/story/${id}`);
  }

  findByName(title : string){
    return this.http.get(`${baseUrl}/stories/s/${title}`);
  }

}