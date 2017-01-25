<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory as ReactFactory;
use \React\Socket\Server;
use App\FeedReader;

class WSocketServer extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wsocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start socket server.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $port = intval($this->option('port'));

        $this->info("Starting chat web socket server on port " . $port);
        $loop = ReactFactory::create();

        $socket = new Server($loop);
        $socket->listen($port, '0.0.0.0');


        $server = new IoServer(
            new HttpServer(
                new WsServer(
                    new FeedReader($loop)
                )
            ),
            $socket,
            $loop
        );

        $server->run();

        // $server = IoServer::factory(
        //     new HttpServer(
        //         new WsServer(
        //             new FeedReader($loop)
        //         )
        //     ),
        //     $port,
        //     '0.0.0.0'
        // );
        //
        // $server->run();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['port', 'p', InputOption::VALUE_OPTIONAL, 'Port where to launch the server.', 9090],
        ];
    }
}
