"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
const core_1 = require('@angular/core');
const router_1 = require('@angular/router');
const userGet_service_1 = require('./../services/userGet.service');
let UserProfileComponent = class UserProfileComponent {
    constructor(route, router, getService) {
        this.route = route;
        this.router = router;
        this.getService = getService;
        this.user = {
            id: 1,
            name: 'string',
            email: 'string',
            picPath: 'string',
            favorites: []
        };
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['userId']));
    }
    load(id) {
        if (!id) {
            this.user = {
                id: 1,
                name: "Jake",
                email: "dvce@love.com",
                picPath: "../images/user.jpg",
                favorites: []
            };
            return;
        }
        var onload = (data) => {
            if (data) {
                this.user = data;
            }
        };
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
    navToFeed(id) {
        this.router.navigate(['/feed', id]);
    }
};
UserProfileComponent = __decorate([
    core_1.Component({
        selector: 'userProfile',
        templateUrl: './app/userProfile/userProfile.html',
        styleUrls: ['./app/userProfile/userProfile.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, userGet_service_1.UserGetService])
], UserProfileComponent);
exports.UserProfileComponent = UserProfileComponent;
//# sourceMappingURL=userProfile.component.js.map