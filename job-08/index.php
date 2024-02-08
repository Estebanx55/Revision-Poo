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
    private string $photo;
    private int $price;
    private string $description;
    private int $quantity;
    private $createdAt;
    private $updatedAt;

    public function __construct(PDO $pdo, $id = 0, $category_id = 0, $name = '', $photo = '', $price = 0, $description = '', $quantity = 0, $createdAt = new DateTime, $updatedAt = new DateTime)
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
        $image = json_decode($this->photo, true);
        $arrayImage = '';
        foreach ($image as $key) {
            $arrayImage .= "<img src=$key></img></br>";
        }
        return $arrayImage;
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
        $this->updatedAt = $updatedAt;
    }

    public function findAll()
    {
        $pdo = $this->pdo;


        $products = [];

        // Requête SQL pour sélectionner toutes les lignes de la table Product
        $sql = "SELECT * FROM product";

        // Préparation et exécution de la requête
        $statement = $pdo->query($sql);

        // Parcours des résultats et création d'une instance de Product pour chaque ligne
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            // Création d'une nouvelle instance de Product avec les données de la ligne
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

            // Ajout de l'instance au tableau
            $products[] = $product;
        }

        // Retourne le tableau contenant toutes les instances de Product
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

$product = new Product($pdo);
$allProducts = $product->findAll();

print_r($allProducts);

foreach ($allProducts as $product) {
    echo $product->getCategory_id();
    echo $product->getName();
    echo $product->getPhoto();
    echo $product->getPrice();
    echo $product->getDescription();
    echo $product->getQuantity();
    echo $product->getCreatedAt();
    echo $product->getUpdatedAt();
}
