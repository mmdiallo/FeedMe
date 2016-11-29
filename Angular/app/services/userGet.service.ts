import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class UserGetService {

    private _apiUrl = 'app/user';

    constructor(private http: Http) { }

    getFirstName(id: number): Promise<any> {
        return this.http.get(`${this._apiUrl}/getUserName/${id}`)
            .toPromise()
            .then(this.extractData);
    }

    getLastName(id: number): Promise<any> {
        return this.http.get(`${this._apiUrl}/getUserName/${id}`)
            .toPromise()
            .then(this.extractData);
    }

    getEmail(id: number): Promise<any> {
        return this.http.get(`${this._apiUrl}/users/email/${id}`)
            .toPromise()
            .then(this.extractData);
    }

    getPicPath(id: number): Promise<any> {
        return this.http.get(`${this._apiUrl}/getUserName/${id}`)
            .toPromise()
            .then(this.extractData);
    }

    getFavorites(id: number): Promise<any> {
        return this.http.get(`${this._apiUrl}/getUserName/${id}`)
            .toPromise()
            .then(this.extractData);
    }

    deleteItem(user: any, item: any): Promise<void> {
        return this.http
            .delete(`${this._apiUrl}/${user.id}`, user.favorites[item.id])
            .toPromise()
            .catch(x => alert(x.json().error));
    }

    updateUser(user) : Promise<any> {
		return this.http
			.put(`${this._apiUrl}/${user.id}`, user)
			.toPromise()
			.then(() => user)
			.catch(x => alert(x.json().error));
	}

    updateFavorites(user) : Promise<any> {
		return this.http
			.put(`${this._apiUrl}/${user.id}`, user)
			.toPromise()
			.then(() => user)
			.catch(x => alert(x.json().error));
	}

    private extractData(res: Response) {
        let body = res.json();
        return body.data || {};
    }
}