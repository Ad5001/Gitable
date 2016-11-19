<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Linux extends GitClient {
	
	
	/*
	Exec's a git request with defined args
	@param     $args    string
	*/
	public function gitExec(string $args) : string {
		chdir($this->dir);
		$process = proc_open(
		    "cd $this->dir\ngit " . $args, // Temporary working solution.
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
			
            chdir(DEFAULT_GIT_DIR);
			return $stdout . $stderr;
		} else {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
            chdir(DEFAULT_GIT_DIR);
			return "Error while executing command git " . $args . ": $stderr";
		}
	}


	/*
	Changes current directory
	@param     $path    string
	*/
	public function cd(string $path): string {
        if(substr($this->dir, strlen($this->dir) - 2) !== "/") {
			$this->dir .= "/";
        }
		if(is_dir($this->dir . $path)) {
			$this->dir = $this->dir . $path;
			$this->dir = realpath($this->dir);
			return "§aPath set to $this->dir";
		} elseif(is_dir($path)) {
			$this->dir = $path;
			$this->dir = realpath($this->dir);
            return"§aPath set to $this->dir";
		} else {
			return "§4Directory $path not found !";
		}
	}


	/*
	Return all files and dirs from the current directory
	*/
	public function ls() : string {
		chdir($this->dir);
		$whereIsCommand = (PHP_OS == 'WINNT') ? 'dir' : 'ls';
		
		$process = proc_open(
		    "$whereIsCommand $this->dir",
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $p
		  );
		if ($process !== false) {
			$stdout = stream_get_contents($p[1]);
			$stderr = stream_get_contents($p[2]);
			fclose($p[1]);
			fclose($p[2]);
			proc_close($process);
			
		}
		  chdir(DEFAULT_GIT_DIR);
			return $stdout;
	}


	/*
	Checks if the executable exists.
	*/
	public function initcheck() {
		$process = proc_open(
		    "git --version",
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
			
			if($stdout == '') {
				$this->main->getLogger()->info("Git error: $stderr");
				$this->main->getLogger()->critical("Git doesn't seems to be installed on your Linux computer ! Install it before uing this plugin.");
				$this->main->setEnabled(false);
			} else {
				$this->main->getLogger()->info("Loaded git: $stdout");
			}
		}
	}




}