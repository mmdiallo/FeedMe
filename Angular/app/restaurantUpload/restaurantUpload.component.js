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
let RestaurantUploadComponent = class RestaurantUploadComponent {
    constructor(route, router, getService) {
        this.route = route;
        this.router = router;
        this.getService = getService;
        this._item = {
            restaurantId: 0,
            name: '',
            picPath: '',
            description: '',
            type: '',
            time: ''
        };
        this.restaurant = {
            id: 1,
            name: 'string',
            password: "asdf",
            bio: 'string',
            address: 'string',
            website: 'string',
            phoneNumber: 'string',
            email: 'sting',
            openTime: 'string',
            closeTime: 'string',
            picPath: 'string',
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
                password: "asdf",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                website: 'www.restaurant.com',
                phoneNumber: "555-555-5464",
                email: "jjfu@bde.net",
                openTime: "8:00am",
                closeTime: "5:00pm",
                picPath: "",
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
                this._item.restaurantId = this.restaurant.id;
            }
        };
        this.getService.getRestaurant(id).then(onload);
    }
    navToProfile(id) {
        this.router.navigate(['/restaurant/', id]);
    }
    addToRestaurant(id) {
        this.restaurant.menu.push(this._item);
        this.getService.addItem(this.restaurant);
        this.navToProfile(id);
        alert("Delicious!");
    }
};
RestaurantUploadComponent = __decorate([
    core_1.Component({
        selector: 'restaurantProfile',
        templateUrl: './app/restaurantUpload/restaurantUpload.html',
        styleUrls: ['./app/restaurantUpload/restaurantUpload.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, restaurantGet_service_1.RestaurantGetService])
], RestaurantUploadComponent);
exports.RestaurantUploadComponent = RestaurantUploadComponent;
//# sourceMappingURL=restaurantUpload.component.js.map