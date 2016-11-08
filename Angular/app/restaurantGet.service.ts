import { Injectable } from '@angular/core';

@Injectable()
export class RestaurantGetService {

    testrestaurant: {
        name: string;
        bio: string;
        address: string;
        hours: string;
        picPath: string;
        menu: any[];
    };

    constructor() {
        this.testrestaurant = {
            name: "defaultname",
            bio: "defaultbio",
            address: "defaultaddress",
            hours: "defaulthours",
            picPath: "../images/food.jpg",
            menu: []
        }
    }

    getRestaurant(id: number) {
        return this.testrestaurant;
    }
}