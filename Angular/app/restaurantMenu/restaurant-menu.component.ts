import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RestaurantMenuUpdateService } from './../services/restaurantMenu.update.service';
import { RestaurantGetService } from './../services/restaurantGet.service';


@Component({
  selector: 'restaurantMenu',
  templateUrl: './app/restaurantMenu/restaurant-menu.html',
  styleUrls: [ './app/restaurantMenu/restaurant-menu.css' ]
})

export class RestaurantMenuComponent { 

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
    private getService: RestaurantGetService,
    private restaurantMenuUpdateService : RestaurantMenuUpdateService){
    
	}

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
