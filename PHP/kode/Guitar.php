<?php
require_once 'MusicInstrument.php';

class Guitar extends MusicInstrument {
    private $brand='';
    private $series='';
    private $fretSize=0;
    private $stringType='';

    public function __construct($id = 0, $price = 0.0, $stock = 0,
                                 $playingMethod = "", $condition = "", $weight = "",
                                 $brand = "", $series = "", $fretSize = 0, $stringType = "",
                                 $photo = "") {
        parent::__construct($id, $price, $stock, $playingMethod, $condition, $weight, $photo);
        $this->brand = $brand;
        $this->series = $series;
        $this->fretSize = $fretSize;
        $this->stringType = $stringType;
    }

    // getter and setter brand
    public function setBrand($brand) { $this->brand = $brand; }
    public function getBrand() { return $this->brand; }

    // getter and setter series
    public function setSeries($series) { $this->series = $series; }
    public function getSeries() { return $this->series; }

    // getter and setter fretSize
    public function setFretSize($fretSize) { $this->fretSize = $fretSize; }
    public function getFretSize() { return $this->fretSize; }

    // getter and setter stringType
    public function setStringType($stringType) { $this->stringType = $stringType; }
    public function getStringType() { return $this->stringType; }
}
?>