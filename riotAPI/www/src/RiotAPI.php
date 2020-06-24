<?php

class RiotAPI {
    protected $consts;
    protected $lang;
    protected $region;




    public function __construct() {
        $this->lang = 'fr';
        $this->region = 'EUW';

        $this->consts = json_decode(file_get_contents(DATA_PATH . '/consts.json'));
    }





    // raccourcis vers le JSON

    protected function VERSIONS() {
        return $this->consts->VERSIONS;
    }

    protected function REGIONS() {
        return $this->consts->REGIONS;
    }

    protected function LANGS() {
        return $this->consts->LANGS;
    }

    protected function API() {
        return $this->consts->api;
    }

    protected function DDRAGON() {
        return $this->consts->ddragon;
    }

    protected function API_KEY() {
        return $this->consts->API_KEY->key . $this->consts->API_KEY->value;
    }

    //



    public function getSummoner($username, $region=NULL) {
        if($region === NULL) {
            $region = $this->region;
        }

        $url = $this->format(
            $this->API()->base . $this->API()->url->summonerByName . $this->API_KEY(),
            [
                'region' => $this->REGIONS()->{$region},
                'version' => $this->VERSIONS()->summoner,
                'name' => $username
            ]
        );

        echo $url;

        $player = json_decode(file_get_contents($url));

        return (object)array(
            "name" => $player->name,
            "level" => $player->summonerLevel,
            "id" => $player->id
        );
    }



    protected function format($string, $match=[]) {
        foreach($match as $arg => $value) {
            $rgx = '/{'. preg_quote($arg, '/') .'}/';
            $string = preg_replace($rgx, $value, $string);
        }

        return $string;
    }


    public function getMasteries($summonerId, $region=NULL) {
        if($region === NULL) {
            $region = $this->region;
        }

        $url = $this->format(
            $this->API()->base . $this->API()->url->summonerMasteries . $this->API_KEY(),
            [
                'id' => $summonerId,
                'region' => $this->REGIONS()->{$region},
                'version' => $this->VERSIONS()->championmastery,
                'masteries' => $summonerId,
            ]
            
        );

        echo $url;

        $player = json_decode(file_get_contents($url));

        return (object)array(
           
            "masteries" => $player->summonerMasteries,
            
        );
    }
    

}