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

  _returnUser: {
    id: number;
    name: string;
    password: string;
    email: string;
    picPath: string;
    favorites: any[];
  }

  _restaurant: {
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

  _restaurants: any[];

  feed: {
    menu: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: FoodFeedGetService) {
      this._returnUser = {
      id: 0,
      name: 'string',
      password: "asdf",
      email: 'string',
      picPath: 'string',
      favorites: []
    }

    this._restaurant = {
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

    this.feed = {
      menu: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['userId']));
  }

  private load(id) {

    this._restaurants = []

    this.feed = {
      menu: []
    }


    var addRestaurants = (data) => {
      if (data) {
        this._restaurants = data;
        this.addFood();
      }
    }

    this.saveReturnId(id);

    this.getService.getRestaurants().then(addRestaurants);
  }

    addFood() {
      for(let restaurant of this._restaurants) {
        this.feed.menu = this.feed.menu.concat(restaurant.menu);
      }
    }

  navToProfile() {
    this.router.navigate(['/user', this._returnId]);
  }

  navToRestaurant(item) {
    this.router.navigate(['/restaurant', item.restaurantId]);
  }

  saveReturnId(id) {
    this._returnId = id;

    var getUser = (data) => {
      if (data) {
        this._returnUser = data[0];
      }
    }

    this.getService.getReturnUser(id).then(getUser);
  }

  addToFav(item) {
    alert("Food added!");
    this._returnUser.favorites.push(item);
    this.getService.addFoodFav(this._returnUser);

  }
}
