import { Injectable } from '@angular/core';
import { InMemoryDbService } from 'angular-in-memory-web-api';

@Injectable()
export class MockApiService implements InMemoryDbService {
    createDb() {

        let restaurants = [
            {
                id: 1,
                name: "Russell Hallmark's Fruit Emporium",
                password: "asdf",
                bio: "BOOM we actually sell other things",
                address: "2222 WooHoo Lane",
                phoneNumber: "555-555-5464",
                webURL: 'www.Emporium.com',
                email: "info@Emporium.com",
                openTime: "3:00am",
                closeTime: "10:00pm",
                picPath: "../images/emporium.jpg",
                menu: [
                    {
                        restaurantId: 1,
                        name: "Taco Platter",
                        picPath: "../images/taco-platter.jpg",
                        description: "Beef, chicken, and pork tacos. Hand crafted on flour or corn tortillas made in house. Beef, chicken, and pork tacos. Hand crafted on flour or corn tortillas made in house.",
                        type: "Mexican",
                        time: "Breakfast"
                    },
                    {
                        restaurantId: 1,
                        name: "Fruit Salad",
                        picPath: "../images/fruitSalad.jpg",
                        description: "Yummy Yummy",
                        type: "Not Mexican",
                        time: "I don't know"
                    },
                    {
                        restaurantId: 1,
                        name: "Cake",
                        picPath: "../images/cake.jpg",
                        description: "Better than Pie",
                        type: "Universally Recognized",
                        time: "Dessert"
                    },
                    {
                        restaurantId: 1,
                        name: "Yogurt",
                        picPath: "../images/yogurt.jpg",
                        description: "Gogurt",
                        type: "Processed",
                        time: "Snack"
                    },
                    {
                        restaurantId: 1,
                        name: "Pizza",
                        picPath: "../images/pizza.jpg",
                        description: "Delicious wood fired oven backed pizza ",
                        type: "Italian",
                        time: "Lunch/Dinner"
                    }
                ]
            },
            {
                id: 2,
                name: "Bandito's Restaurant",
                password: "asdf",
                bio: "If you're craving the original Austin Style Tex Mex taste that hasn't been around since the 1970's and '80's -- You've found it.  We flavor every item with a little Willie, Waylon, and a touch of Jerry Jeff Walker. ",
                address: "6615 Snider Plaza, Dallas, TX 75205",
                phoneNumber: "214-555-5464",
                webURL: 'http://www.banditostexmex.com/',
                email: "info@banditostexmex.com",
                openTime: "12:00pm",
                closeTime: "5:00pm",
                picPath: "../images/mexican-restaurant-prof-pic.jpg",
                menu: [
                    {
                        restaurantId: 2,
                        name: "Taco Bowl",
                        picPath: "../images/taco-bowl.jpg",
                        description: "They have taco bowls... Bowled....Tacos",
                        type: "Mexican",
                        time: "lunch"
                    },
                    {
                        restaurantId: 2,
                        name: "Taco",
                        picPath: "../images/taco.jpg",
                        description: "A regular Taco",
                        type: "Mexican",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Enchiladas",
                        picPath: "../images/enchiladas.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Taco Platter",
                        picPath: "../images/taco-platter.jpg",
                        description: "A Platter of Tacos",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Street Tacos",
                        picPath: "../images/taco-tester-platter.jpg",
                        description: "Even Better, More 'Edgy' Tacos",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Churros",
                        picPath: "../images/churros.jpg",
                        description: "Churros!",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Side of Guac",
                        picPath: "../images/guac.jpg",
                        description: "Guac Dip for those Chips",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Steak Fajitas",
                        picPath: "../images/steak-fajitas.jpg",
                        description: "So hot man. So hot.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            },
            {
                id: 3,
                name: "New York Sub",
                password: "newyorksub",
                bio: "NY Sub is back and even better than I remember! Come grab a new york sub and coke.",
                address: "3411 Asbury St Dallas, TX 75205",
                phoneNumber: "(214) 522-1070",
                webURL: 'http://www.newyorksubhp.com.com/',
                email: "info@newyorksubs.com",
                openTime: "10:00am",
                closeTime: "8:00pm",
                picPath: "https://static1.squarespace.com/static/577568b0893fc0360cb37b55/577569b0d482e938c56b6079/577569b0d482e938c56b607c/1476917174253/New+York+Sub+online+ordering+image.jpg?format=2500w",
                menu: [
                    {
                        restaurantId: 3,
                        name: "#3 Roast Beef Sub",
                        picPath: "https://s3-media2.fl.yelpcdn.com/bphoto/yUV0BoE4SaEsmslvk-yBJA/o.jpg",
                        description: "Large and in Charge with lots of Meat!",
                        type: "American",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 3,
                        name: "#10 Ham Turkey",
                        picPath: "https://s3-media1.fl.yelpcdn.com/bphoto/pURaVK43kVpRiYaIv4thOQ/o.jpg",
                        description: "Best Ham Turkey cheese I've had. Great on white bread toasted. $5.50 for a half $9.5 for the whole.",
                        type: "American",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 3,
                        name: "#13 Pepper Turkey Capicolla",
                        picPath: "https://s3-media1.fl.yelpcdn.com/bphoto/DfRQ1V0GL8ff1_zRver17Q/o.jpg",
                        description: " Delicious turkey sub wrapped in wheat and covered in the New York Sub's delicious mayo.",
                        type: "American",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 3,
                        name: "#11 Ham Turkey Salami",
                        picPath: "https://bitesofdallas.files.wordpress.com/2012/07/nysubs-1.jpg",
                        description: " Delicious turkey sub wrapped in wheat and covered in the New York Sub's delicious mayo.",
                        type: "American",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 3,
                        name: "#12 Pastrami and Swiss",
                        picPath: "https://bitesofdallas.files.wordpress.com/2012/07/nysubs-2.jpg?w=300&h=225",
                        description: " Delicious turkey sub wrapped in wheat and covered in the New York Sub's delicious mayo.",
                        type: "American",
                        time: "Lunch/Dinner"
                    }



                ]
            }

        ]

        let users = [
            {
                id: 1,
                name: "Jeff",
                password: "asdf",
                bio: "I only Like Faijitas and Guac",
                email: "dvce@love.com",
                picPath: "../images/user1.jpg",
                favorites: [
                    {
                        restaurantId: 2,
                        name: "Steak Fajitas",
                        picPath: "../images/steak-fajitas.jpg",
                        description: "So hot man. So hot.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
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
                password: "asdf",
                bio: "I am a massive FOODIE!! I specifically love Italian and Greek food. Check out my menu!",
                email: "dvce@love.com",
                picPath: "../images/user.jpg",
                favorites: [
                    {
                        restaurantId: 1,
                        name: "Pizza",
                        picPath: "../images/pizza.jpg",
                        description: "Delicious wood fired oven backed pizza. Delicious wood fired oven backed pizza",
                        type: "Italian",
                        time: "Lunch/Dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Churros",
                        picPath: "../images/churros.jpg",
                        description: "Chorros!!",
                        type: "Mexican",
                        time: "lunch/dinner"
                    },
                    {
                        restaurantId: 2,
                        name: "Enchiladas",
                        picPath: "../images/enchiladas.jpg",
                        description: "I dunno how to describe enchiladas.",
                        type: "Mexican",
                        time: "lunch/dinner"
                    }
                ]
            },


        ]
        return {
            restaurants,
            users
        };
    }
}
