<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Windows extends GitClient {
	
	
	
	
	
	public function commit(string $message) : string {
		$handle = popen("git commit -m \"$message\"", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function push(string $to = "github", string $from = "master") : string {
		$handle = popen("git push $to $from", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function checkout($branch = null) : string {
		$handle = popen("git checkout " . (!is_null($branch) ? $this->getBranch() : $branch), 'r');
		return fread($handle, 2096);
	}
	
	
	public function getBranch() : string {
		$handle = popen('git branch', 'r');
		$read = fread($handle, 2096);
		return explode(" ", $read)[1];
	}
	
	
	public  function branch($branch = '') : string {
		$handle = popen("git branch " . $branch, 'r');
		return fread($handle, 2096);
	}
	
	
	public  function start() : string {
		$handle = popen("git init", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function init() : string {
		$handle = popen("git init", 'r');
		return fread($handle, 2096);
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
		$handle = popen("git clone $from", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function log() : string {
		$handle = popen("git log", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function remove($path) : string {
		$handle = popen("git rm $path", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function move($path, $newpath) : string {
		$handle = popen("git mv $path $newpath", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function add($path) : string {
		$handle = popen("git add $path", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function diff() : string {
		$handle = popen("git diff $path", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function status() : string {
		$handle = popen("git status -s", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function remote($name, $url) : string {
		$handle = popen("git remote $name $url", 'r');
		return fread($handle, 2096);
	}
	
	
	public  function pull($to = "github", $from = "master") : string {
		$handle = popen("git pull $to $from", 'r');
		return fread($handle, 2096);
	}
	
	
	
	
}
