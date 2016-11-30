import { Injectable } from '@angular/core';
import { Http, Headers, Response } from '@angular/http';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class UserEditorService {

	private _apiUrl  = 'app/users';

	constructor(private http: Http){ }

	public get(id : number) : Promise<any> {
		var pluck = x => (x && x.length) ? x[0] : undefined;
		return this.http
			.get(`${this._apiUrl}/?id=${id}`)
			.toPromise()
			.then(x => pluck(x.json().data))
			.catch(x => alert(x.json().error));
	}

	public update(user) : Promise<any> {
		return this.http
			.put(`${this._apiUrl}/${user.id}`, user)
			.toPromise()
			.then(() => user)
			.catch(x => alert(x.json().error));
	}
}
