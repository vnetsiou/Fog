<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetDirectory = 'uploads/';
    $targetFile = $targetDirectory . basename($_FILES['image']['name']);

	if(basename($_FILES['image']['name']) == ""){
		echo 'No file specified.';

	}else{

		// Check if file already exists
		if (file_exists($targetFile)) {
			echo 'File already exists.';
		} else {
			// Move uploaded file to the target directory
			if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
				echo '1';
			} else {
				echo 'Error uploading file.';
			}
		}
	}

} else {
    echo 'Invalid request.';
}
?>