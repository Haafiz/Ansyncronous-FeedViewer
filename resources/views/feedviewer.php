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
            <h2>Feed content</h2>
            <div class="form-group">
                <input type="text" v-model="url" class="form-control" placeholder="Search" v-on:keyup.enter="searchFeed">
                    {{url}}
            </div>
            <button type="button" class="btn btn-default" v-on:click="searchFeed">Search</button>
            <!-- <div class="row">
                <div class="col-sm-1">ID</div>
                <div class="col-sm-2">Name</div>
                <div class="col-sm-2">Description</div>
                <div class="col-sm-1">Price/Currency</div>
                <div class="col-sm-2">Category</div>
                <div class="col-sm-2">ProductURL</div>
                <div class="col-sm-2">ImageURL</div>
            </div> -->
            <div v-for="item in feedData">
                <!-- <v-client-table :data="tableData" :columns="columns" :options="options"></v-client-table> -->
                <div class="row">
                <div class="col-sm-2">Product ID: {{item.productID}}</div>
                <div class="col-sm-3">Name: {{item.name}}</div>
                <div class="col-sm-5">Description: {{item.description}}</div>
                <div class="col-sm-2">Price: {{item.price}}</div>
            </div>
                <div class="row">
                <div class="col-sm-2">Category: {{item.category}}</div>
                <div class="col-sm-3">Product URL: {{item.productURL}}</div>
                <div class="col-sm-5">Image URL: {{item.imageURL}}</div>
            </div>
            <div><hr></div>
            </div>
            </div>
        </div>
    <script src="js/app.js"></script>
    </body>
</html>
