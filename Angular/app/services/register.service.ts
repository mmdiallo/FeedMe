import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class RegisterService { 

    private _apiUrl = 'app/restaurants';
    private _userUrl = 'app/users';

    constructor(private http: Http) { }

    addRestaurant(restaurant): Promise<any> {
        return this.http
			.post(this._apiUrl, restaurant)
			.toPromise()
			.then(() => restaurant)
			.catch(x => alert(x.json().error));
    }

    addUser(user): Promise<any> {
        return this.http
			.post(this._userUrl, user)
			.toPromise()
			.then(() => user)
			.catch(x => alert(x.json().error));
    }

}