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