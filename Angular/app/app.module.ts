import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';

import { AppComponent }   from './app.component';
import { AuthenticateService } from './login.authenticate.service';
import { RestaurantUpdateService } from './restaurantProfile.update.service';
import { LoginComponent } from './login/login.component';
import { RestaurantProfileComponent } from './restaurantProfile/restaurantProfile.component';

@NgModule({
  imports:      [ 
  	BrowserModule,
  	FormsModule,
  	RouterModule.forRoot([
  		{ path: '', component: LoginComponent },
  		{ path: 'restaurant/:restaurantId', component: RestaurantProfileComponent }
	])
  ],
  declarations: [
  	AppComponent,
    LoginComponent,
    RestaurantProfileComponent
  ],
  providers: [ 
		AuthenticateService,
    RestaurantUpdateService  
		],
  bootstrap:    [ AppComponent ]
})

export class AppModule { }
