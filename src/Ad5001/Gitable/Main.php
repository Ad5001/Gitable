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

    const PREFIX = C::BLACK .C::BOLD . C::ITALIC . "[" . C::RESET . C::BOLD .C::GRAY . "Git" . C::BLACK . C::ITALIC . "] " . C::RESET . C::GRAY;


    public function onEnable() {

        @mkdir($this->getDataFolder());

        @mkdir($this->getDataFolder() . "bin");

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $zip = new ZipArchive();

        if(Utils::getOS() == "win") {
            if(!file_exists($this->getDataFolder() . "bin/git.exe") && $zip->open("../../resources/Windows.zip")) {
                $zip->extractTo($this->getDataFolder() . "bin");
                $zip->close();
            }
            $this->git = new Windows($this, $this->getDataFolder());
        } elseif(Utils::getOS() == "linux") {
            if(!file_exists($this->getDataFolder() . "bin/git.exe") && $zip->open("../../resources/Linux.zip")) {
                $zip->extractTo($this->getDataFolder() . "bin");
                $zip->close();
            }
            $this->git = new Linux($this, $this->getDataFolder());
        } elseif(Utils::getOS() == "mac") {
            if(!file_exists($this->getDataFolder() . "bin/git.exe") && $zip->open("../../resources/Mac.zip")) {
                $zip->extractTo($this->getDataFolder() . "bin");
                $zip->close();
            }
            $this->git = new Mac($this, $this->getDataFolder());
        } else {
            $this->getLogger()->critical("Unsuported device ! Please refer to the download page to see the list of available devices.");
            $this->setEnable(false);
        }

    }




    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){


        switch($cmd->getName()){


            case 'git':

            if(count($args) >= 2) {

                switch($args[0]) {

                    case "cd":
                    $this->git->cd($args[1]);
                    $sender->sendMessage(self::PREFIX . "New path: " . $this->git->getDir());
                    break;

                    case "commit":
                    unset($args[0]);
                    $sender->sendMessage(self::PREFIX . $this->git->commit(implode(" ", $args)));
                    $sender->sendMessage(self::PREFIX . "Commited !");
                    break;

                    case "checkout":
                    $sender->sendMessage(self::PREFIX . $this->git->checkout($args[1]));
                    break;

                    case "dir":
                    $sender->sendMessage(self::PREFIX . $this->git->getDir());
                    break;

                    case "clone":
                    $sender->sendMessage(self::PREFIX . $this->git->clone($args[1]));
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