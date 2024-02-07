<?php
class Product
{
    private int $id;
    private int $category_id;
    private string $name;
    private array $photo;
    private int $price;
    private string $description;
    private int $quantity;
    private $createdAt;
    private $updatedAt;

    public function __construct($id = 0, $category_id = 0, $name = '', $photo = [], $price = 0, $description = '', $quantity = 0, $createdAt = new DateTime, $updatedAt = new DateTime) {
    
        $this->id = $id;
        $this->name = $name;
        $this->photo = $photo;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getCategory_id() {
        return $this->category_id;
    }
    public function setCategory_id($category_id) {
        $this->category_id = $category_id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getPhoto()
    {
        foreach ($this->photo as $key) {
            return "<img src='$key'></img>";
        }
    }
    public function setPhoto($photo) {
        $this->photo = $photo;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price) {
        $this->price = $price;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }
    public function getCreatedAt()
    {
        $date = $this->createdAt->format('Y-m-d H:i:s');
        return $date;
    }
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }
    public function getUpdatedAt()
    {
        $dateU = $this->updatedAt->format('Y-m-d H:i:s');
        return $dateU;
    }
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }
}
class Category
{
    private int $id;
    private string $name;
    private string $description;
    private $createdAt;
    private $updatedAt;

    public function __construct(int $id, string $name, string $description, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}

$product = new Product(1,1,'T-Shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful T-Shirt', 10, new DateTime(), new DateTime());

echo $product->getId() . '<br/>';

echo $product->getName() . '<br/>';

echo $product->getPhoto() . '<br/>';

echo $product->getPrice() . '<br/>';

echo $product->getDescription() . '<br/>';

echo $product->getQuantity() . '<br/>';

echo $product->getCreatedAt() . '<br/>';

echo $product->getUpdatedAt() . '<br/>';
