<?php

	if (isset($_POST['submit'])) 
	{
        include('../includes/header.php');

        $id = $_POST['id'];
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$category = $_POST['category'];
        $url = "edit.php?id=$id";

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
            $paramList = [$id];
            $sql = "SELECT * FROM $plural WHERE id = ?";
            $result = $obj->executeSQL($sql, $paramList, true);
            if($result == '' || empty($result))
            {
                $_SESSION['error'] = "Something went wrong.";
                header('location: index.php'); die();
            }
            else
            {
                $row = $result[0];

                if(($row['image'] != '') && $_FILES['img']['size'] == 0)
                {
                    $imageFileName = $row['image'];
                }
                else
                {
                    if($row['image'] != '')
                    {
                        $path = "../uploads/$plural/" . $row['image'];
                        unlink($path);
                    }
                    // Upload Image
    				$imageFileName = $obj->uploadImage($_FILES['img'], "../uploads/$plural/", $singular);
                }
            
                // Update into the database
                $date = date('Y-m-d H:i:s');
                $sqlUpdate = "UPDATE $plural SET name = ?, quantity = ?, description = ?, category_id = ?, image = ?, updated_at = '$date' WHERE id = ?";
                $paramList = [$name, $quantity, $description, $category, $imageFileName, $id];
                $result = $obj->executeSQL($sqlUpdate, $paramList);

                if ($result["queryExecuted"]) 
                {
                    $_SESSION['success'] = ucwords($singular) . " updated successfully.";
                    header('location: index.php'); die();
                } 
                else 
                {
                    $_SESSION['error'] = "Something went wrong.";
                    header('location: index.php'); die();
                }
            }
		}
		header('location: '. $url); die();
	}
	else
	{
		header('location: index.php'); die();
	}

?>