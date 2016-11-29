import { Component } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';

import { UserGetService } from './../services/userGet.service';

@Component({
  selector: 'userProfile',
  templateUrl: './app/userProfile/userProfile.html',
  styleUrls: ['./app/userProfile/userProfile.css']
})

export class UserProfileComponent {

  user: {
    id: number;
    firstName: string;
    lastName: string;
    email: string;
    picPath: string;
    favorites: any [];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: UserGetService) {
    this.user = {
      id: 1,
      firstName: 'string',
      lastName: 'string',
      email: 'string',
      picPath: 'string',
      favorites: []
    }
  }

  ngOnInit() {
    this.route.params.forEach(x => this.load(+x['userId']));
  }

  private load(id) {
    if (!id) {
      this.user = {
        id: 1,
        firstName: "Jake",
        lastName: "John",
        email: "dvce@love.com",
        picPath: "../images/user.jpg",
        favorites: []
      }
      return;
    }

    var updateFirstName = (data) => {
      if (data) {
        this.user.firstName = data;
      }
    }

    var updateLastName = (data) => {
      if (data) {
        this.user.lastName = data;
      }
    }

    var updateEmail = (data) => {
      if (data) {
        this.user.email = data;
      }
    }

    var updatePicPath = (data) => {
      if (data) {
        this.user.picPath = data;
      }
    }

    var updateFavorites = (data) => {
      if (data) {
        this.user.favorites = data;
      }
    }
    
    this.getService.getFirstName(id).then(updateFirstName);
    this.getService.getLastName(id).then(updateLastName);
    this.getService.getEmail(id).then(updateEmail);
    this.getService.getPicPath(id).then(updatePicPath);
    this.getService.getFavorites(id).then(updateFavorites);
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
