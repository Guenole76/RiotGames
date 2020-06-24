<?php

if($_GET['username'] && !empty($_GET['username'])) {

    $oRiotApi = new RiotAPI();
    $player = $oRiotApi->getSummoner($_GET['username']);
    $playermasteries = $oRiotApi->getMasteries($player->id);


    var_dump($player);
    var_dump($playermasteries);

}

