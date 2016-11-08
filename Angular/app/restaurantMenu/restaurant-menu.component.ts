import { Component } from '@angular/core';

import { RestaurantMenuUpdateService } from './../restaurantMenu.update.service';


@Component({
  selector: 'restaurantMenu',
  templateUrl: './app/restaurantMenu/restaurantMenu.html',
  styleUrls: [ './app/restaurantMenu/restaurantMenu.css' ]
})

export class RestaurantMenuComponent { 

	constructor(private restaurantMenuUpdateService : RestaurantMenuUpdateService){
	}

}
