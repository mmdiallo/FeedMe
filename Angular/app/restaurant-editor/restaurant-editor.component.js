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
const restaurant_editor_service_1 = require('../services/restaurant-editor.service');
let RestaurantEditorComponent = class RestaurantEditorComponent {
    constructor(route, router, restaurantEditorService) {
        this.route = route;
        this.router = router;
        this.restaurantEditorService = restaurantEditorService;
        this._restaurant = {
            id: 1,
            name: "Russell Hallmark's Fruit Emporium",
            password: "asdf",
            bio: "BOOM we actually sell other things",
            address: "2222 WooHoo Lane",
            phoneNumber: "555-555-5464",
            webURL: "www.thisthing.com",
            email: "jjfu@bde.net",
            openTime: "08:00:00",
            closeTime: "18:00:00",
            picPath: "../images/placeholder.jpg",
            menu: []
        };
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['restaurantId']));
    }
    save() {
        if (this._restaurant.id) {
            this.restaurantEditorService.update(this._restaurant);
        }
    }
    return() {
        this.router.navigate(['/restaurant', this._restaurant.id]);
    }
    load(id) {
        if (!id) {
            this.heading = 'New Restaurant';
            return;
        }
        var onload = (data) => {
            if (data) {
                this._restaurant = data;
                this.heading = "Edit Profile: " + data.name.toString();
            }
        };
        this.restaurantEditorService.get(id).then(onload);
    }
};
__decorate([
    core_1.Input(), 
    __metadata('design:type', Array)
], RestaurantEditorComponent.prototype, "model", void 0);
RestaurantEditorComponent = __decorate([
    core_1.Component({
        selector: 'restaurant-editor',
        templateUrl: './app/restaurant-editor/restaurant-editor.html',
        styleUrls: ['./app/restaurant-editor/restaurant-editor.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, restaurant_editor_service_1.RestaurantEditorService])
], RestaurantEditorComponent);
exports.RestaurantEditorComponent = RestaurantEditorComponent;
//# sourceMappingURL=restaurant-editor.component.js.map