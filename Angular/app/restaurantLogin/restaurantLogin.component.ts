import { Component, Input } from '@angular/core';

import { AuthenticateService } from './../services/login.authenticate.service';

@Component({
  selector: 'restLogin',
  templateUrl: './app/restaurantLogin/restaurantLogin.html',
  styleUrls: [ './app/restaurantLogin/restaurantLogin.css' ]
})

export class restLoginComponent { 
	
	constructor(private authenticateService : AuthenticateService){
	}
	
}