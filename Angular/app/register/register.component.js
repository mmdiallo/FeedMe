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
const register_service_1 = require('./../services/register.service');
let RegisterComponent = class RegisterComponent {
    constructor(route, router, authenticateService) {
        this.route = route;
        this.router = router;
        this.authenticateService = authenticateService;
    }
    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['id']));
        this.name = '';
        this.password = '';
        this.email = '';
        this.picPath = '';
        this.bio = '';
        this.address = '';
        this.phoneNumber = '';
        this.webURL = '';
        this.openTime = '';
        this.closeTime = '';
        this.user = {
            id: 0,
            name: '',
            password: '',
            email: '',
            picPath: '',
            favorites: []
        };
        this.restaurant = {
            id: 1,
            name: '',
            password: "",
            bio: '',
            address: '',
            phoneNumber: '',
            webURL: '',
            email: '',
            openTime: '',
            closeTime: '',
            picPath: '',
            menu: []
        };
    }
    load(id) {
        if (!id) {
            return;
        }
        var onload = (data) => {
            if (data) {
                this.user = data;
            }
            else {
            }
        };
        this.authenticateService.addUser(id).then(onload);
        this.authenticateService.addRestaurant(id).then(onload);
    }
    addUser() {
        this.user.name = this.name;
        this.user.password = this.password;
        this.user.email = this.email;
        this.restaurant.bio = '';
        this.restaurant.address = '';
        this.restaurant.phoneNumber = '';
        this.restaurant.webURL = '';
        this.restaurant.openTime = '';
        this.restaurant.closeTime = '';
        this.authenticateService.addUser(this.user)
            .then(() => this.returnToList(`You've been added!`));
    }
    addRestaurant() {
        this.restaurant.name = this.name;
        this.restaurant.password = this.password;
        this.restaurant.email = this.email;
        this.restaurant.bio = this.bio;
        this.restaurant.address = this.address;
        this.restaurant.phoneNumber = this.phoneNumber;
        this.restaurant.webURL = this.webURL;
        this.restaurant.openTime = this.openTime;
        this.restaurant.closeTime = this.closeTime;
        this.authenticateService.addRestaurant(this.restaurant)
            .then(() => this.returnToList(`You've been added!`));
    }
    returnToList(message) {
        alert(message);
        this.router.navigateByUrl('');
    }
};
RegisterComponent = __decorate([
    core_1.Component({
        selector: 'register',
        templateUrl: './app/register/register.html',
        styleUrls: ['./app/register/register.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, register_service_1.RegisterService])
], RegisterComponent);
exports.RegisterComponent = RegisterComponent;
//# sourceMappingURL=register.component.js.map