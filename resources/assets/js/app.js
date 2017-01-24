/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const data = [
    //     {
    //     'productId': "1",
    //     'name': "Product 1",
    //     'description': "Testing description for a product is here",
    //     'price': "1.50",
    //     'category': "Category 1",
    //     'productUrl': "http://www.haafiz.me",
    //     'imageUrl': "http://www.haafiz.me"
    // }, {
    //     'productId': "2",
    //     'name': "Product 2",
    //     'description': "Testing description for a product is here",
    //     'price': "1.50",
    //     'category': "Category 2",
    //     'productUrl': "http://www.haafiz.me",
    //     'imageUrl': "http://www.haafiz.me"
    // }, {
    //     'productId': "3",
    //     'name': "Product 3",
    //     'description': "Testing description for a product is here",
    //     'price': "1.50",
    //     'category': "Category 3",
    //     'productUrl': "http://www.haafiz.me",
    //     'imageUrl': "http://www.haafiz.me"
    // }
];

const url = 'ws://localhost:9090';
const connection = new WebSocket(url, ['soap', 'xmpp']);

const app = new Vue({
    el: '#feedviewer',
    data: {
        url: "",
        feedData: []
    },
    methods: {
        searchFeed: function(e) {
            _this = this;
            console.log(this.url);
            connection.send(this.url);

            connection.onopen = function() {
                connection.send('Ping'); // Send the message 'Ping' to the server
            };

            // Log errors
            connection.onerror = function(error) {
                console.log('WebSocket Error ' + error);
            };

            // Log messages from the server
            connection.onmessage = function(e) {
                let data = JSON.parse(e.data);
                _this.feedData.push(data);

            };
        }


    }

});
