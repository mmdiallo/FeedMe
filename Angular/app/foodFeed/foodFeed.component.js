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
        this.restaurant = {
            id: 1,
            name: 'string',
            bio: 'string',
            address: 'string',
            phoneNumber: 'string',
            email: 'sting',
            openTime: 'string',
            closeTime: 'string',
            picPath: 'string',
            menu: []
        };
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['userId']));
    }
    load(id) {
        this.restaurant = {
            id: 1,
            name: "Russell Hallmark's Fruit Emporium",
            bio: "BOOM we actually sell other things",
            address: "2222 WooHoo Lane",
            phoneNumber: "555-555-5464",
            email: "jjfu@bde.net",
            openTime: "08:00:00",
            closeTime: "18:00:00",
            picPath: "",
            menu: [
                {
                    id: 1,
                    name: "Taco Platter",
                    picPath: "../images/taco-platter.jpg",
                    description: "Great platter of tacos",
                    type: "Mexican",
                    time: "Breakfast"
                },
                {
                    id: 2,
                    name: "Taco",
                    picPath: "../images/taco.jpg",
                    description: "A regular Taco",
                    type: "Mexican",
                    time: "Lunch/Dinner"
                },
                {
                    id: 3,
                    name: "Cake",
                    picPath: "../images/cake.jpg",
                    description: "Better than Pie",
                    type: "Universally Recognized",
                    time: "Dessert"
                },
                {
                    id: 4,
                    name: "Churros",
                    picPath: "../images/churros.jpg",
                    description: "Churros!",
                    type: "Mexican",
                    time: "lunch/dinner"
                },
                {
                    id: 5,
                    name: "Pizza",
                    picPath: "../images/pizza.jpg",
                    description: "Not a Fruit",
                    type: "Italian",
                    time: "Lunch/Dinner"
                }
            ]
        };
        var onload = (data) => {
            if (data) {
                this.restaurant = data;
            }
        };
        this.saveReturnId(id);
        this.getService.getFood(id).then(onload);
    }
    navToProfile() {
        this.router.navigate(['/user', this._returnId]);
    }
    saveReturnId(id) {
        this._returnId = id;
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