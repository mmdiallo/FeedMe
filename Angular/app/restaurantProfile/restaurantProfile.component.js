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
const restaurantGet_service_1 = require('./../services/restaurantGet.service');
let RestaurantProfileComponent = class RestaurantProfileComponent {
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
            webURL: 'string',
            email: 'sting',
            openTime: 'string',
            closeTime: 'string',
            picPath: '../images/placeholder.jpg',
            menu: []
        };
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['restaurantId']));
    }
    load(id) {
        if (!id) {
            this.restaurant = {
                id: 1,
                name: "Russell Hallmark's Fruit Emporium",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                phoneNumber: "555-555-5464",
                webURL: 'www.Thisthing.com',
                email: "jjfu@bde.net",
                openTime: "08:00:00",
                closeTime: "18:00:00",
                picPath: "../images/placeholder.jpg",
                menu: [
                    {
                        id: 1,
                        name: "Taco Platter",
                        picPath: "",
                        description: "",
                        type: "Mexican",
                        time: "Breakfast"
                    },
                    {
                        id: 2,
                        name: "Fruit Salad",
                        picPath: "",
                        description: "Yummy Yummy",
                        type: "Not Mexican",
                        time: "I don't know"
                    },
                    {
                        id: 3,
                        name: "Cake",
                        picPath: "",
                        description: "Better than Pie",
                        type: "Universally Recognized",
                        time: "Dessert"
                    },
                    {
                        id: 4,
                        name: "Yogurt",
                        picPath: "",
                        description: "Gogurt",
                        type: "Processed",
                        time: "Snack"
                    },
                    {
                        id: 5,
                        name: "Pizza",
                        picPath: "",
                        description: "Not a Fruit",
                        type: "Italian",
                        time: "Lunch/Dinner"
                    }
                ]
            };
            return;
        }
        var onload = (data) => {
            if (data) {
                this.restaurant = data;
            }
        };
        this.getService.getRestaurant(id).then(onload);
    }
    delete(item) {
        this.getService.deleteItem(this.restaurant, item)
            .then(() => {
            this.restaurant.menu = this.restaurant.menu.filter(i => i !== item);
        });
    }
    navToEdit(id) {
        this.router.navigate(['/restaurant/update', id]);
    }
    navToUpload(id) {
        this.router.navigate(['/restaurant/upload', id]);
    }
};
RestaurantProfileComponent = __decorate([
    core_1.Component({
        selector: 'restaurantProfile',
        templateUrl: './app/restaurantProfile/restaurantProfile.html',
        styleUrls: ['./app/restaurantProfile/restaurantProfile.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, restaurantGet_service_1.RestaurantGetService])
], RestaurantProfileComponent);
exports.RestaurantProfileComponent = RestaurantProfileComponent;
//# sourceMappingURL=restaurantProfile.component.js.map