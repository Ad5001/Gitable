<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



abstract class GitClient {


    protected $main;

    private $server;

    protected $dir;




   public function __construct(Main $main, string $dir) {


        $this->main = $main;

        $this->server = $main->getServer();

        $this->dir = $dir;


    }


    public abstract function commit(string $message) : string;


    public abstract function push(string $to = "github", string $from = "master") : string;


    public abstract function undoCommit() : string;


    public abstract function checkout($message) : string;


    public abstract function branch($message) : string;


    public abstract function start() : string;


    public abstract function init() : string;

    public function getDir() {
        return $this->dir;
    }


    public abstract function cd($path) : string;


    public abstract function clone($from) : string;


    public abstract function logs() : string;


    public abstract function remove($path) : string;


    public abstract function move($path) : string;


    public abstract function headreset() : string;


    public abstract function add($path) : string;


    public abstract function diff($path) : string;


    public abstract function status($path) : string;


    public abstract function remote($name, $url) : string;


    public abstract function pull($to = "github", $from = "master") : string;


    public abstract function status($path) : string;


}