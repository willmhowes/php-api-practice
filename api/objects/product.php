<?php
class Product
{

   // database connection and table name
   private $conn;
   private $table_name = "videogames";

   // object properties
   public $id;
   public $title;
   public $publisher;
   public $releaseYear;
   public $rating;

   // constructor with $db as database connection
   public function __construct($db)
   {
      $this->conn = $db;
   }

   // read products
   function read()
   {
      // select all query
      $query = "SELECT * FROM $this->table_name;";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // execute query
      $stmt->execute();

      return $stmt;
   }

   // create product
   function create()
   {
      // query to insert record
      $query = "INSERT INTO " . $this->table_name . " ( \"title\" , \"publisher\", \"releaseYear\", \"rating\")
      VALUES (:title, :publisher, :releaseYear, :rating)";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->publisher = htmlspecialchars(strip_tags($this->publisher));
      $this->releaseYear = htmlspecialchars(strip_tags($this->releaseYear));
      $this->rating = htmlspecialchars(strip_tags($this->rating));

      // bind values
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':publisher', $this->publisher);
      $stmt->bindParam(':releaseYear', $this->releaseYear);
      $stmt->bindParam(':rating', $this->rating);

      // execute query
      if ($stmt->execute()) {
         return true;
      }

      return false;
   }
}
