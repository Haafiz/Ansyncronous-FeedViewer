<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Feed Viewer</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="css/app.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div id="feedviewer">
                <h2>Feed Viewer</h2>
                <div class="form-group">
                    <input type="text" v-model="url" class="form-control" placeholder="URL" v-on:keyup.enter="searchFeed">
                    {{error}}
                </div>
                <button type="button" class="btn btn-default" v-on:click="searchFeed">Fetch Feeds</button>
                <div v-for="item in feedData">
                    <div class="row">
                        <div class="col-sm-2"><b>Product ID:</b> {{item.productID}}</div>
                        <div class="col-sm-3"><b>Name:</b> {{item.name}}</div>
                        <div class="col-sm-5"><b>Description:</b> {{item.description}}</div>
                        <div class="col-sm-2"><b>Price:</b> {{item.price}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2"><b>Category:</b> {{item.categories}}</div>
                        <div class="col-sm-3"><b>Product URL:</b> {{item.productURL}}</div>
                        <div class="col-sm-5"><b>Image URL:</b> {{item.imageURL}}</div>
                    </div>
                    <div><hr></div>
                </div>
                <div class="row">
                    <button v-if ="feedResultCount > feedData.length" v-on:click="showMore" >Show More</button>
                </div>
                <div><hr></div>
            </div>
        </div>
    <script src="js/app.js"></script>
    </body>
</html>
