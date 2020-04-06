import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'storiesFilter'
})
export class StoriesFilterPipe implements PipeTransform {

  transform(list: any[], key: string, value: string): any {
    return list.filter(i => i[key] == value);
  }

}
