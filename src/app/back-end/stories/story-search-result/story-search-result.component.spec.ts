import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StorySearchResultComponent } from './story-search-result.component';

describe('StorySearchResultComponent', () => {
  let component: StorySearchResultComponent;
  let fixture: ComponentFixture<StorySearchResultComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StorySearchResultComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StorySearchResultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
