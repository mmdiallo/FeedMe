import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class FoodFeedGetService { 

    private _apiUrl = 'app/restaurants';
    private _userUrl = 'app/users';

    constructor(private http: Http) { }

    getRestaurants(): Promise<any[]> {
        return this.http.get(this._apiUrl)
		.toPromise()
		.then(x => x.json().data as any[]);
    }

    getReturnUser(id: number): Promise<any> {
        return this.http.get(`${this._userUrl}/?id=${id}`)
		.toPromise()
		.then(x => x.json().data as any);
    }

    addFoodFav(user): Promise<any> {
        return this.http
			.put(`${this._userUrl}/${user.id}`, user)
			.toPromise()
            .then(() => user)
			.catch(x => alert(x.json().error));
    }
}