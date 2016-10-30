import { Component } from '@angular/core';

@Component({
  selector: 'FeedMe',
  template: './FeedMe/FeedMe.html',
  styleUrls: ['./FeedMe/FeedMe.css'],
})

export class AppComponent {
  title: string;

  constructor() {
    this.title = "Hello World";
  }
}