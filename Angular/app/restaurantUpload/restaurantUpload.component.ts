import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RestaurantGetService } from './../services/restaurantGet.service';

@Component({
  selector: 'restaurantProfile',
  templateUrl: './app/restaurantUpload/restaurantUpload.html',
  styleUrls: ['./app/restaurantUpload/restaurantUpload.css']
})

export class RestaurantUploadComponent {

  restaurant: {
    id: number;
    name: string;
    bio: string;
    address: string;
    website: string;
    phoneNumber: string;
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
      bio: 'string',
      address: 'string',
      website: 'string',
      phoneNumber: 'string',
      email: 'sting',
      openTime: 'string',
      closeTime: 'string',
      picPath: 'string',
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
        bio: "BOOM we actually sell other things",
        address: "2222 WooHoo Lane",
        website: 'www.restaurant.com',
        phoneNumber: "555-555-5464",
        email: "jjfu@bde.net",
        openTime: "8:00am",
        closeTime: "5:00pm",
        picPath: "",
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

  navToProfile(id) {
    this.router.navigate(['/restaurant/', id]);
  }
}