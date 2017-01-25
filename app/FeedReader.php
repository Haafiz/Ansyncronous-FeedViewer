<?php namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use AsyncPHP\Doorman\Manager\SynchronousManager;
use AsyncPHP\Doorman\Manager\ProcessManager;
use AsyncPHP\Doorman\Task\ProcessCallbackTask;

class FeedReader implements MessageComponentInterface
{

    protected $conn;

    public function __construct($loop)
    {
        $this->loop = $loop;
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
        $file = $url;
        $reader = new \XMLReader();
        $reader->open($file);
        while ($reader->read() && $reader->name !== 'product') {
        }

        $doc = new \DOMDocument;
        $i = 0;
        while ($reader->name == 'product') {
            $productNode = simplexml_import_dom($doc->importNode($reader->expand(), true));
            $productArr = $this->getProductArr($productNode);

            $conn = $this->conn;

            $this->loop->nextTick(function () use ($conn, $productArr) {
                $conn->send(json_encode($productArr));
            });
            $this->loop->nextTick(function () use ($reader) {
                $reader->next('product');
            });

            while ($this->loop->tick()) {
                usleep(500);
            }

            /**
             * stop sending data to browser that user can't utilize and which
             * can consume lot of memory in browser
             */
            if ($i > 5000) {
                break;
            }

            $i++;
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

        $categoriesArr = [];
        foreach ($categories->children() as $category) {
            $categoriesArr[] = (string)$category;
        }

        $product['categories'] = implode(", ", $categoriesArr);

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
