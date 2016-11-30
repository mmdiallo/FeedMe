import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class RestaurantEditorService {

	private _apiUrl  = 'app/restaurants';

	constructor(private http: Http){ }

	public get(id : number) : Promise<any> {
		var pluck = x => (x && x.length) ? x[0] : undefined;
		return this.http
			.get(`${this._apiUrl}/?id=${id}`)
			.toPromise()
			.then(x => pluck(x.json().data))
			.catch(x => alert(x.json().error));
	}

	public update(restaurant) : Promise<any> {
		return this.http
			.put(`${this._apiUrl}/${restaurant.id}`, restaurant)
			.toPromise()
			.then(() => restaurant)
			.catch(x => alert(x.json().error));
	}
}
