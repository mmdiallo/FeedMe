import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class UserGetService {

    private _apiUrl = 'app/users';

    constructor(private http: Http) { }

    getUserInfo(id: number): Promise<any> {
        var pluck = x => (x && x.length) ? x[0] : undefined;
        return this.http
            .get(`${this._apiUrl}/?id=${id}`)
            .toPromise()
            .then(x => pluck(x.json().data))
            .catch(x => alert(x.json().error));
    }

    deleteItem(user: any, item: any): Promise<void> {
        return this.http
            .delete(`${this._apiUrl}/${user.id}`, user.favorites[item.id])
            .toPromise()
            .catch(x => alert(x.json().error));
    }
}