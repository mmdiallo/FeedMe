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
const login_authenticate_service_1 = require('./../login.authenticate.service');
let restLoginComponent = class restLoginComponent {
    constructor(authenticateService) {
        this.authenticateService = authenticateService;
    }
};
restLoginComponent = __decorate([
    core_1.Component({
        selector: 'restLogin',
        templateUrl: './app/restaurantLogin/login.html',
        styleUrls: ['./app/restaurantLogin/login.css']
    }), 
    __metadata('design:paramtypes', [login_authenticate_service_1.AuthenticateService])
], restLoginComponent);
exports.restLoginComponent = restLoginComponent;
//# sourceMappingURL=restaurantLogin.component.js.map