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
const restaurantMenu_update_service_1 = require('./../restaurantMenu.update.service');
const restaurantGet_service_1 = require('./../restaurantGet.service');
let RestaurantMenuComponent = class RestaurantMenuComponent {
    constructor(route, router, getService, restaurantMenuUpdateService) {
        this.route = route;
        this.router = router;
        this.getService = getService;
        this.restaurantMenuUpdateService = restaurantMenuUpdateService;
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
RestaurantMenuComponent = __decorate([
    core_1.Component({
        selector: 'restaurantMenu',
        templateUrl: './app/restaurantMenu/restaurant-menu.html',
        styleUrls: ['./app/restaurantMenu/restaurant-menu.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, restaurantGet_service_1.RestaurantGetService, restaurantMenu_update_service_1.RestaurantMenuUpdateService])
], RestaurantMenuComponent);
exports.RestaurantMenuComponent = RestaurantMenuComponent;
//# sourceMappingURL=restaurant-menu.component.js.map