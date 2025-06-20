<?php

if(!isset($_GET['id']) || $_GET['id'] == '')
{
    header("location: index.php"); die();
}

include('../includes/header.php');

$id = $_GET['id'];
        
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
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit <?php echo ucwords($singular); ?></title>
    <?php include('../includes/head-contents.php'); ?>
</head>

<body>

    <?php include('../includes/admin-navbar.php'); ?>
    <?php include('../includes/admin-sidebar.php'); ?>
    <div class="container my-4">
        <div class="row px-2">
            <div class="col-6">
                <h2 class="text-danger fw-bold">Edit <?php echo ucwords($singular); ?></h2>
            </div>
            <div class="col-6 text-end">
                <div class="btn-group" role="group" aria-label="Basic outlined example">
                    <a href="index.php" type="button" class="btn btn-sm btn-outline-primary"><?php echo ucwords($plural); ?></a>
                    <a href="create.php" type="button" class="btn btn-sm btn-outline-secondary">Create</a>
                    <a href="blocked.php" type="button" class="btn btn-sm btn-outline-danger">Blocked</a>
                </div>
            </div>
        </div>
        <hr class="text-danger opacity-100 my-0">
    </div>

    <?php include('../../includes/messages.php'); ?>

    <div class="container my-5 px-4 py-1">
        <form class="p-4 p-md-5 border rounded-3 bg-white box needs-validation" onsubmit="return validateForm()" novalidate action="update.php" method="POST" enctype="multipart/form-data">
            <h4 class="fw-bold lh-1 mb-5">Edit <?php echo ucwords($singular); ?></h4>
            <div class="row">
                <div class="col-md-3 text-center">
                    <?php 
                        if($row['image'] != '')
                        { 
                            $img = "../uploads/$plural/" . $row['image'];
                        }
                        else
                        {
                            $img = "../../images/placeholder.png";
                        }
                    ?>
                    <img src="<?php echo $img; ?>" class="img img-fluid shadow rounded mb-4 entityImage" id="img">
                    <input type="file" name="img" accept="image/x-png,image/jpeg" id="imageUpload" class="form-control mb-3">
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Only JPG and PNG images are allowed. File size must be less than 0.5 MB.</div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2 d-none" id="clearImage">Clear Image</button>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="hidden" class="form-control" name="id" value="<?php echo $row['id'] ?>" required>
                                <input type="name" class="form-control" name="name" value="<?php echo $row['name'] ?>" placeholder="John Doe">
                                <label>Name</label>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control" name="quantity" placeholder="10" min="0" value="<?php echo $row['quantity'] ?>" required>
                                <label>Quantity <span class="text-danger">*</span></label>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <?php 
                                $paramList = [];
                                $sql = "SELECT * FROM categories ORDER BY id DESC";
                                $categories = $obj->executeSQL($sql, $paramList, true);
                                ?>
                                <select name="category" class="form-control" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <?php foreach($categories as $category) { ?>
                                        <option value="<?php echo $category['id'] ?>" <?php echo ($category['id'] == $row['category_id'] ? "selected" : "") ?>><?php echo $category['name'] ?></option>
                                    <?php } ?>
                                </select>
                                <label>Category <span class="text-danger">*</span></label>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <textarea name="description" rows="4" class="form-control h-100" required><?php echo $row['description'] ?></textarea>
                                <label>Description <span class="text-danger">*</span></label>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input type="submit" class="w-25 mx-auto d-block btn btn-lg btn-danger mt-4" name="submit" value="Update">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <?php include('../../includes/footer.php'); ?>
    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/toggle-password.js"></script>
    <script src="../js/setDefaultDob.js"></script>
    <script src="../../js/display-clear-image.js"></script>
</body>

</html>