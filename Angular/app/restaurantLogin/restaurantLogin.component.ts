import { Component, Input } from '@angular/core';

import { AuthenticateService } from './../login.authenticate.service';

@Component({
  selector: 'restLogin',
  templateUrl: './app/restaurantLogin/login.html',
  styleUrls: [ './app/restaurantLogin/login.css' ]
})

export class restLoginComponent { 
	
	constructor(private authenticateService : AuthenticateService){
	}
	
}