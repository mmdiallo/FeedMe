import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RestaurantGetService } from './../services/restaurantGet.service';

@Component({
  selector: 'restaurantProfile',
  templateUrl: './app/restaurantProfile/restaurantProfile.html',
  styleUrls: ['./app/restaurantProfile/restaurantProfile.css']
})

export class RestaurantProfileComponent {

  restaurant: {
    id: number;
    name: string;
    password: string,
    bio: string;
    address: string;
    phoneNumber: string;
    webURL: string;
    email: string;
    openTime: string;
    closeTime: string;
    picPath: string;
    menu: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: RestaurantGetService) {
    this.restaurant = {
      id: 1,
      name: 'string',
      password: "asdf",
      bio: 'string',
      address: 'string',
      phoneNumber: 'string',
      webURL: 'string',
      email: 'sting',
      openTime: 'string',
      closeTime: 'string',
      picPath: '../images/placeholder.jpg',
      menu: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['restaurantId']));
  }

  private load(id) {
    if (!id) {
      this.restaurant = {
        id: 1,
        name: "Russell Hallmark's Fruit Emporium",
        password: "asdf",
        bio: "BOOM we actually sell other things",
        address: "2222 WooHoo Lane",
        phoneNumber: "555-555-5464",
        webURL: 'www.Thisthing.com',
        email: "jjfu@bde.net",
        openTime: "08:00:00",
        closeTime: "18:00:00",
        picPath: "../images/placeholder.jpg",
        menu: [
          {
            id: 1,
            name: "Taco Platter",
            picPath: "",
            description: "",
            type: "Mexican",
            time: "Breakfast"
          },
          {
            id: 2,
            name: "Fruit Salad",
            picPath: "",
            description: "Yummy Yummy",
            type: "Not Mexican",
            time: "I don't know"
          },
          {
            id: 3,
            name: "Cake",
            picPath: "",
            description: "Better than Pie",
            type: "Universally Recognized",
            time: "Dessert"
          },
          {
            id: 4,
            name: "Yogurt",
            picPath: "",
            description: "Gogurt",
            type: "Processed",
            time: "Snack"
          },
          {
            id: 5,
            name: "Pizza",
            picPath: "",
            description: "Not a Fruit",
            type: "Italian",
            time: "Lunch/Dinner"
          }
        ]
      }
      return;
    }

    var onload = (data) => {
      if (data) {
        this.restaurant = data;
      }
    }

    this.getService.getRestaurant(id).then(onload);
  }

  delete(item) {
    this.restaurant.menu = this.restaurant.menu.filter(i => i !== item);
    this.getService.deleteItem(this.restaurant, item);
  }

  navToEdit(id) {
    this.router.navigate(['/restaurant/update', id]);
  }
  navToUpload(id) {
    this.router.navigate(['/restaurant/upload', id]);
  }
  navToUserProfile(id) {
    this.router.navigate(['/restaurant/user', id]);
  }
}
