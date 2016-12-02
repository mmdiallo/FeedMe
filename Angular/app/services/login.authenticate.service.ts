import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class AuthenticateService { 
    private _restaurantsUrl = 'app/restaurants';
    private _usersUrl = 'app/users';

    constructor(private http: Http) {}

    public loginUser(user : any) : Promise<any> {
		var pluck = x => (x && x.length) ? x[0] : undefined;
		return this.http
			.get(`${this._usersUrl}/?name=${user.name}`)
			.toPromise()
			.then(x => pluck(x.json().data))
			.catch(x => alert(x.json().error));
	}

    public loginRest(rest : any) : Promise<any> {
		var pluck = x => (x && x.length) ? x[0] : undefined;
		return this.http
			.get(`${this._restaurantsUrl}/?name=${rest.name}`)
			.toPromise()
			.then(x => pluck(x.json().data))
			.catch(x => alert(x.json().error));
	}


}