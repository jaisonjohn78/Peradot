<?php
include '../../config.php';
include '../../function.php';
$id = $_SESSION['id'];

$today = date("F j, Y, g:i a"); 
$user_sql = mysqli_query($con,"SELECT * FROM users WHERE id = $id");
$user_row=mysqli_fetch_assoc($user_sql);

$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $con->query("INSERT into deposite (user_id,image_path,timestamp) VALUES ('$id','".$fileName."','$today')");
            if($insert){
                alert("The file ".$fileName. " has been uploaded successfully.");
                ?>
                <script>
                    window.location.href='payment.php';
                </script>
                <?php
            }else{
                alert("File upload failed, please try again.");
                ?>
                <script>
                    window.location.href='payment.php';
                </script>
                <?php
            } 
        }else{
            alert("Sorry, there was an error uploading your file.");
            ?>
                <script>
                    window.location.href='payment.php';
                </script>
                <?php
        }
    }else{
        alert('Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.');
        ?>
                <script>
                    window.location.href='payment.php';
                </script>
                <?php
    }
}else{
    alert('Please select a file to upload.');
    ?>
                <script>
                    window.location.href='payment.php';
                </script>
                <?php
}

// Display status message
// echo $statusMsg;
?>