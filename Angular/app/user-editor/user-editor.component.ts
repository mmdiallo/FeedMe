import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { UserEditorService } from '../services/user-editor.service';


@Component({
    selector: 'user-editor',
    templateUrl: './app/user-editor/user-editor.html',
    styleUrls: ['./app/user-editor/user-editor.css']
})

export class UserEditorComponent {
    heading: string;
    @Input() model: any[];
    _user: {
    id: number;
    password: string;
    name: string;
    email: string;
    picPath: string;
    favorites: any [];
  };

    constructor(private route: ActivatedRoute,
        private router: Router,
        private userEditorService: UserEditorService) {
        this._user = {
            id: 1,
            name: 'string',
            password: 'string',
            email: 'string',
            picPath: 'string',
            favorites: []
        };
    }

    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['userId']));
    }

    save() {
        if (this._user.id) {
            this.userEditorService.update(this._user);
        }
    }

    return() {
        this.router.navigate(['/user', this._user.id]);
    }

    private load(id) {
        if (!id) {
            this.heading = 'New User';
            return;
        }

        var onload = (data) => {
            if (data) {
                this._user = data;
                this.heading = "Edit Profile: " + data.name.toString();
            } 
        }

        this.userEditorService.get(id).then(onload);
    }
}