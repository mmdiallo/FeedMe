import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { HttpModule } from '@angular/http';
import { InMemoryWebApiModule } from 'angular-in-memory-web-api';

import { AppComponent }   from './app.component';
import { LoginComponent } from './login/login.component';
import { restLoginComponent } from './restaurantLogin/restaurantLogin.component'
import { RestaurantProfileComponent } from './restaurantProfile/restaurantProfile.component';
import { RegisterComponent } from './register/register.component';
import { RestaurantMenuComponent } from './restaurantMenu/restaurant-menu.component';
import { UserProfileComponent } from './userProfile/userProfile.component';
import { FoodFeedComponent } from './foodFeed/foodFeed.component';
import { UserEditorComponent } from './user-editor/user-editor.component';
import { RestaurantEditorComponent } from './restaurant-editor/restaurant-editor.component';

import { AuthenticateService } from './services/login.authenticate.service';
import { RestaurantGetService } from './services/restaurantGet.service';
import { UserGetService } from './services/userGet.service';
import { FoodFeedGetService } from './services/foodFeed.get.service';
import { MockApiService } from './mock-api.service';
import { UserEditorService } from './services/user-editor.service';
import { RestaurantEditorService } from './services/restaurant-editor.service';

@NgModule({
  imports:      [ 
  	BrowserModule,
  	FormsModule,
    HttpModule,
  	RouterModule.forRoot([
  		{ path: '', component: LoginComponent },
      { path: 'register', component: RegisterComponent },
      { path: 'restaurant', component: RestaurantProfileComponent },
      { path: 'menu', component: RestaurantMenuComponent },
      { path: 'user', component: UserProfileComponent },
      { path: 'feed', component: FoodFeedComponent }, 
      { path: 'restLogin', component: restLoginComponent },
      { path: 'menu/:restaurantId', component: RestaurantMenuComponent }, 
  		{ path: 'restaurant/:restaurantId', component: RestaurantProfileComponent },
      { path: 'restaurant/update/:restaurantId', component: RestaurantEditorComponent },
      { path: 'user/:userId', component: UserProfileComponent },
      { path: 'user/update/:userId', component: UserEditorComponent },
      { path: 'feed/:userId', component: FoodFeedComponent }
	]),
  InMemoryWebApiModule.forRoot(MockApiService)
  ],
  declarations: [
  	AppComponent,
    LoginComponent,
    RegisterComponent,
    RestaurantProfileComponent,
    RestaurantEditorComponent,
    RestaurantMenuComponent,
    restLoginComponent,
    UserProfileComponent,
    UserEditorComponent,
    FoodFeedComponent
  ],
  providers: [ 
		AuthenticateService,
    RestaurantGetService,
    RestaurantEditorService,
    UserGetService,
    UserEditorService,
    FoodFeedGetService
		],
  bootstrap:    [ AppComponent ]
})

export class AppModule { }
