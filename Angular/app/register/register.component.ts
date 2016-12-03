import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RegisterService } from './../services/register.service';


@Component({
  selector: 'register',
  templateUrl: './app/register/register.html',
  styleUrls: [ './app/register/register.css' ]
})

export class RegisterComponent { 
    name: string;
    password: string;
    email: string;
    picPath: string;
    isOwner: any;
    bio: any;    
    address: string;
    phoneNumber: string;
    webURL: string;
    openTime: string;
    closeTime: string;

  restaurant : {
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
  
  user : {
    id: number;
    name: string;
    password: string;
    email: string;
    picPath: string;
    favorites: any [];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private authenticateService : RegisterService){

  }

  ngOnInit() {  
    this.route.params.forEach(x => this.load(+x['id']));

    this.name = '';
    this.password = '';
    this.email = '';
    this.picPath = '';
    this.bio = '';    
    this.address = '';
    this.phoneNumber = '';
    this.webURL = '';
    this.openTime = '';
    this.closeTime = '';

    this.user = {
      id: 0,
      name: '',
      password: '',
      email: '',
      picPath: '',
      favorites: []
    }
    
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

	private load(id){
		if(!id) {
			return;
		}

		var onloadU = (data) => {
			if(data){
				this.user = data;
			} else {

			}
		};

    var onloadR = (data) => {
			if(data){
				this.restaurant = data;
			} else {

			}
		};
		
		this.authenticateService.addUser(id).then(onloadU);
    this.authenticateService.addRestaurant(id).then(onloadR);
	}

  addUser() {
    this.user.name = this.name;
    this.user.password = this.password;
    this.user.email = this.email;
    this.user.picPath = this.picPath;
    this.restaurant.bio = '';    
    this.restaurant.address = '';
    this.restaurant.phoneNumber = '';
    this.restaurant.webURL = '';
    this.restaurant.openTime = '';
    this.restaurant.closeTime = '';

    this.authenticateService.addUser(this.user)
    .then(() => this.returnToList(`You've been added!`));
  }

  addRestaurant() {
    this.restaurant.name = this.name;
    this.restaurant.password = this.password;
    this.restaurant.email = this.email;
    this.restaurant.picPath = this.picPath;
    this.restaurant.bio = this.bio;    
    this.restaurant.address = this.address;
    this.restaurant.phoneNumber = this.phoneNumber;
    this.restaurant.webURL = this.webURL;
    this.restaurant.openTime = this.openTime;
    this.restaurant.closeTime = this.closeTime;

    this.authenticateService.addRestaurant(this.restaurant)
    .then(() => this.returnToList(`You've been added!`));
  }

	private returnToList(message){
    alert(message);
		this.router.navigateByUrl('')
	}


}