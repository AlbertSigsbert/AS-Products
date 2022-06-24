<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$title = '';
$price = '';
$description = '';

//Check if method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');


    if (!$title) {
        $errors[] = 'Product Title is required';
    }
    if (!$price) {
        $errors[] = 'Product Price is required';
    }

     if(!is_dir('images')){
        mkdir('images');
     }

    if (empty($errors)) {

        $imagePath = '';
        //Uploading an Image
        $image = $_FILES['image'] ?? null;

        if ($image && $image['tmp_name']) {
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        //Prepare statement using named params
        $statement = $pdo->prepare("INSERT INTO products (title,description,price,image,created_at) VALUES (:title,:description,:price,:image,:date)");

        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':date', $date);

        $statement->execute();

        header('Location: index.php');
    }
}

 function randomString($n){
    $characters ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str = '';

    for ($i=0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1);
        $str .=$characters[$index];
    }


    return $str;
  }

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AS Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" >
</head>
 <body>
    <div class="container">
        <h1 class="text-center my-4">Create New Product</h1>

        <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) : ?>
            <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label" for="title">Product Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Product Description</label>
                <textarea class="form-control" name="description">
                   <?php echo $description ?>
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="price">Product Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $price ?>">
            </div>

            <div class="mb-3">
                <label class="form-label" for="image">Product Image</label>
                <br />
                <input type="file" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </body>

</html>