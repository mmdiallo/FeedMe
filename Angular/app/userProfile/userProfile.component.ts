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
    name: string;
    password: string;
    email: string;
    picPath: string;
    favorites: any [];
  }

  constructor(private route: ActivatedRoute,
    private router: Router,
    private getService: UserGetService) {
    this.user = {
      id: 1,
      name: 'string',
      password: 'string',
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
        name: "Jake",
        password: 'string',
        email: "dvce@love.com",
        picPath: "../images/user.jpg",
        favorites: []
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
    this.user.favorites = this.user.favorites.filter(f => f !== fav);
    this.getService.deleteItem(this.user, fav);
  }

  navToEdit(id) {
    this.router.navigate(['/user/update', id]);
  }
  navToFeed(id) {
    this.router.navigate(['/feed', id]);
  }
}
