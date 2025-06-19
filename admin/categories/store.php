<?php

	if (isset($_POST['submit'])) 
	{
		include('../includes/header.php');

		$name = $_POST['name'];

		// Data validation
		if (empty($name)) 
		{
			$_SESSION['error'] = "Please fill all fields.";
		}  
		else 
		{	
			// Upload Image
			$imageFileName = $obj->uploadImage($_FILES['img'], "../uploads/$plural/", $singular);

			// Insert into the database
			$sqlInsert = "INSERT INTO $plural (name, image) VALUES (?,?)";
			$paramList = [$name, $imageFileName];
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