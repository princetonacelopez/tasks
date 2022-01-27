<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1</title>
</head>
<body>
    <h1>Task 1</h1>
    <p>Output: </p>
    <?php
    class JSONParser
    {
        private $data;
        public function __construct($data)
        {
            $this->data = $data;
        }
        public function parser() : array
        {
            $jsonIterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator(json_decode($this->data, true)),
                RecursiveIteratorIterator::SELF_FIRST
            );

            $toArray = iterator_to_array($jsonIterator);

            return $toArray;
        }
        public function __destruct()
        {
            echo "<pre>";
            print_r($this->parser());
        }
    }
    $data = file_get_contents("data.json");
    $output = new JSONParser($data);
    ?>
</body>
</html>