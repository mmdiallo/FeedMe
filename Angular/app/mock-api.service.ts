import { Injectable } from '@angular/core';
import { InMemoryDbService } from 'angular-in-memory-web-api';

@Injectable()
export class MockApiService implements InMemoryDbService {
    createDb() {

        let restaurants = [
            {
                id: 1,
                name: "Russell Hallmark's Fruit Emporium",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                phoneNumber: "555-555-5464",
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
                openTime: "08:00:00",
                closeTime: "18:00:00",
                picPath: "../images/mexican-restaurant-prof-pic.jpg",
                menu: [
                    {
                        id: 1,
                        name: "Taco Bowl",
                        picPath: "../images/food.jpg",
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
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 7,
                        name: "Side of Guac",
                        picPath: "../images/guac.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        id: 8,
                        name: "Steak Fajitas",
                        picPath: "../images/steak-fajitas.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            }

        ]

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
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        menuId: 8,
                        name: "Side of Guac",
                        picPath: "../images/guac.jpg",
                        description: "I dunno how to describe enchiladas.",
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
                        description: "I dunno how to describe enchiladas.",
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

        ]
        return {
            restaurants,
            users
        };
    }
}