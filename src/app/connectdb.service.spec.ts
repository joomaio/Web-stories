import { TestBed } from '@angular/core/testing';

import { ConnectdbService } from './connectdb.service';

describe('ConnectdbService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ConnectdbService = TestBed.get(ConnectdbService);
    expect(service).toBeTruthy();
  });
});
