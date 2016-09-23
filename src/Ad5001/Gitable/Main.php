<?php


namespace Ad5001\Gitable;


use pocketmine\command\CommandSender;


use pocketmine\command\Command;


use pocketmine\event\Listener;


use pocketmine\plugin\PluginBase;


use pocketmine\Server;


use pocketmine\utils\Utils;


use pocketmine\Player;





class Main extends PluginBase implements Listener {
    protected $git;


    public function onEnable() {


        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        if(Utils::getOS() == "win") {
            $this->git = new Windows($this);
        } elseif(Utils::getOS() == "linux") {
            $this->git = new Linux($this);
        } elseif(Utils::getOS() == "mac") {
            $this->git = new Mac($this);
        }

    }




    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){


        switch($cmd->getName()){


            case 'git':

            if(count($args) >= 1) {

                if(isset(self::COMMANDS[$args[0]])) {

                    $cmd = $args[0];

                    unset($args[0]);

                    $sender->sendMessage($this->git->{self::COMMANDS[$cmd][0]}(implode(" ", $args)));

                }
            }


            break;


        }


     return false;


    }


    public function getGitClient() {
        return $this->git;
    }


    public function setGitClient(GitClient $client) {
        $this->git = $client;
        return $this->git == $client;
    }


}