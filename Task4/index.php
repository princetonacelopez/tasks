<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task 4</title>
</head>
<body>
  <h1>Task 4</h1>
</body>
</html>

<?php

// Server account
define("SERVERNAME","localhost"); 
define("USERNAME","root"); 
define("PASSWORD","AA_aa_11");
define("DATABASE","db");

// Create connection
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

// Check connection
echo mysqli_connect_errno() ? die("Connection failed: " . $conn->connect_error . "<br>") : "Connected successfully <br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS db";
echo $conn->query($sql)===TRUE ? "Database created successfully <br>" : "Error creating database : " . $conn->error . "<br>"; 

// Create authors table
$sql = "CREATE TABLE IF NOT EXISTS authors (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL
    )";
echo $conn->query($sql)===TRUE ? "Table authors created successfully <br>" : "Error creating table : " . $conn->error . "<br>"; 

// Create books table
$sql = "CREATE TABLE IF NOT EXISTS books (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(30) NOT NULL,
    publish_date TIMESTAMP,
    author_id INT UNSIGNED,
    CONSTRAINT FK_AUTHOR FOREIGN KEY (author_id) REFERENCES authors(id)
    )"; 
echo $conn->query($sql)===TRUE ? "Table books created successfully <br>" : "Error creating table : " . $conn->error . "<br>"; 

// Adding foreign key to authors table
$sql = "ALTER TABLE authors ADD CONSTRAINT FK_AUTHOR FOREIGN KEY (author_id) REFERENCES authors(id)";

// // Insert into author
$sql = "INSERT INTO authors (first_name, last_name)
VALUES ('Brittney', 'Sahin'), ('Kelly', 'Collins'), ('Erin', 'Mallon')";
echo $conn->query($sql)===TRUE ? "Authors inserted successfully <br>" : "Error inserting data: " . $conn->error . "<br>"; 

// Insert into books
$sql = "INSERT INTO books (book_name, author_id, publish_date)
VALUES ('The Final Hour', '1', '2021-01-01 00:00:01'),
        ('One Hundred Mistakes', '2', '2021-01-20 00:00:01'),
        ('Lovebug', '3', '2021-01-14 00:00:01')";
echo $conn->query($sql)===TRUE ? "Books inserted successfully <br>" : "Error inserting data: " . $conn->error . "<br>"; 


// Select last publish book on the month of January 2021
$sql = "SELECT book_name, first_name, last_name, publish_date FROM books,authors 
WHERE publish_date BETWEEN '2021-01-01' AND '2021-01-31'
ORDER BY publish_date  DESC LIMIT 1";
$output = $conn->query($sql);

echo "<hr>";
// Display output
while ($row = mysqli_fetch_array($output)) {
  echo "Last published book of January 2021: <br><strong>{$row['book_name']}</strong> <em>by {$row['first_name']} {$row['last_name']} </em> ({$row['publish_date']})";
}

// Close connection
$conn->close();

?> 
