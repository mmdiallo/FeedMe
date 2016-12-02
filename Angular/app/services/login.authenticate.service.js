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
const http_1 = require('@angular/http');
require('rxjs/add/operator/toPromise');
let AuthenticateService = class AuthenticateService {
    constructor(http) {
        this.http = http;
        this._restaurantsUrl = 'app/restaurants';
        this._usersUrl = 'app/users';
    }
    loginUser(user) {
        var pluck = x => (x && x.length) ? x[0] : undefined;
        return this.http
            .get(`${this._usersUrl}/?name=${user.name}`)
            .toPromise()
            .then(x => pluck(x.json().data))
            .catch(x => alert(x.json().error));
    }
    loginRest(rest) {
        var pluck = x => (x && x.length) ? x[0] : undefined;
        return this.http
            .get(`${this._restaurantsUrl}/?name=${rest.name}`)
            .toPromise()
            .then(x => pluck(x.json().data))
            .catch(x => alert(x.json().error));
    }
};
AuthenticateService = __decorate([
    core_1.Injectable(), 
    __metadata('design:paramtypes', [http_1.Http])
], AuthenticateService);
exports.AuthenticateService = AuthenticateService;
//# sourceMappingURL=login.authenticate.service.js.map