import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router, Params } from '@angular/router';
import { RestaurantEditorService } from '../services/restaurant-editor.service';


@Component({
    selector: 'restaurant-editor',
    templateUrl: './app/restaurant-editor/restaurant-editor.html',
    styleUrls: ['./app/restaurant-editor/restaurant-editor.css']
})

export class RestaurantEditorComponent {
    heading: string;
    @Input() model: any[];
    _restaurant: {
    id: number;
    name: string;
    bio: string;
    address: string;
    phoneNumber: string;
    email: string;
    openTime: string;
    closeTime: string;
    picPath: string;
    menu: any [];
  };



    constructor(private route: ActivatedRoute,
        private router: Router,
        private restaurantEditorService: RestaurantEditorService) {
        this._restaurant = {
             id: 1,
                name: "Russell Hallmark's Fruit Emporium",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                phoneNumber: "555-555-5464",
                email: "jjfu@bde.net",
                openTime: "08:00:00",
                closeTime: "18:00:00",
                picPath: "../images/placeholder.jpg",
                menu: []
        };
    }

    ngOnInit() {
        this.route.params.forEach(x => this.load(+x['restaurantId']));
    }

    save() {
        if (this._restaurant.id) {
            this.restaurantEditorService.update(this._restaurant);
        }
    }

    return() {
        this.router.navigate(['/restaurant', this._restaurant.id]);
    }

    private load(id) {
        if (!id) {
            this.heading = 'New Restaurant';
            return;
        }

        var onload = (data) => {
            if (data) {
                this._restaurant = data;
                this.heading = "Edit Profile: " + data.name.toString();
            } 
        }

        this.restaurantEditorService.get(id).then(onload);
    }
}