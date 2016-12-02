import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { AuthenticateService } from './../services/login.authenticate.service';

@Component({
  selector: 'restLogin',
  templateUrl: './app/restaurantLogin/restaurantLogin.html',
  styleUrls: [ './app/restaurantLogin/restaurantLogin.css' ]
})

export class restLoginComponent { 

  restaurant: {
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

		constructor(private route: ActivatedRoute,
    private router: Router,
    private authenticateService : AuthenticateService){
      this.restaurant = {
      id: 1,
      name: '',
      password: "",
      bio: '',
      address: '',
      phoneNumber: '',
      webURL: '',
      email: '',
      openTime: '',
      closeTime: '',
      picPath: '',
      menu: []
    }
    }
	
    loginToRest() {
      var navToProfile = (data) => {
      if (data) {
        this.restaurant = data;
        this.router.navigate(['/restaurant', this.restaurant.id]);
        
      }
    }

      this.authenticateService.loginRest(this.restaurant).then(navToProfile);
    }

}