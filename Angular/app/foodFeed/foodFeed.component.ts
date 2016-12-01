import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { FoodFeedGetService } from './../services/foodFeed.get.service';

@Component({
  selector: 'feed',
  templateUrl: './app/foodFeed/foodFeed.html',
  styleUrls: ['./app/foodFeed/foodFeed.css']

})

export class FoodFeedComponent {

  _returnId: number;

  restaurant: {
    id: number;
    name: string;
    bio: string;
    address: string;
    phoneNumber: string;
    email: string;
    openTime: string;
    closeTime: string;
    picPath: string;
    menu: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: FoodFeedGetService) {
    this.restaurant = {
      id: 1,
      name: 'string',
      bio: 'string',
      address: 'string',
      phoneNumber: 'string',
      email: 'sting',
      openTime: 'string',
      closeTime: 'string',
      picPath: 'string',
      menu: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['userId']));
  }

  private load(id) {
    this.restaurant = {
      id: 1,
      name: "Russell Hallmark's Fruit Emporium",
      bio: "BOOM we actually sell other things",
      address: "2222 WooHoo Lane",
      phoneNumber: "555-555-5464",
      email: "jjfu@bde.net",
      openTime: "08:00:00",
      closeTime: "18:00:00",
      picPath: "",
      menu: [
        {
          id: 1,
          name: "Taco Platter",
          picPath: "../images/taco-platter.jpg",
          description: "Great platter of tacos",
          type: "Mexican",
          time: "Breakfast"
        },
        {
          id: 2,
          name: "Taco",
          picPath: "../images/taco.jpg",
          description: "A regular Taco",
          type: "Mexican",
          time: "Lunch/Dinner"
        },
        {
          id: 3,
          name: "Cake",
          picPath: "../images/cake.jpg",
          description: "Better than Pie",
          type: "Universally Recognized",
          time: "Dessert"
        },
        {
          id: 4,
          name: "Churros",
          picPath: "../images/churros.jpg",
          description: "Churros!",
          type: "Mexican",
          time: "lunch/dinner"
        },
        {
          id: 5,
          name: "Pizza",
          picPath: "../images/pizza.jpg",
          description: "Not a Fruit",
          type: "Italian",
          time: "Lunch/Dinner"
        }
      ]
    }

    var onload = (data) => {
      if (data) {
        this.restaurant = data;
      }
    }

    this.saveReturnId(id);
    this.getService.getFood(id).then(onload);
  }

  navToProfile() {
    this.router.navigate(['/user', this._returnId]);
  }

  saveReturnId(id) {
    this._returnId = id;
  }
}
