# Feed Viewer
Feed Viewer take Trade tracker's URL from user and send that URL through websocket to websocket server running from same code base. Server parse big XML file without saving it anywhere or without fetching whole file using XMLReader and while reading every product node, it sends that product's record to client side through same web socket connection.

Normally PHP is not asynchronous so normally PHP waits for completion of script and then send data through sockets, that can keep socket waiting for all records to be completed which can kill the purpose. So for that reason a composer package `react/event-loop` is used, that make sure that it can perform tasks asynchronously and while server is reading XML file, client can receive data at that time side by side.

# Setup
This application use Laravel MVC framework for that purpose, so here is how you can set it up.
Extract all the files.

Run `composer install`. If you don't have composer already installed, then first install `composer`.
Make sure that `/storage` and `bootstrap/cache` directories are writable.

run `composer dump-autoload` .

For front-end stuff,I am using `vue.js`, `bootstrap-sass`, `gulp` and few other dependencies already in package.json file. So run `npm install`.

As I am using `Sass` and I am using `ES6` constructs, so I am using Gulp for running some script and compiling Sass and ES6 to ES5.

# Usage:

To run it you first need to run your HTTP server and then you need to run socket server using following command:

`php artisan wsocket:serve`. 

You will need to keep that terminal window open, otherwise you will need to send it to backgroun process.

Then go to `http://{yourserverurl and path to project}/public`. Enter URL and hit enter or press `Fetch Feeds` button.

It will start fetching feeds continuously and will first who 20 records. Then on clicking 'Show more' button it will show 20 more in no time as it is already getting data.

# More
There can be more things done in this but due to time limitation at my end that's all I could do for now in a test task.
