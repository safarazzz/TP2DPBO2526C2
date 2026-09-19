<?php
require_once 'Item.php';

class MusicInstrument extends Item {
    private $playingMethod=''; // dipukul / ditabuh / dipetik
    private $condition='';     // likenew / baru / bekas / ori / premium
    private $weight='';        // disimpan sebagai string supaya satuan "kg" ikut

    public function __construct($id = 0, $price = 0.0, $stock = 0,
                                 $playingMethod = "", $condition = "", $weight = "", $photo = "") {
        parent::__construct($id, $price, $stock, $photo);
        $this->playingMethod = $playingMethod;
        $this->condition = $condition;
        $this->weight = $weight;
    }

    // getter and setter playingMethod
    public function setPlayingMethod($playingMethod) { $this->playingMethod = $playingMethod; }
    public function getPlayingMethod() { return $this->playingMethod; }

    // getter and setter condition
    public function setCondition($condition) { $this->condition = $condition; }
    public function getCondition() { return $this->condition; }

    // getter and setter weight
    public function setWeight($weight) { $this->weight = $weight; }
    public function getWeight() { return $this->weight; }
}
?>