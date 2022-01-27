<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 3</title>
</head>
<body>
    <form method="GET">
        <h1>Task 3</h1>
        <h2>Search News by ID</h2>
        <input type="text" name="x"/>
        <input type="submit" value="Search"/>
    </form>
</body>
</html>

<?php
// Server info
define("SERVERNAME","localhost"); 
define("USERNAME","root"); 
define("PASSWORD","AA_aa_11");
define("DATABASE","db_news");

// Create connection
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

//Check connection
if(mysqli_connect_errno())
{     
    die("Connection failed: " . $conn->connect_error);
}

// Create db_news database
$sql = "CREATE DATABASE IF NOT EXISTS db_news";
if($conn->query($sql)===false)
{
    die("Error creating database : " . $conn->error); 
}

// Create news table
$sql = "CREATE TABLE IF NOT EXISTS news (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    short_description VARCHAR(255) NOT NULL,
    article TEXT NOT NULL
    )";
if($conn->query($sql)===false)
{
    die("Error creating database : " . $conn->error); 
}

// Insert into news table
// $sql = "INSERT INTO news (short_description, article)
// VALUES ('desc1', 'text1'), ('desc2', 'text2')";


// Using prepared statements in inserting new data to the news table to protect from SQL injections
$preparedquery = $conn->prepare("INSERT INTO news (short_description, article) VALUES (?,?)");
$preparedquery->bind_param("ss", $short_desc, $article);

$short_desc = "desc1";
$article = "text1";

$preparedquery->execute();

$short_desc = "desc2";
$article = "text2";

$preparedquery->execute();

//prevent sql injection
$id = $_GET['x'];
$id = stripslashes($id);
$id = mysqli_real_escape_string($conn, $id);

// SQL Injection that will display all records from the table
//$query = "SELECT short_description, article FROM news WHERE id='".$_GET['x'] . "' OR 1=1";

// Select news by id entered from the HTML input tag
$query = "SELECT short_description, article FROM news WHERE id='".$_GET['x'] . "'";
$res=mysqli_query($conn,$query);

// Check if query have results available
if ($res && mysqli_num_rows($res)>0)
{
    // Display records from the query
    while ($row=mysqli_fetch_assoc($res)) 
    {
        echo $row['short_description'];
        echo $row['article'];
    }
 } else 
{
    // Return 404 header
    if (!empty($_GET['x']) || isset($_GET['x']) || intval($_GET['x'] > 2))
    {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $file = '404.php';
        header("Location: http://$host$uri/$file");
        exit;
    }
}

// Close prepared statement
$preparedquery->close();

// Close connection
$conn->close();
?>

