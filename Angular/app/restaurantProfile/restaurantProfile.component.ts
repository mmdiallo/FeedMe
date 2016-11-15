import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RestaurantUpdateService } from './../restaurantProfile.update.service';
import { RestaurantGetService } from './../restaurantGet.service';

@Component({
  selector: 'restaurantProfile',
  templateUrl: './app/restaurantProfile/restaurantProfile.html',
  styleUrls: ['./app/restaurantProfile/restaurantProfile.css']
})

export class RestaurantProfileComponent {

  restaurant: {
    name: string;
    bio: string;
    address: string;
    hours: string;
    picPath: string;
    menu: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private restaurantUpdateService: RestaurantUpdateService,
    private getService: RestaurantGetService) { }

  ngOnInit() {
    this.route.params.forEach((params: Params) => {

      if (params['restaurantId'] !== undefined) {
        this.restaurant = this.getService.getRestaurant(+params['restaurantId']);
      } else {
        this.restaurant = {
          name: "defaultname",
            bio: "defaultbio",
            address: "defaultaddress",
            hours: "defaulthours",
            picPath: "../images/food.jpg",
            menu: [
              {name : "Taco", picPath: "../images/food.jpg"}
            ]
        }

      }
    });
}

}
