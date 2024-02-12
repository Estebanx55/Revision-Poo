<?php
$host = "localhost";
$db = "draft-shop";
$user = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

$pdo = new PDO($dsn, $user, $password);
class Product
{
    private $pdo;
    private int $id;
    private int $category_id;
    private string $name;
    private $photo;
    private int $price;
    private string $description;
    private int $quantity;
    private $createdAt;
    private $updatedAt;

    public function __construct(PDO $pdo, $id = 0, $category_id = 0, $name = '', $photo = [], $price = 0, $description = '', $quantity = 0, $createdAt = new DateTime, $updatedAt = new DateTime)
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->category_id = $category_id;
        $this->name = $name;
        $this->photo = $photo;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    public function getOneById($id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        $this->id = $product['id'];
        $this->category_id = $product['id_category'];
        $this->name = $product['name'];
        $this->photo = $product['photos'];
        $this->price = $product['price'];
        $this->description = $product['description'];
        $this->quantity = $product['quantity'];
        $this->createdAt = $product['created_at'];
        $this->updatedAt = $product['update_at'];
        echo $this->getCategory_id();
        echo $this->getName();
        echo $this->getPhoto();
        echo $this->getPrice();
        echo $this->getDescription();
        echo $this->getQuantity();
        echo $this->getCreatedAt();
        echo $this->getUpdatedAt();
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCategory_id()
    {
        $idCategory = $this->category_id;
        $pdo = $this->pdo;
        $sqlCategory = "SELECT * FROM category WHERE id_category = $idCategory";
        $statement = $pdo->prepare($sqlCategory);
        $statement->execute();
        $resultat = $statement->fetch(PDO::FETCH_ASSOC);
        $return = '';
        echo 'Category :</br>';
        foreach ($resultat as $result) {
            $return .= $result . '</br>';
        }
        $return .= '<<<>>></br>';
        return $return;
        // return $this->category_id;
    }
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;
    }
    public function getName()
    {
        if ($this->name == '') {
            return 'NO NAME';
        } else {
            echo 'Name: ';
            return $this->name . '</br>';
        }
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getPhoto()
    {
        if (is_array($this->photo)) {
            $arrayImage = '';
            foreach ($this->photo as $key) {
                $arrayImage .= "<img src=$key></img></br>";
            }
            return $arrayImage;
        } else {
            $image = json_decode($this->photo, true);
            $arrayImage = '';
            foreach ($image as $key) {
                $arrayImage .= "<img src=$key>c</img></br>";
            }
            return $arrayImage;
        }
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function getPrice()
    {
        echo '</br>';
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getDescription()
    {
        if ($this->description == '') {
            echo 'NO DESCRIPTION';
        } else {
            echo '</br>';
            return $this->description;
        }
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getQuantity()
    {
        echo '</br>';
        return $this->quantity;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function getCreatedAt()
    {
        if ($this->createdAt === null) {
            echo '<br>';
            $date = 'ERROR NO DATA';
        } else {
            echo '<br>';
            $date = $this->createdAt;
        }
        return $date;
    }
    public function setCreatedAt($createdAt)
    {
        if ($this->createdAt === null) {
            $this->createdAt = '';
        }
        $this->createdAt = $createdAt;
    }
    public function getUpdatedAt()
    {
        if ($this->updatedAt === null) {
            echo '<br>';
            $dateU = 'ERROR NO DATA';
        } else {
            echo '<br>';
            $dateU = $this->createdAt;
        }
        return $dateU;
    }
    public function setUpdatedAt($updatedAt)
    {
        if ($this->updatedAt === null) {
            $this->updatedAt = '';
        }
        $this->updatedAt = $updatedAt;
    }

    public function findAll()
    {
        $pdo = $this->pdo;
        $products = [];
        $sql = "SELECT * FROM product";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product = new Product(
                $pdo,
                $row['id'],
                $row['id_category'],
                $row['name'],
                $row['photos'],
                $row['price'],
                $row['description'],
                $row['quantity'],
                $row['created_at'],
                $row['update_at']
            );
            $products[] = $product;
        }
        $number = 1;
        foreach ($products as $product) {
            echo 'Product ' . $number . ' :</br>';
            echo $product->getCategory_id();
            echo $product->getName();
            echo $product->getPhoto();
            echo $product->getPrice();
            echo $product->getDescription();
            echo $product->getQuantity();
            echo $product->getCreatedAt();
            echo $product->getUpdatedAt();
            echo '</br>';
            echo '----------';
            echo '</br>';
            $number++;
        }
    }
    public function createProduct()
    {
        $pdo = $this->pdo;
        $sql = "INSERT INTO product (id_category, name, photos, price, description, quantity, created_at, update_at) VALUES (:id_category, :name, :photos, :price, :description, :quantity, :created_at, :update_at)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id_category', $this->category_id, PDO::PARAM_INT);
        $statement->bindParam(':name', $this->name, PDO::PARAM_STR);
        if (is_array($this->photo)) {
            $this->photo = json_encode($this->photo);
        }
        $statement->bindParam(':photos', $this->photo, PDO::PARAM_STR);
        $statement->bindParam(':price', $this->price, PDO::PARAM_INT);
        $statement->bindParam(':description', $this->description, PDO::PARAM_STR);
        $statement->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
        $createdAt = $this->createdAt->format('Y-m-d H:i:s');
        $updatedAt = $this->updatedAt->format('Y-m-d H:i:s');
        $statement->bindParam(':created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam(':update_at', $updatedAt, PDO::PARAM_STR);
        $statement->execute();
        return $pdo->lastInsertId();
    }
    public function updateProduct()
    {
        $pdo = $this->pdo;
        $sql = "UPDATE product SET id_category = :id_category, name = :name, photos = :photos, price = :price, description = :description, quantity = :quantity, created_at = :created_at, update_at = :update_at WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id_category', $this->category_id, PDO::PARAM_INT);
        $statement->bindParam(':name', $this->name, PDO::PARAM_STR);
        if (is_array($this->photo)) {
            $this->photo = json_encode($this->photo);
        }
        $statement->bindParam(':photos', $this->photo, PDO::PARAM_STR);
        $statement->bindParam(':price', $this->price, PDO::PARAM_INT);
        $statement->bindParam(':description', $this->description, PDO::PARAM_STR);
        $statement->bindParam(':quantity', $this->quantity, PDO::PARAM_INT);
        if ($this->createdAt === null) {
            $this->createdAt = new DateTime();
        }
        if (is_string($this->createdAt)) {
            $createdAt = $this->createdAt;
        } else {
            $createdAt = $this->createdAt->format('Y-m-d H:i:s');
        }
        if ($this->updatedAt === null) {
            $updatedAt = new DateTime();
        }
        var_dump($this->updatedAt);
        if (is_string($this->updatedAt)) {
            $updatedAt = $this->updatedAt;
        } else {
            $updatedAt = $this->updatedAt->format('Y-m-d H:i:s');
        }
        $statement->bindParam(':created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam(':update_at', $updatedAt, PDO::PARAM_STR);
        $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        return $pdo->lastInsertId();
    }
}
class Clothing extends Product
{
    private $pdo;
    private int $id;
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;
    public function __construct($pdo,$id= 0, $size = '', $color = '', $type = '', $material_fee = 0)
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }
    public function getSize()
    {
        return $this->size;
    }
    public function setSize($size)
    {
        $this->size = $size;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color)
    {
        $this->color = $color;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getMaterial_fee()
    {
        return $this->material_fee;
    }
    public function setMaterial_fee($material_fee)
    {
        $this->material_fee = $material_fee;
    }
    public function create($product_id)
    {
        $pdo = $this->pdo;
        $sql = "INSERT INTO clothing (`product_id`, `size`, `color`, `type`, `material_fee`) VALUES (:product_id, :size, :color, :type,:material_fee)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $statement->bindParam(':size', $this->size, PDO::PARAM_STR);
        $statement->bindParam(':color', $this->color, PDO::PARAM_STR);
        $statement->bindParam(':type', $this->type, PDO::PARAM_STR);
        $statement->bindParam(':material_fee', $this->material_fee, PDO::PARAM_INT);
        $statement->execute();
        return $pdo->lastInsertId();
    }
    public function update()
    {
        $pdo = $this->pdo;
        $sql = "UPDATE clothing SET `size` = :size, `color` = :color, `type` = :type, `material_fee` = :material_fee WHERE `product_id` = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':size', $this->size, PDO::PARAM_STR);
        $statement->bindParam(':color', $this->color, PDO::PARAM_STR);
        $statement->bindParam(':type', $this->type, PDO::PARAM_STR);
        $statement->bindParam(':material_fee', $this->material_fee, PDO::PARAM_INT);
        $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        return $pdo->lastInsertId();
    }
    public function findOneById($id)
    {
        $this->id = $id;
        $pdo = $this->pdo;
        $sql = "SELECT * FROM clothing WHERE product_id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $product = new Clothing(
            $pdo,
            $id,
            $row['size'],
            $row['color'],
            $row['type'],
            $row['material_fee']
        );
        return $product;
    }
    public function findAll()
    {
        $pdo = $this->pdo;
        $products = [];
        $sql = "SELECT * FROM clothing";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product = new Clothing(
                $pdo,
                $row['product_id'],
                $row['size'],
                $row['color'],
                $row['type'],
                $row['material_fee']
            );
            $products[] = $product;
        }
        $number = 1;
        foreach ($products as $product) {
            echo 'Product ' . $number . ':</br>';
            echo $product->getSize();
            echo '<br>';
            echo $product->getColor();
            echo '<br>';
            echo $product->getType();
            echo '<br>';
            echo $product->getMaterial_fee();
            echo '</br>';
            echo '----------';
            echo '</br>';
            $number++;
        }
        return $products;
    }
}
class Electronic extends Product
{
    private $pdo;
    private int $id;
    private string $brand;
    private int $waranty_fee;
    public function __construct($pdo,$id, $brand = '', $warany_fee = 0)
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->brand = $brand;
        $this->warany_fee = $warany_fee;
    }
    public function getBrand()
    {
        return $this->brand;
    }
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
    public function getWarany_fee()
    {
        return $this->waranty_fee;
    }
    public function setWarany_fee($warany_fee)
    {
        $this->warany_fee = $warany_fee;
    }
    public function create($product_id) {
        $pdo = $this->pdo;
        $sql = "INSERT INTO electronic (`product_id`, `brand`, `warany_fee`) VALUES (:product_id, :brand, :warany_fee)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $statement->bindParam(':brand', $this->brand, PDO::PARAM_STR);
        $statement->bindParam(':warany_fee', $this->waranty_fee, PDO::PARAM_INT);
        $statement->execute();
        return $pdo->lastInsertId();
    }
    public function update() {
        $pdo = $this->pdo;
        $sql = "UPDATE electronic SET `brand` = :brand, `warany_fee` = :warany_fee WHERE `product_id` = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':brand', $this->brand, PDO::PARAM_STR);
        $statement->bindParam(':warany_fee', $this->waranty_fee, PDO::PARAM_INT);
        $statement->bindParam(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        return $pdo->lastInsertId();
    }
    public function findOneById($id) {
        $this->id = $id;
        $pdo = $this->pdo;
        $sql = "SELECT * FROM electronic WHERE product_id = :id";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $product = new Electronic(
            $pdo,
            $row['product_id'],
            $row['brand'],
            $row['waranty_fee']
        );
        return $product;
    }
    public function findAll() {
        $pdo = $this->pdo;
        $products = [];
        $sql = "SELECT * FROM electronic";
        $statement = $pdo->query($sql);
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $product = new Electronic(
                $pdo,
                $row['product_id'],
                $row['brand'],
                $row['waranty_fee']
            );
            $products[] = $product;
        }
        $number = 1;
        foreach ($products as $product) {
            echo 'Product '. $number. ':</br>';
            echo $product->getBrand();
            echo '<br>';
            echo $product->getWarany_fee();
            echo '</br>';
            echo '----------';
            echo '</br>';
            $number++;
        }
        return $products;
    }
}
class Category
{
    private $pdo;
    private int $id;
    private string $name;
    private string $description;
    private $createdAt;
    private $updatedAt;

    public function __construct(PDO $pdo, $id = 0, $name = '', $description = '', $createdAt = new DateTime, $updatedAt = new DateTime)
    {
        $this->pdo = $pdo;
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    public function getProduct()
    {
        $pdo = $this->pdo;
        $sql = "SELECT name FROM product WHERE id_category = $this->id";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $resultat = $statement->fetchAll(PDO::FETCH_ASSOC);
        $return = '';
        echo 'Products :</br>';
        foreach ($resultat as $result) {
            foreach ($result as $result2) {

                $return .= $result2 . '</br>';
            }
        }
        return $return;
    }
}
