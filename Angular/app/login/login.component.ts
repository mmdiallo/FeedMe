import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { AuthenticateService } from './../services/login.authenticate.service';

@Component({
  selector: 'login',
  templateUrl: './app/login/login.html',
  styleUrls: [ './app/login/login.css' ]
})

export class LoginComponent { 

  user: {
    id: number;
    name: string;
    password: string;
    email: string;
    picPath: string;
    favorites: any [];
  }
	
	constructor(private route: ActivatedRoute,
    private router: Router,
    private authenticateService : AuthenticateService){
      this.user = {
      id: 0,
      name: '',
      password: '',
      email: '',
      picPath: '',
      favorites: []
    }
    }
	
    loginToUser() {
      var navToProfile = (data) => {
      if (data) {
        this.user = data;
        this.router.navigate(['/user', this.user.id]);
        
      }
    }

      this.authenticateService.loginUser(this.user).then(navToProfile);
    }


}