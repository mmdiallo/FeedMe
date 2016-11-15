import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RestaurantUpdateService } from './../services/restaurantProfile.update.service';
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
    private restaurantUpdateService: RestaurantUpdateService,
    private getService: RestaurantGetService) {
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
    this.route.params.forEach(x => this.load(+x['restaurantId']));
  }

  private load(id) {
    if (!id) {
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

    this.getService.get(id).then(onload);
  }
}

/*
this.route.params.forEach((params: Params) => {

      if (params['restaurantId'] !== undefined) {
        this.restaurant = this.getService.get(+params['restaurantId']);
      } else {
        this.restaurant = {
          name: "Bandito's Restaurant",
            bio: "If you're craving the original Austin Style Tex Mex taste that hasn't been around since the 1970's and '80's -- You've found it.  We flavor every item with a little Willie, Waylon, and a touch of Jerry Jeff Walker. ",
            address: "6615 Snider Plaza, Dallas, TX 75205",
            hours: "defaulthours",
            picPath: "../images/mexican-restaurant-prof-pic.jpg",
            menu: [
              {name : "Taco Bowl", picPath: "../images/food.jpg"},
              {name : "Taco", picPath: "../images/taco.jpg"},
              {name : "Enchiladas", picPath: "../images/enchiladas.jpg"},
              {name : "Taco Platter", picPath: "../images/taco-platter.jpg"},
              {name : "Street Tacos", picPath: "../images/taco-tester-platter.jpg"},
              {name : "Churros", picPath: "../images/churros.jpg"},
              {name : "Side of Guac", picPath: "../images/guac.jpg"},
              {name : "Steak Fajitas", picPath: "../images/steak-fajitas.jpg"}
            ]
        }

      }
    });
    */