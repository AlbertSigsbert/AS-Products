<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM products ORDER BY created_at DESC');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


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
        <h1 class="text-center my-4">AS Products</h1>

        <p>
            <a href="create.php" class="btn btn-secondary">Create Product</a>
        </p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $key => $product) { ?>
                <tr>
                    <th scope="row"><?php echo $product['id'] ?></th>
                    <td>
                        <img src="<?php echo $product['image'] ?>" class="thumbnail"/>
                    </td>
                    <td><?php echo $product['title'] ?></td>
                    <td><?php echo $product['price'] ?></td>
                    <td><?php echo $product['created_at'] ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary">Edit</button>
                        <button type="button" class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </body>

</html>