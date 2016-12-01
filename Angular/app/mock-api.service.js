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
let MockApiService = class MockApiService {
    createDb() {
        let restaurants = [
            {
                id: 1,
                name: "Russell Hallmark's Fruit Emporium",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                phoneNumber: "555-555-5464",
                webURL: 'www.Emporium.com',
                email: "jjfu@bde.net",
                openTime: "08:00:00",
                closeTime: "18:00:00",
                picPath: "../images/emporium.jpg",
                menu: [
                    {
                        id: 1,
                        name: "Taco Platter",
                        picPath: "../images/taco-platter.jpg",
                        description: "",
                        type: "Mexican",
                        time: "Breakfast"
                    },
                    {
                        id: 2,
                        name: "Fruit Salad",
                        picPath: "../images/fruitSalad.jpg",
                        description: "Yummy Yummy",
                        type: "Not Mexican",
                        time: "I don't know"
                    },
                    {
                        id: 3,
                        name: "Cake",
                        picPath: "../images/cake.jpg",
                        description: "Better than Pie",
                        type: "Universally Recognized",
                        time: "Dessert"
                    },
                    {
                        id: 4,
                        name: "Yogurt",
                        picPath: "../images/yogurt.jpg",
                        description: "Gogurt",
                        type: "Processed",
                        time: "Snack"
                    },
                    {
                        id: 5,
                        name: "Pizza",
                        picPath: "../images/pizza.jpg",
                        description: "Not a Fruit",
                        type: "Italian",
                        time: "Lunch/Dinner"
                    }
                ]
            },
            {
                id: 2,
                name: "Bandito's Restaurant",
                bio: "If you're craving the original Austin Style Tex Mex taste that hasn't been around since the 1970's and '80's -- You've found it.  We flavor every item with a little Willie, Waylon, and a touch of Jerry Jeff Walker. ",
                address: "6615 Snider Plaza, Dallas, TX 75205",
                phoneNumber: "214-555-5464",
                webURL: 'www.Banditos.com',
                email: "jjfu@bde.net",
                openTime: "08:00:00",
                closeTime: "18:00:00",
                picPath: "../images/mexican-restaurant-prof-pic.jpg",
                menu: [
                    {
                        id: 1,
                        name: "Taco Bowl",
                        picPath: "../images/tacobowl.jpg",
                        description: "They have taco bowls... Bowled....Tacos",
                        type: "Mexican",
                        time: "lunch"
                    },
                    {
                        id: 2,
                        name: "Taco",
                        picPath: "../images/taco.jpg",
                        description: "A regular Taco",
                        type: "Mexican",
                        time: "Lunch/Dinner"
                    },
                    {
                        id: 3,
                        name: "Enchiladas",
                        picPath: "../images/enchiladas.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 4,
                        name: "Taco Platter",
                        picPath: "../images/taco-platter.jpg",
                        description: "A Platter of Tacos",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 5,
                        name: "Street Tacos",
                        picPath: "../images/taco-tester-platter.jpg",
                        description: "Even Better, More 'Edgy' Tacos",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 6,
                        name: "Churros",
                        picPath: "../images/churros.jpg",
                        description: "Churros!",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 7,
                        name: "Side of Guac",
                        picPath: "../images/guac.jpg",
                        description: "Guac Dip for those Chips",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 8,
                        name: "Steak Fajitas",
                        picPath: "../images/steak-fajitas.jpg",
                        description: "So hot man. So hot.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            }
        ];
        let users = [
            {
                id: 1,
                name: "Jeff",
                bio: "I only Like Faijitas and Guac",
                email: "dvce@love.com",
                picPath: "../images/user1.jpg",
                favorites: [
                    {
                        restaurantId: 2,
                        menuId: 7,
                        name: "Steak Fajitas",
                        picPath: "../images/steak-fajitas.jpg",
                        description: "So hot man. So hot.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        menuId: 8,
                        name: "Side of Guac",
                        picPath: "../images/guac.jpg",
                        description: "Guac Dip for those Chips",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            },
            {
                id: 2,
                name: "John Doe",
                bio: "I am a massive FOODIE!! I specifically love Italian and Greek food. Check out my menu!",
                email: "dvce@love.com",
                picPath: "../images/user.jpg",
                favorites: [
                    {
                        restaurantId: 1,
                        menuId: 5,
                        name: "Pizza",
                        picPath: "../images/pizza.jpg",
                        description: "Not a Fruit",
                        type: "Italian",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 2,
                        menuId: 6,
                        name: "Churros",
                        picPath: "../images/churros.jpg",
                        description: "Chorros!!",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        menuId: 3,
                        name: "Enchiladas",
                        picPath: "../images/enchiladas.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            }
        ];
        return {
            restaurants,
            users
        };
    }
};
MockApiService = __decorate([
    core_1.Injectable(), 
    __metadata('design:paramtypes', [])
], MockApiService);
exports.MockApiService = MockApiService;
//# sourceMappingURL=mock-api.service.js.map