/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page.
 */

Vue.component('example', require('./components/Example.vue'));

/**
 * Create websocket and define limit to show first time and then every time user click show more
 */
const url = 'ws://localhost:9090';
const connection = new WebSocket(url);
const limit = 10;

var feedResult = [];
const app = new Vue({
    el: '#feedviewer',
    data: {
        url: "",
        feedData: [],
        feedResultCount: 0,
        error: ""
    },
    methods: {
        searchFeed: function(e) {
            if (!this.url) {
                this.error = "Please enter URL";
                return false;
            }

            if (this.url.indexOf("http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8")) {
                this.error = "Please enter proper Trade Tracker URL";
                return false;
            }

            feedResult = [];
            this.feedResultCount = 0;
            this.feedData = [];
            connection.send(this.url);

            _this = this;
            connection.onopen = function() {
                connection.send('Ping'); // Send the message 'Ping' to the server
            };

            // Log errors
            connection.onerror = function(error) {
                console.log('WebSocket Error ' + error);
            };

            // Log messages from the server
            connection.onmessage = function(e) {
                var data = JSON.parse(e.data);

                feedResult.push(data);

                if (_this.feedData.length < limit) {
                    _this.feedData.push(data);
                }
                _this.feedResultCount = feedResult.length;
            };
        },
        showMore: function(e) {
            var data = feedResult.slice(this.feedData.length, (this.feedData.length + limit));
            this.feedData = this.feedData.concat(data);
        }
    }
});
