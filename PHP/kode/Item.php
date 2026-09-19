<?php
class Item {
    private $id=0;
    private $price=0;
    private $stock=0;
    private $photo='';
    // constructor (gabungan constructor kosong & berparameter)
    public function __construct($id = 0, $price = 0.0, $stock = 0, $photo = "") {
        $this->id = $id;
        $this->price = $price;
        $this->stock = $stock;
        $this->photo = $photo;
    }

    // getter and setter id
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    // getter and setter price
    public function setPrice($price) { $this->price = $price; }
    public function getPrice() { return $this->price; }

    // getter and setter stock
    public function setStock($stock) { $this->stock = $stock; }
    public function getStock() { return $this->stock; }

    // getter and setter photo
    public function setPhoto($photo) { $this->photo = $photo; }
    public function getPhoto() { return $this->photo; }
}
?>