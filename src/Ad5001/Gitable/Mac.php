<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Dummy {




   public function __construct(Main $main) {


        $this->main = $main;


        $this->server = $main->getServer()


    }




}