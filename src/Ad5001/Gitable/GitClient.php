<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;

define("DEFAULT_GIT_DIR", \pocketmine\Server::getInstance()->getFilePath(), true);

abstract class GitClient {


    protected $main;

    private $server;

    protected $dir;




   public function __construct(Main $main, string $dir) {


        $this->main = $main;

        $this->server = $main->getServer();

        $this->dir = $dir;

        $this->cd($dir);

        $this->initcheck();


    }


    public abstract function gitExec(string $args) : string;

    public function pwd() : string {
        return $this->dir;
    }


    public abstract function cd(string $path) : string;

    /*
    Return the list of files in directory.
    */
    public abstract function ls() : string;

    public abstract function initcheck();


}