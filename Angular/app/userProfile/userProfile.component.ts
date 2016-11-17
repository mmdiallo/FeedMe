import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { UserUpdateService } from './../services/user.update.service';
import { UserGetService } from './../services/userGet.service';

@Component({
  selector: 'userProfile',
  templateUrl: './app/userProfile/userProfile.html',
  styleUrls: ['./app/userProfile/userProfile.css']
})

export class UserProfileComponent {

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

  user: {
    id: number;
    name: string;
    bio: string;
    email: string;
    picPath: string;
    favorites: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private updateService: UserUpdateService,
    private getService: UserGetService) {
    this.user = {
      id: 1,
      name: 'string',
      bio: 'string',
      email: 'string',
      picPath: 'string',
      favorites: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['userId']));
  }

  private load(id) {
    if (!id) {
      this.user = {
        id: 1,
        name: "Adam Ashcraft",
        bio: "Blank",
        email: "dvce@love.com",
        picPath: "../images/user.jpg",
        favorites: [
          {
            restaurantId: 1,
            menuId: 2
          },
          {
            restaurantId: 1,
            menuId: 4
          }
        ]
      }
      return;
    }

    var onload = (data) => {
      if (data) {
        this.user = data;
      }
    }

    this.getService.get(id).then(onload);
  }

  private getRestaurant(restaurantId) {
    this.getService.getRestaurant(restaurantId);
  }


  /*
  this.route.params.forEach((params: Params) => {

    if (params['restaurantId'] !== undefined) {
      this.restaurant = this.getService.getRestaurant(+params['restaurantId']);
    } else {
      this.restaurant = {
        name: "John Doe",
          bio: "I am a massive FOODIE!! I specifically love Italian and Greek food. Check out my menu!",
          address: "defaultaddress",
          hours: "defaulthours",
          picPath: "../images/user.jpg",
          menu: [
            {name : "Taco", picPath: "../images/taco.jpg"},
            {name : "Enchiladas", picPath: "../images/enchiladas.jpg"},
            {name : "Churros", picPath: "../images/churros.jpg"},
            {name : "Taco Platter", picPath: "../images/taco-platter.jpg"},
            {name : "Street Tacos", picPath: "../images/taco-tester-platter.jpg"},
            {name : "Side of Guac", picPath: "../images/guac.jpg"},
            {name : "Steak Fajitas", picPath: "../images/steak-fajitas.jpg"}
          ]
      }

    }
  });
  */

}
