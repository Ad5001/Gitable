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
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		if(Utils::getOS() == "win") {
			if(!file_exists($this->getDataFolder() . "config.yml")) {
				file_put_contents($this->getDataFolder() . "config.yml", file_get_contents($this->getFile() . "resources/win.yml"));
			}
			$this->git = new Windows($this, $this->getDataFolder());
		}
		elseif(Utils::getOS() == "linux") {
			if(!file_exists($this->getDataFolder() . "config.yml")) {
				file_put_contents($this->getDataFolder() . "config.yml", file_get_contents($this->getFile() . "resources/linux.yml"));
			}
			$this->git = new Linux($this, $this->getDataFolder());
		}
		elseif(Utils::getOS() == "mac") {
			if(!file_exists($this->getDataFolder() . "config.yml")) {
				file_put_contents($this->getDataFolder() . "config.yml", file_get_contents($this->getFile() . "resources/mac.yml"));
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
					$sender->sendMessage(self::PREFIX . $this->git->cd($args[1]));
					break;
					
					case "ls":
					$sender->sendMessage(self::PREFIX . $this->git->ls());
                    break;

                    case "pwd":
					$sender->sendMessage(self::PREFIX . "§aPath: " . $this->git->pwd());
                    break;

                    default:
					$sender->sendMessage(self::PREFIX . $this->git->gitExec(implode(" ", $args)));
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
	
	
	
	/*
	Check if a command exists
	    @param     $command    string
	*/
	public function command_exists ($command) {
		$whereIsCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';
		
		$process = proc_open(
		    "$whereIsCommand $command",
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $pipes
		  );
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);
			
			return $stdout != '';
		}
	}
	
	
}
