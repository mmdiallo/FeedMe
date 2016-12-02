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
const http_1 = require('@angular/http');
const angular_in_memory_web_api_1 = require('angular-in-memory-web-api');
const app_component_1 = require('./app.component');
const login_component_1 = require('./login/login.component');
const restaurantLogin_component_1 = require('./restaurantLogin/restaurantLogin.component');
const restaurantProfile_component_1 = require('./restaurantProfile/restaurantProfile.component');
const register_component_1 = require('./register/register.component');
const userProfile_component_1 = require('./userProfile/userProfile.component');
const foodFeed_component_1 = require('./foodFeed/foodFeed.component');
const user_editor_component_1 = require('./user-editor/user-editor.component');
const restaurant_editor_component_1 = require('./restaurant-editor/restaurant-editor.component');
const restaurantUpload_component_1 = require('./restaurantUpload/restaurantUpload.component');
const login_authenticate_service_1 = require('./services/login.authenticate.service');
const restaurantGet_service_1 = require('./services/restaurantGet.service');
const userGet_service_1 = require('./services/userGet.service');
const foodFeed_get_service_1 = require('./services/foodFeed.get.service');
const mock_api_service_1 = require('./mock-api.service');
const user_editor_service_1 = require('./services/user-editor.service');
const restaurant_editor_service_1 = require('./services/restaurant-editor.service');
const register_service_1 = require('./services/register.service');
let AppModule = class AppModule {
};
AppModule = __decorate([
    core_1.NgModule({
        imports: [
            platform_browser_1.BrowserModule,
            forms_1.FormsModule,
            http_1.HttpModule,
            router_1.RouterModule.forRoot([
                { path: '', component: login_component_1.LoginComponent },
                { path: 'register', component: register_component_1.RegisterComponent },
                { path: 'restaurant', component: restaurantProfile_component_1.RestaurantProfileComponent },
                { path: 'user', component: userProfile_component_1.UserProfileComponent },
                { path: 'feed', component: foodFeed_component_1.FoodFeedComponent },
                { path: 'restLogin', component: restaurantLogin_component_1.restLoginComponent },
                { path: 'restaurant/:restaurantId', component: restaurantProfile_component_1.RestaurantProfileComponent },
                { path: 'restaurant/update/:restaurantId', component: restaurant_editor_component_1.RestaurantEditorComponent },
                { path: 'restaurant/upload/:restaurantId', component: restaurantUpload_component_1.RestaurantUploadComponent },
                { path: 'user/:userId', component: userProfile_component_1.UserProfileComponent },
                { path: 'user/update/:userId', component: user_editor_component_1.UserEditorComponent },
                { path: 'feed/:userId', component: foodFeed_component_1.FoodFeedComponent }
            ]),
            angular_in_memory_web_api_1.InMemoryWebApiModule.forRoot(mock_api_service_1.MockApiService)
        ],
        declarations: [
            app_component_1.AppComponent,
            login_component_1.LoginComponent,
            register_component_1.RegisterComponent,
            restaurantProfile_component_1.RestaurantProfileComponent,
            restaurant_editor_component_1.RestaurantEditorComponent,
            restaurantUpload_component_1.RestaurantUploadComponent,
            restaurantLogin_component_1.restLoginComponent,
            userProfile_component_1.UserProfileComponent,
            user_editor_component_1.UserEditorComponent,
            foodFeed_component_1.FoodFeedComponent
        ],
        providers: [
            login_authenticate_service_1.AuthenticateService,
            restaurantGet_service_1.RestaurantGetService,
            restaurant_editor_service_1.RestaurantEditorService,
            userGet_service_1.UserGetService,
            user_editor_service_1.UserEditorService,
            foodFeed_get_service_1.FoodFeedGetService,
            register_service_1.RegisterService
        ],
        bootstrap: [app_component_1.AppComponent]
    }), 
    __metadata('design:paramtypes', [])
], AppModule);
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map