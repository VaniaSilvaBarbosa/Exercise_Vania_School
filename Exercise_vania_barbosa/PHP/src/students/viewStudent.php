<?php
    // Check if 'id' is present in the GET request
    if(isset($_GET['id'])){
        // Get the 'id' from the GET request
        $id = $_GET['id'];
        // Database connection
        require "../connection_db.php";
        // Check if the database connection was successful
        if($db){
            // Query to fetch the student data
            $query = "SELECT * FROM students WHERE id = $id";
            // Execute the query and store the result
            $result = mysqli_query($db, $query);
            // Fetch the student data
            $student = mysqli_fetch_assoc($result);
            // Query to fetch subjects related to the student
            $query2 = "SELECT * FROM student_subjects WHERE id_student = $id";
            // Execute the query and store the result
            $result2 = mysqli_query($db, $query2);
            // Fetch the subject data
            $student_subject = mysqli_fetch_all($result2, MYSQLI_ASSOC);
            // Initialize arrays for subjects
            if(isset($_POST['btn_delete'])){
                // Get the 'id' from the POST request
                $id = $_POST['id'];
                // Query to delete the student
                $query = "DELETE FROM students WHERE id=$id";
                // Execute the query and store the result
                $result = mysqli_query($db, $query);
                // Check if the query was successful
                if(!$result){
                    // Display an error message
                    echo "<script>alert('Something went wrong')</script>";
                }else{
                    // Redirect to the 'index.php' page after deleting the student
                    header('Location: http://localhost:8000/index.php');
                    echo "<script>alert('Student deleted successfully')</script>";
                }
            }
        }
    }
?>
<!-- Include JavaScript for confirming deletion -->
<script>
    function confirmDeletion() {
        return confirm("Are you sure you want to delete this student?");
    }
</script>
<!-- Include the start of the HTML document -->
<?php require "start_html.html"; ?>
    <!-- Include the header section of the HTML document -->
    <?php require "header.html"; ?> 
    <!-- Start a section for displaying the student's information -->
    <section class="student-info-section">
        <div>
            <!-- Link to return to the 'students.php' page -->
            <a href="..\index.php">Return</a>
            <!-- Display the student's name -->
            <div class="student-info-section--div-buttons">
                <!-- Display the edit button-->
                <form method="post" action="editStudent.php">
                    <!-- Pass the 'id' as a hidden input -->
                    <input type="hidden" name="id" value="<?= $student['id'] ?>">
                    <!-- Display the edit button -->
                    <button type="submit" name="btn_edit" id="btn_edit">
                        <i class="fa-solid fa-pen-to-square" style="color: white;"></i>
                    </button>
                </form>
                <!-- Display the delete button-->
                <form method="post" onsubmit="return confirmDeletion();">
                    <!-- Pass the 'id' as a hidden input -->
                    <input type="hidden" name="id" value="<?= $student['id'] ?>">
                    <!-- Display the delete button -->
                    <button type="submit" name="btn_delete" id="btn_delete">
                        <i class="fa-solid fa-trash" style="color: white;"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- Display the student's name and picture -->
        <div class="student-info-section--div-first">
            <!-- Display the student's picture (put one for everyone) -->
            <img src="https://media.istockphoto.com/id/1316420668/vector/user-icon-human-person-symbol-social-profile-icon-avatar-login-sign-web-user-symbol.jpg?s=612x612&w=0&k=20&c=AhqW2ssX8EeI2IYFm6-ASQ7rfeBWfrFFV4E87SaFhJE=" alt="student picture">
            <!-- Display the student's name -->
            <h2><?= $student['name'].' '. $student['last_name']?></h2>    
        </div>
        <!-- Display the student's information -->
        <div class="student-info-section--div-second">
            <!-- Student's name, last name, date of birth, email and subjects and semesters -->
            <p><b>Name:</b> <?= $student['name'] ?></p>
            <p><b>Last name:</b> <?= $student['last_name'] ?></p>
            <p><b>Date of birth:</b> <?= $student['date_of_birth'] ?></p>
            <p><b>Email:</b> <?= $student['email'] ?></p>
            <h3>Subjects and Semesters</h3>
            <!-- Table with the student's subjects and semesters -->
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the student's subjects and semesters -->
                    <?php foreach($student_subject as $subject): ?>
                        <tr>
                            <td><?= $subject['subject'] ?></td>
                            <td><?= $subject['semester'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!--Include the footer section of the HTML document -->
    <?php require "footer.html"; ?>
<!-- Include the end of the HTML document -->
<?php require "end_html.html"; ?>