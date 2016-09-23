<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Windows extends GitClient {
	
	
	
	
	
	public function commit(string $message) : string {
		return shell_exec("git commit -m \"$message\"");
	}
	
	
	public  function push(string $to = "github", string $from = "master") : string {
		return shell_exec("git push $to $from");
	}
	
	
	public  function checkout($branch = null) : string {
		return shell_exec("git checkout " . (!is_null($branch) ? $this->getBranch() : $branch));
	}
	
	
	public function getBranch() : string {
		$handle = popen('git branch', 'r');
		$read = fread($handle, 2096);
		return explode(" ", $read)[1];
	}
	
	
	public  function branch($branch = '') : string {
		return shell_exec("git branch " . $branch);
	}
	
	
	public  function start() : string {
		return shell_exec("git init");
	}
	
	
	public  function init() : string {
		return shell_exec("git init");
	}
	
	public function getDir() {
		return $this->dir;
	}
	
	
	public  function cd($path) : string {
		if(is_dir($path)) {
			$dir = chdir($path);
			$this->dir = getcwd();
			return (string) $dir;
		} else {
            return "Directory $path not found !";
        }
	}
	
	
	public  function clone($from) : string {
	}
	
	
	public  function log() : string {
	}
	
	
	public  function remove($path) : string {
	}
	
	
	public  function move($path, $newpath) : string {
	}
	
	
	public  function add($path) : string {
	}
	
	
	public  function diff($path) : string {
	}
	
	
	public  function status($path) : string {
	}
	
	
	public  function remote($name, $url) : string {
	}
	
	
	public  function pull($to = "github", $from = "master") : string {
	}
	
	
	
	
}
