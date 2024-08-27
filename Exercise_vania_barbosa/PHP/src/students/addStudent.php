<?php
    /* Connect to the database*/
    require "../connection_db.php";
    /*Check if the database connection was successful*/
    if($db){
        /*Check if the form was submitted*/
        if (isset($_POST['btn'])){
            /*Get the values from the form and sanitize them*/
            $name = strip_tags(trim($_POST['name']));
            $last_name = strip_tags(trim($_POST['last_name']));
            $date_of_birth = $_POST['date_of_birth'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            /*Check for errors in the form values*/
            $errors = [];
            /*Check if the name is empty and if it is, add an error message to the errors array*/
            if(empty($name)){
                $errors['name'] = "<p style='color: red' >Name is required</p>";
            }
            /* Check if the last name is empty and if it is, add an error message to the errors array*/
            if(empty($last_name)){
                $errors['last_name'] = "<p style='color: red' >Last name is required</p>";
            }
            /* Check if the date of birth is empty and if it is, add an error message to the errors array*/
            if(empty($date_of_birth)){
                $errors['date_of_birth'] = "<p style='color: red' >Date of birth is required</p>";
            }
            /*Check if the email is empty and if it is, add an error message to the errors array*/
            if(empty($email)){
                $errors['email'] = "<p style='color: red' >Email is required</p>";
            }
            /*Check if the email is valid and if it is not, add an error message to the errors array*/
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['email'] = "<p style='color: red' >Email is not valid</p>";
            }
            /*Check if there are no errors and if there are not, insert the data in the database*/
            if(count($errors) == 0){
                //Insert the data in the database
                $query = "INSERT INTO students (name, last_name, date_of_birth, email) VALUES ('$name', '$last_name', '$date_of_birth', '$email')";
                // Execute the SQL query and store the result 
                $result = mysqli_query($db, $query);
                //Execute the query and check if it was successful or not
                if($result){
                    // Get the ID of the newly inserted student
                    $student_id = mysqli_insert_id($db);
                    
                    //If the first semester is selected
                    if(isset($_POST['firstSemester'])){
                        //Loop through the subjects and insert them into the database
                        foreach($_POST['firstSemester'] as $subject){
                            //Insert the data in the database
                            $query = "INSERT INTO student_subjects (id_student, subject, semester) VALUES ($student_id, '$subject', 1)";
                            // Execute the SQL query and store the result
                            mysqli_query($db, $query);
                        }
                    }
                    //If the second semester is selected
                    if(isset($_POST['secondSemester'])){
                        //Loop through the subjects and insert them into the database
                        foreach($_POST['secondSemester'] as $subject){
                            //Insert the data in the database
                            $query = "INSERT INTO student_subjects (id_student, subject, semester) VALUES ($student_id, '$subject',2)";
                            // Execute the SQL query and store the result
                            mysqli_query($db, $query);
                        }
                    }
                    // Display success message and redirect to students.php
                    header('Location: http://localhost:8000/index.php');
                    echo "<script>alert('Student created successfully!');</script>";
                    // Stop further execution of the script
                    exit();
                }else{
                    echo "Something went wrong. Please try again.";
                }
            }
        }
    }
?>
<script>
    // Function to show an alert message when creating a student
    function confirmCreation() {
        return confirm("Are you sure you want to create this student?");
    }
</script>
<!-- Include the start of the HTML document -->
<?php require "start_html.html"; ?>
    <!-- Include the header section of the HTML document -->
    <?php require "header.html"; ?>
     <!-- Start a section for creating a new student -->
    <section class="student-creation-section">
        <!-- Link to return to the students list page -->
        <a href="../index.php">Return</a>
        <h2>Create a new student</h2>
        <!--Form to input new student data-->
        <form method="POST" onsubmit="return confirmCreation();">
            <!--Input for student name-->
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required>
            <!--Input for student last name-->
            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" required>
            <!--Input for student date of birth-->
            <label for="date_of_birth">Date of birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" required>
            <!--Input for student email-->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <!--Form section to select the subjects for the first semester-->
            <h3>First Semester:</h3>
            <div>
                <!--Input for first semester subjects checkboxes-->
                <label for="mathematics1">Mathematics</label>
                <input type="checkbox" name="firstSemester[]" value="mathematics" id="mathematics1">
                <label for="english1">English</label>
                <input type="checkbox" name="firstSemester[]" value="english" id="english1">
                <label for="science1">Science</label>
                <input type="checkbox" name="firstSemester[]" value="science" id="science1">
                <label for="art1">Art</label>
                <input type="checkbox" name="firstSemester[]" value="art" id="art1">
            </div>
            <!--Form section to select the subjects for the second semester-->
            <h3>Second Semester:</h3>
            <div>
                <!--Input for second semester subjects checkboxes-->
                <label for="mathematics2">Mathematics</label>
                <input type="checkbox" name="secondSemester[]" value="mathematics" id="mathematics2">
                <label for="english2">English</label>
                <input type="checkbox" name="secondSemester[]" value="english" id="english2">
                <label for="science2">Science</label>
                <input type="checkbox" name="secondSemester[]" value="science" id="science2">
                <label for="art2">Art</label>
                <input type="checkbox" name="secondSemester[]" value="art" id="art2">
            </div>
            <!--Submit button to add new student-->
            <input type="submit" name="btn" id="btn_create_student" value="Add student">
        </form>
    </section>
    <!-- Include the footer section of the HTML document -->
    <?php require "footer.html"; ?>
<!-- Include the end of the HTML document -->
<?php require "end_html.html"; ?>
