import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ConnectdbService } from '../../connectdb.service';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {
  //orders
  orders = [];

  //pagination
  numberOfPages = [];
  currentPage: number;
  pagination = [];

  //Filter
  filterDateFrom = '';
  filterDateTo = '';

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private getdb: ConnectdbService
  ) { }

  ngOnInit() {
    this.currentPage = this.route.snapshot.queryParams['page'] || 1;
    let fromDate = this.route.snapshot.queryParams['from'] || null;
    let toDate = this.route.snapshot.queryParams['to'] || null;
    this.getdb.getAllOrders(this.currentPage, fromDate, toDate).subscribe(data => {
      this.orders = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.orders.forEach(order => {
        let d = new Date(order['created_time']);
        order['created_time'] = d.toLocaleDateString() + " " + d.toLocaleTimeString();
      });
      this.numberOfPages = Array.from(Array(data['pages']), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
    });
  }

  onClickPagination(page: number) {
    let path = {};
    path['page'] = page;
    path['from'] = this.filterDateFrom != '' ? this.filterDateFrom : null;
    path['to'] = this.filterDateTo != '' ? this.filterDateTo : null;

    this.getdb.getAllOrders(page, path['from'], path['to']).subscribe(data => {
      this.orders = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.orders.forEach(order => {
        let d = new Date(order['created_time']);
        order['created_time'] = d.toLocaleDateString() + " " + d.toLocaleTimeString();
      });
      this.numberOfPages = Array.from(Array(data['pages']), (e, i) => i + 1);
      this.currentPage = page;
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
      this.router.navigate(['/admin/orders'], { queryParams: path });
    });
  }

  deleteOrder(id: number) {
    var r = confirm("Are you sure to delete this order?");
    if (r == true) {
      let page = this.route.snapshot.queryParams['page'];
      if (this.orders.length === 1 && page > 1) {
        page = page - 1;
      }
      this.getdb.deleteOrder(id).subscribe(a => {
        this.getdb.getAllOrders(page).subscribe(data => {
          this.orders = Array.from(Object.keys(data['result']), k => data['result'][k]);
          this.orders.forEach(order => {
            let d = new Date(order['created_time']);
            order['created_time'] = d.toLocaleDateString() + " " + d.toLocaleTimeString();
          });
          this.numberOfPages = Array.from(Array(data['pages']), (e, i) => i + 1);
          this.currentPage = page;
          this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
          this.router.navigate(['/admin/orders'], { queryParams: { page: page } });
        });
      });
    }
  }

  onFilterSubmit(formvalue) {
    let path = {};
    path['page'] = 1;
    path['from'] = this.filterDateFrom = formvalue['from_date'] != '' ? formvalue['from_date'] : null;
    path['to'] = this.filterDateTo = formvalue['to_date'] != '' ? formvalue['to_date'] : null;

    this.getdb.getAllOrders(1, path['from'], path['to']).subscribe(data => {
      this.orders = Array.from(Object.keys(data['result']), k => data['result'][k]);
      this.orders.forEach(order => {
        let d = new Date(order['created_time']);
        order['created_time'] = d.toLocaleDateString() + " " + d.toLocaleTimeString();
      });
      this.currentPage = 1;
      this.numberOfPages = Array.from(Array(data['pages']), (e, i) => i + 1);
      this.pagination = this.compactPagination(this.numberOfPages, this.currentPage);
      this.router.navigate(['/admin/orders'], { queryParams: path });
    });
  }

  compactPagination(numberOfPages, currentPage: number) {
    let compactPagination = [];
    numberOfPages.forEach(page => {
      if ((currentPage - page <= 2) && (currentPage - page >= -2) || page === 1 || page === numberOfPages.length) {
        if (page === 1 && currentPage >= 5) {
          compactPagination.push(page);
          compactPagination.push(-1);
        } else if (page === numberOfPages.length && currentPage <= numberOfPages.length - 4) {
          compactPagination.push(-1);
          compactPagination.push(page);
        } else {
          compactPagination.push(page);
        }
      }
    });
    return compactPagination;
  }

}
