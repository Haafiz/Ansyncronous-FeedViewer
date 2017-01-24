<?php namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class FeedReader implements MessageComponentInterface
{

    protected $conn;

    public function __construct()
    {
        $this->conn = null;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->conn = $conn;

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo sprintf('Connection %d sending message "%s"' . "\n", $from->resourceId, $msg);

        $url = $msg;
        $url = "http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2&limit=2";
        $file = $url;
        $reader = new \XMLReader();
        $reader->open($file);
        while ($reader->read() && $reader->name !== 'product');

        $doc = new \DOMDocument;
        while ($reader->name == 'product') {
            $productNode = simplexml_import_dom($doc->importNode($reader->expand(), true));
            $productArr = $this->getProductArr($productNode);
            $this->conn->send(json_encode($productArr));
            $reader->next('product');
        }

        $reader->close();
    }

    private function getProductArr($productNode)
    {
        $product = [];
        $product['name'] = current($productNode->name);
        $product['productID'] = current($productNode->productID);
        $price = $productNode->price;
        $product['price'] = (string)$productNode->price[0];
        $product['currency'] = current($productNode->price->attributes()->currency);
        $product['productURL'] = current($productNode->productURL);
        $product['imageURL'] = current($productNode->imageURL);
        $product['description'] = (string)current($productNode->description);
        $categories = $productNode->categories;
        //var_dump($categories);
        foreach ($categories->children() as $category) {
            $categoriesArr[] = (string)$category;
        }
        $product['categories'] = implode(", ", $categoriesArr);
        //$productNode->getAttribute('currency');
        return $product;
    }

    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}
