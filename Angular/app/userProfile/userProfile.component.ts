import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { UserGetService } from './../services/userGet.service';

@Component({
  selector: 'userProfile',
  templateUrl: './app/userProfile/userProfile.html',
  styleUrls: ['./app/userProfile/userProfile.css']
})

export class UserProfileComponent {

  restaurant: {
    id: number;
    name: string;
    bio: string;
    address: string;
    phoneNumber: string;
    email: string;
    openTime: string;
    closeTime: string;
    picPath: string;
    menu: any[];
  }

  user: {
    id: number;
    name: string;
    bio: string;
    email: string;
    picPath: string;
    favorites: any[];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: UserGetService) {
    this.user = {
      id: 1,
      name: 'string',
      bio: 'string',
      email: 'string',
      picPath: 'string',
      favorites: []
    }
    this.restaurant = {
      id: 0,
      name: "string",
      bio: "string",
      address: "string",
      phoneNumber: "string",
      email: "string",
      openTime: "string",
      closeTime: "string",
      picPath: "string",
      menu: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['userId']));
  }

  private load(id) {
    if (!id) {
      this.user = {
        id: 1,
        name: "Jake",
        bio: "Blank",
        email: "dvce@love.com",
        picPath: "../images/user.jpg",
        favorites: [
          {
            restaurantId: 1,
            menuId: 2
          },
          {
            restaurantId: 1,
            menuId: 4
          }
        ]
      }
      return;
    }

    var onload = (data) => {
      if (data) {
        this.user = data;
      }
    }

    this.getService.getUserInfo(id).then(onload);
  }

  delete(fav) {
    this.getService.deleteItem(this.user, fav)
      .then(() => {
        this.user.favorites = this.user.favorites.filter(f => f !== fav);
      });
  }

  navToEdit(id) {
    this.router.navigate(['/user/update', id]);
  }
}
