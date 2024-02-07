<?php
class Product {
    private int $id;
    private string $name;
    private array $photo;
    private int $price;
    private string $description;
    private int $quantity;
    private $createdAt;
    private $updatedAt;

    public function __construct (int $id, string $name, array $photo, int $price, string $description, int $quantity, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->name = $name;
        $this->photo = $photo;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getPhoto() {
        foreach ($this->photo as $key) {
            return "<img src='$key'></img>";
        }
    }
    public function getPrice() {
        return $this->price;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getQuantity() {
        return $this->quantity;
    }
    public function getCreatedAt() {
        $date = $this->createdAt->format('Y-m-d H:i:s');
        return $date;
    }
    public function getUpdatedAt() {
        $dateU = $this->updatedAt->format('Y-m-d H:i:s');
        return $dateU;
    }
}

$product = new Product(1,'T-Shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful T-Shirt', 10, new DateTime(), new DateTime());

echo $product->getId(). '<br/>';

echo $product->getName(). '<br/>';

echo $product->getPhoto() . '<br/>';

echo $product->getPrice(). '<br/>';

echo $product->getDescription(). '<br/>';

echo $product->getQuantity(). '<br/>';

echo $product->getCreatedAt(). '<br/>';

echo $product->getUpdatedAt(). '<br/>';

