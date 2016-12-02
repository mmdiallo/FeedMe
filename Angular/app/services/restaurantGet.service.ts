import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class RestaurantGetService {

    private _apiUrl = 'app/restaurants';

    constructor(private http: Http) {}

    getRestaurant(id: number) : Promise<any> {
        var pluck = x => (x && x.length) ? x[0] : undefined;
		return this.http
			.get(`${this._apiUrl}/?id=${id}`)
			.toPromise()
			.then(x => pluck(x.json().data))
			.catch(x => alert(x.json().error));
    }

    deleteItem(restaurant: any, item: any): Promise<any> {
        return this.http
            .put(`${this._apiUrl}/${restaurant.id}`, restaurant)
            .toPromise()
            .catch(x => alert(x.json().error));
    }

    addItem(restaurant: any): Promise<any> {
        return this.http
			.put(`${this._apiUrl}/${restaurant.id}`, restaurant)
			.toPromise()
            .then(() => restaurant)
			.catch(x => alert(x.json().error));
    }
}