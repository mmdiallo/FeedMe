import { Component } from '@angular/core';

import { RestaurantUpdateService } from './../restaurantProfile.update.service';


@Component({
  selector: 'restaurantProfile',
  templateUrl: './app/restaurantProfile/restaurantProfile.html',
  styleUrls: [ './app/restaurantProfile/restaurantProfile.css' ]
})

export class RestaurantProfileComponent { 

	constructor(private restaurantUpdateService : RestaurantUpdateService){
	}

}
