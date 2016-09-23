<?php


namespace Ad5001\Gitable;


use pocketmine\command\CommandSender;


use pocketmine\command\Command;


use pocketmine\event\Listener;


use pocketmine\plugin\PluginBase;


use pocketmine\utils\TextFormat as C;


use pocketmine\Server;


use pocketmine\utils\Utils;


use pocketmine\Player;





class Main extends PluginBase implements Listener {
    protected $git;

    const PREFIX = C::BLACK . "[" . C::LIGHT_GRAY . "Git" . C::BLACK . "] " . C::LIGHT_GRAY;


    public function onEnable() {


        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        if(Utils::getOS() == "win") {
            $this->git = new Windows($this, $this->getDataFolder());
        } elseif(Utils::getOS() == "linux") {
            $this->git = new Linux($this, $this->getDataFolder());
        } elseif(Utils::getOS() == "mac") {
            $this->git = new Mac($this, $this->getDataFolder());
        }

    }




    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){


        switch($cmd->getName()){


            case 'git':

            if(count($args) >= 2) {

                switch($args[0]) {

                    case "cd":
                    $this->git->cd($args[1]);
                    $sender->sendMessage("New path: " . $this->git->getDir());
                    break;
                }
                return true;
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