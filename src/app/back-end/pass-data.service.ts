
import { Injectable, OnInit } from '@angular/core';
import { Story } from '../story';
import { Category } from '../category';

@Injectable()

export class PassDataService implements OnInit {
    constructor(

    ) { }
    temp_stories : Story[];
    temp_story: Story;
    temp_category: Category;
    temp_result;
    ngOnInit() {
    }

    set result(stories : any){
        this.temp_result = stories;
    }

    get result(){
        return this.temp_result;
    }

    set stories(stories :Story[]){
        this.temp_stories = stories;
    }

    get stories(){
        return this.temp_stories;
    }

    set story(story : Story) {
        this.temp_story = story;
    }

    get story() {
        return this.temp_story;
    }

    set category(category: Category) {
        this.temp_category = category;
    }

    get category() {
        return this.temp_category;
    }

}