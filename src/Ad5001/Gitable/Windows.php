<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Windows extends GitClient {
	
	
	/*
	Exec's a git request with defined args
	@param     $args    string
	*/
	public function gitExec(string $args) : string {
		chdir($this->dir);
		echo "$this->executable " . $args . "  ";
		$process = proc_open(
		    "$this->executable " . $args,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $pipes
		  );
		  chdir(DEFAULT_GIT_DIR);
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);
			
			return $stdout . $stderr;
		} else {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			return "Error while executing command git " . $args . ": $stderr";
		}
	}


	/*
	Changes current directory
	@param     $path    string
	*/
	public function cd(string $path): string {
		if(is_dir($this->dir . $path)) {
			$this->dir = $this->dir . $path;
			$this->dir = realpath($this->dir);
			if(substr($this->dir, strlen($this->dir) - 1) !== "/") {
				$this->dir .= "/";
			}
			return "§aPath set to $this->dir";
		} elseif(is_dir($path)) {
			$this->dir = $path;
			$this->dir = realpath($this->dir);
			if(substr($this->dir, strlen($this->dir) - 1) !== "/") {
				$this->dir .= "/";
			}return"§aPath set to $path";
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
		    "$whereIsCommand",
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $p
		  );
		  chdir(DEFAULT_GIT_DIR);
		if ($process !== false) {
			$stdout = stream_get_contents($p[1]);
			$stderr = stream_get_contents($p[2]);
			fclose($p[1]);
			fclose($p[2]);
			proc_close($process);
			
		}
			return $stdout;
	}


	/*
	Checks if the executable exists.
	*/
	public function initcheck() {
		$this->executable = $this->main->getConfig()->get("executable_path");
		$process = proc_open(
		    "$this->executable --version",
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
				$this->main->getLogger()->critical("Executable wasn't found at path $this->executable. Be sure that you installed git and that the path in the config is the executable path.");
				$this->main->setEnabled(false);
			} else {
				$this->main->getLogger()->info("Loaded git: $stdout");
			}
		}
	}


	
	
	
}
