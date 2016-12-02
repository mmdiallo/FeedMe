import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { RegisterService } from './../services/register.service';


@Component({
  selector: 'register',
  templateUrl: './app/register/register.html',
  styleUrls: [ './app/register/register.css' ]
})

export class RegisterComponent { 
  
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
    private authenticateService : RegisterService){
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

}