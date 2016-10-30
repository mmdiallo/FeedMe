import { Component } from '@angular/core';

import { RestaurantUpdateService } from './../restaurantProfile.update.service';


@Component({
  selector: 'restaurtantProfile',
  templateUrl: './app/restaurtantProfile/restaurtantProfile.html',
  styleUrls: [ './app/restaurtantProfile/restaurtantProfile.css' ]
})

export class RestaurantProfileComponent { 

	constructor(private restaurantProfileComponent : RestaurantProfileComponent){
	}

}
