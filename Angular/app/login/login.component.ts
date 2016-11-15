import { Component, Input } from '@angular/core';

import { AuthenticateService } from './../login.authenticate.service';

@Component({
  selector: 'login',
  templateUrl: './app/login/login.html',
  styleUrls: [ './app/login/login.css' ]
})

export class LoginComponent { 
	
	constructor(private authenticateService : AuthenticateService){
	}
	
}