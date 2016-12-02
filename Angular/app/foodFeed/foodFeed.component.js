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
const foodFeed_get_service_1 = require('./../services/foodFeed.get.service');
let FoodFeedComponent = class FoodFeedComponent {
    constructor(route, router, getService) {
        this.route = route;
        this.router = router;
        this.getService = getService;
        this._returnUser = {
            id: 0,
            name: 'string',
            password: "asdf",
            email: 'string',
            picPath: 'string',
            favorites: []
        };
        this._restaurant = {
            id: 1,
            name: 'string',
            password: "asdf",
            bio: 'string',
            address: 'string',
            phoneNumber: 'string',
            webURL: 'string',
            email: 'sting',
            openTime: 'string',
            closeTime: 'string',
            picPath: '../images/placeholder.jpg',
            menu: []
        };
        this.feed = {
            menu: []
        };
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['userId']));
    }
    load(id) {
        this._restaurants = [];
        this.feed = {
            menu: []
        };
        var addRestaurants = (data) => {
            if (data) {
                this._restaurants = data;
                this.addFood();
            }
        };
        this.saveReturnId(id);
        this.getService.getRestaurants().then(addRestaurants);
    }
    addFood() {
        for (let restaurant of this._restaurants) {
            this.feed.menu = this.feed.menu.concat(restaurant.menu);
        }
    }
    navToProfile() {
        this.router.navigate(['/user', this._returnId]);
    }
    navToRestaurant(item) {
        this.router.navigate(['/restaurant', item.restaurantId]);
    }
    saveReturnId(id) {
        this._returnId = id;
        var getUser = (data) => {
            if (data) {
                this._returnUser = data[0];
            }
        };
        this.getService.getReturnUser(id).then(getUser);
    }
    addToFav(item) {
        alert("Food added!");
        this._returnUser.favorites.push(item);
        this.getService.addFoodFav(this._returnUser);
    }
};
FoodFeedComponent = __decorate([
    core_1.Component({
        selector: 'feed',
        templateUrl: './app/foodFeed/foodFeed.html',
        styleUrls: ['./app/foodFeed/foodFeed.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, foodFeed_get_service_1.FoodFeedGetService])
], FoodFeedComponent);
exports.FoodFeedComponent = FoodFeedComponent;
//# sourceMappingURL=foodFeed.component.js.map