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
const restaurantProfile_update_service_1 = require('./../restaurantProfile.update.service');
const restaurantGet_service_1 = require('./../restaurantGet.service');
let RestaurantProfileComponent = class RestaurantProfileComponent {
    constructor(route, router, restaurantUpdateService, getService) {
        this.route = route;
        this.router = router;
        this.restaurantUpdateService = restaurantUpdateService;
        this.getService = getService;
    }
    ngOnInit() {
        this.route.params.forEach((params) => {
            if (params['restaurantId'] !== undefined) {
                this.restaurant = this.getService.getRestaurant(+params['restaurantId']);
            }
            else {
                this.restaurant = {
                    name: "defaultname",
                    bio: "defaultbio",
                    address: "defaultaddress",
                    hours: "defaulthours",
                    picPath: "../images/food.jpg",
                    menu: [
                        { name: "Taco", picPath: "../images/food.jpg" }
                    ]
                };
            }
        });
    }
};
RestaurantProfileComponent = __decorate([
    core_1.Component({
        selector: 'restaurantProfile',
        templateUrl: './app/restaurantProfile/restaurantProfile.html',
        styleUrls: ['./app/restaurantProfile/restaurantProfile.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, restaurantProfile_update_service_1.RestaurantUpdateService, restaurantGet_service_1.RestaurantGetService])
], RestaurantProfileComponent);
exports.RestaurantProfileComponent = RestaurantProfileComponent;
//# sourceMappingURL=restaurantProfile.component.js.map