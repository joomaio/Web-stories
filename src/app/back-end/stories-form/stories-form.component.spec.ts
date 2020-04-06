import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StoriesFormComponent } from './stories-form.component';

describe('StoriesFormComponent', () => {
  let component: StoriesFormComponent;
  let fixture: ComponentFixture<StoriesFormComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StoriesFormComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StoriesFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
