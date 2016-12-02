"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
const core_1 = require('@angular/core');
const router_1 = require('@angular/router');
const user_editor_service_1 = require('../services/user-editor.service');
let UserEditorComponent = class UserEditorComponent {
    constructor(route, router, userEditorService) {
        this.route = route;
        this.router = router;
        this.userEditorService = userEditorService;
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
    load(id) {
        if (!id) {
            this.heading = 'New User';
            return;
        }
        var onload = (data) => {
            if (data) {
                this._user = data;
                this.heading = "Edit Profile: " + data.name.toString();
            }
        };
        this.userEditorService.get(id).then(onload);
    }
};
__decorate([
    core_1.Input(), 
    __metadata('design:type', Array)
], UserEditorComponent.prototype, "model", void 0);
UserEditorComponent = __decorate([
    core_1.Component({
        selector: 'user-editor',
        templateUrl: './app/user-editor/user-editor.html',
        styleUrls: ['./app/user-editor/user-editor.css']
    }), 
    __metadata('design:paramtypes', [router_1.ActivatedRoute, router_1.Router, user_editor_service_1.UserEditorService])
], UserEditorComponent);
exports.UserEditorComponent = UserEditorComponent;
//# sourceMappingURL=user-editor.component.js.map