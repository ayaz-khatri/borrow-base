<?php

	if (isset($_POST['submit'])) 
	{
		include('../includes/header.php');

		$name = $_POST['name'];
		$quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$category = $_POST['category'];

		// Data validation
		if (empty($name) || empty($quantity) || empty($description) || empty($category)) 
		{
			$_SESSION['error'] = "Please fill all fields.";
		} 
		else if (!is_numeric($quantity) || $quantity < 0) {
			$_SESSION['error'] = "Quantity must be a positive number.";
		} 
		else 
		{	
			// Upload Image
			$imageFileName = $obj->uploadImage($_FILES['img'], "../uploads/$plural/", $singular);

			// Insert into the database
			$sqlInsert = "INSERT INTO $plural (name, quantity, description, category_id, image) VALUES (?,?,?,?,?)";
			$paramList = [$name, $quantity, $description, $category, $imageFileName];
			$result = $obj->executeSQL($sqlInsert, $paramList);

			if ($result["queryExecuted"]) 
			{
				$_SESSION['success'] = ucwords($singular) ." created successfully.";
				header('location: index.php'); die();
			} 
			else 
			{
				$_SESSION['error'] = "Something went wrong.";
			}
		}
		$_SESSION['formData'] = $_POST;
		header('location: create.php'); die();
	}
	else
	{
		$_SESSION['formData'] = $_POST;
		header('location: create.php'); die();
	}
?>