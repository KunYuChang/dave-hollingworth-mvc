<?php

$dsn = "mysql:host=localhost;dbname=product_db;charset=utf8;port=3306";

$pdo = new PDO($dsn, "root", "", [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$stmt = $pdo->query("SELECT * FROM product");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Products</title>
</head>

<body>

	<h1>Products</h1>

	<?php foreach ($products as $product) : ?>
		<h2><?= htmlspecialchars($product['name']) ?></h2>
		<p><?= htmlspecialchars($product['description']) ?></p>
	<?php endforeach; ?>

</body>

</html>