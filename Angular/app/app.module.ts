import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

import { AppComponent }   from './app.component';
import { AuthenticateService } from './login.authenticate.service';
import { RestaurantUpdateService } from './restaurantProfile.update.service';
import { RestaurantGetService } from './restaurantGet.service';
import { RestaurantMenuUpdateService } from './restaurantMenu.update.service';
import { LoginComponent } from './login/login.component';
import { RestaurantProfileComponent } from './restaurantProfile/restaurantProfile.component';
import { RegisterComponent } from './register/register.component';
import { RestaurantMenuComponent } from './restaurantMenu/restaurant-menu.component';

@NgModule({
  imports:      [ 
  	BrowserModule,
  	FormsModule,
  	RouterModule.forRoot([
  		{ path: '', component: LoginComponent },
      { path: 'register', component: RegisterComponent },
      { path: 'restaurant', component: RestaurantProfileComponent },
      { path: 'menu', component: RestaurantMenuComponent }, 
  		{ path: 'restaurant/:restaurantId', component: RestaurantProfileComponent }
	])
  ],
  declarations: [
  	AppComponent,
    LoginComponent,
    RegisterComponent,
    RestaurantProfileComponent,
    RestaurantMenuComponent
  ],
  providers: [ 
		AuthenticateService,
    RestaurantUpdateService, 
    RestaurantGetService,
    RestaurantMenuUpdateService
		],
  bootstrap:    [ AppComponent ]
})

export class AppModule { }
