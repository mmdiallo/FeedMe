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
const platform_browser_1 = require('@angular/platform-browser');
const forms_1 = require('@angular/forms');
const router_1 = require('@angular/router');
const app_component_1 = require('./app.component');
const login_authenticate_service_1 = require('./login.authenticate.service');
const restaurantProfile_update_service_1 = require('./restaurantProfile.update.service');
const restaurantGet_service_1 = require('./restaurantGet.service');
const restaurantMenu_update_service_1 = require('./restaurantMenu.update.service');
const login_component_1 = require('./login/login.component');
const restaurantProfile_component_1 = require('./restaurantProfile/restaurantProfile.component');
const register_component_1 = require('./register/register.component');
const restaurant_menu_component_1 = require('./restaurantMenu/restaurant-menu.component');
let AppModule = class AppModule {
};
AppModule = __decorate([
    core_1.NgModule({
        imports: [
            platform_browser_1.BrowserModule,
            forms_1.FormsModule,
            router_1.RouterModule.forRoot([
                { path: '', component: login_component_1.LoginComponent },
                { path: 'register', component: register_component_1.RegisterComponent },
                { path: 'restaurant', component: restaurantProfile_component_1.RestaurantProfileComponent },
                { path: 'menu', component: restaurant_menu_component_1.RestaurantMenuComponent },
                { path: 'restaurant/:restaurantId', component: restaurantProfile_component_1.RestaurantProfileComponent }
            ])
        ],
        declarations: [
            app_component_1.AppComponent,
            login_component_1.LoginComponent,
            register_component_1.RegisterComponent,
            restaurantProfile_component_1.RestaurantProfileComponent,
            restaurant_menu_component_1.RestaurantMenuComponent
        ],
        providers: [
            login_authenticate_service_1.AuthenticateService,
            restaurantProfile_update_service_1.RestaurantUpdateService,
            restaurantGet_service_1.RestaurantGetService,
            restaurantMenu_update_service_1.RestaurantMenuUpdateService
        ],
        bootstrap: [app_component_1.AppComponent]
    }), 
    __metadata('design:paramtypes', [])
], AppModule);
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map