<?php
// Include the header file
include 'includes/header.php';

// Initialize error and success messages
$error = '';
$success = '';

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form inputs
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = $_FILES['image'];

    // Validate required fields
    if (empty($title) || empty($description)) {
        $error = 'Please fill in all fields';
    } else {
        // Define the target directory for image uploads
        $target_dir = 'assets/images/';

        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Generate a unique name for the uploaded file
        $file = $image['name'];
        $new_name = uniqid() . $file;

        // Set the target file path
        $target_file = $target_dir . $new_name;

        // Check if the file size exceeds the limit (5MB)
        if ($image['size'] > 5000000) {
            $error = 'File size is too large. Max size is 5MB';
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($image['tmp_name'], $target_file)) {
                // Insert image details into the database
                $sql = "INSERT INTO images (title, description, filename) VALUES (:title, :description, :filename)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':title' => $title,
                    ':description' => $description,
                    ':filename' => $new_name
                ]);

                // Set success message and clear form inputs
                $success = "Image uploaded successfully";
                $title = "";
                $description = "";
            } else {
                // Set error message if file upload fails
                $error = "Error uploading image";
            }
        }
    }
}


?>


<div class="my-4">
    <h1>Photo Gallery</h1>
</div>

<!-- Display success message if available -->
<?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success; // Output the success mes</div>sage ?>
    </div>
<?php endif; ?>

<!-- Display error message if available -->
<?php if ($error): ?>
    <div class="alert alert-danger" role="alert">
    </div>    <?php echo $error; // Output the error message ?>
    </div>
<?php endif; ?>


<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control" name="description"> </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image</label>
                        <input type="file" class="form-control" name="image" />
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Photo</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php 
// Include the footer file
include 'includes/footer.php';
?>