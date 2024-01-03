<?php
require "model.php";
$model = new Model;
$products = $model->getData();

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