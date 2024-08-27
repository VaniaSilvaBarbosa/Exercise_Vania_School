<?php
    /* Connect to the database*/
    require "../connection_db.php";
    /*Check if the database connection was successful*/
    if($db){
        /*Get the student id from the URL*/
        $id = $_POST['id'];
        /*Get the student data from the database*/
        $query = "SELECT * FROM students WHERE id = $id";
        //Execute the query and store the result
        $result = mysqli_query($db, $query);
        //Fetch the student data
        $student = mysqli_fetch_assoc($result);
        // Query to fetch subjects related to the student
        $query2 = "SELECT * FROM student_subjects WHERE id_student = $id";
        //Execute the query and store the result
        $result2 = mysqli_query($db, $query2);
        //Fetch the student data
        $student_subject = mysqli_fetch_all($result2, MYSQLI_ASSOC);
        // Initialize arrays for subjects
        $firstSemesterSubjects = [];
        $secondSemesterSubjects = [];
        // Populate arrays based on the student's subjects
        foreach($student_subject as $subject) {
            // Check if the subject belongs to the first or second semester
            if ($subject['semester'] == 1) {
                // Add the subject to the appropriate array
                $firstSemesterSubjects[] = $subject['subject'];
            // Check if the subject belongs to the first or second semester    
            } elseif ($subject['semester'] == 2) {
                // Add the subject to the appropriate array
                $secondSemesterSubjects[] = $subject['subject'];
            }
        }

        /*Check if the form was submitted*/
        if(isset($_POST['btn'])){
            /*Get the form data*/
            $id = $_POST['id'];
            $name = $_POST['name'];
            $last_name = $_POST['last_name'];
            $date_of_birth = $_POST['date_of_birth'];
            $email = $_POST['email'];
            // Update the student data in the database
            $query = "UPDATE students SET name = '$name', last_name = '$last_name', date_of_birth = '$date_of_birth', email = '$email' WHERE id = $id";
            // Execute the query and store the result
            $result = mysqli_query($db, $query);
            // Check if the query was successful
            if ($result) {
                // Delete existing subjects before adding new ones
                $delete_query = "DELETE FROM student_subjects WHERE id_student = $id";
                // Execute the query and store the result
                mysqli_query($db, $delete_query);
                // Insert new subjects
                if (isset($_POST['firstSemester'])) {
                    // Loop through the selected subjects
                    foreach ($_POST['firstSemester'] as $subject) {
                        // Insert the subject into the database
                        $insert_query = "INSERT INTO student_subjects (id_student, subject, semester) VALUES ($id, '$subject', 1)";
                        // Execute the query and store the result
                        mysqli_query($db, $insert_query);
                    }
                }
                // Insert new subjects
                if (isset($_POST['secondSemester'])) {
                    // Loop through the selected subjects
                    foreach ($_POST['secondSemester'] as $subject) {
                        // Insert the subject into the database
                        $insert_query = "INSERT INTO student_subjects (id_student, subject, semester) VALUES ($id, '$subject', 2)";
                        // Execute the query and store the result
                        mysqli_query($db, $insert_query);
                    }
                }
                // Display success message and redirect to students.php
                header('Location: http://localhost:8000/index.php');
                echo "<script>alert('Student modified successfully!');</script>";
            } else {
                // Display error message
                echo "Something went wrong. Please try again.";
            }       
        }
    }
?>
<!-- Include the start of the HTML document -->
<?php require "start_html.html"; ?>
    <!-- Include the header section of the HTML document -->
    <?php require "header.html"; ?>
    <!-- Start a section for modifying a student's information -->
    <section class="student-modify-section">
        <!--Link to go back to the students information page-->
        <a href="../index.php?id=<?= $id ?>">Return</a>
        <h2>Modify student</h2>
        <!--Form to input new student data-->
        <form method="post">
            <!--Pass the 'id' as a hidden input-->
            <input type="hidden" name="id" value="<?= $student['id'] ?>">
            <!--Input for student name-->
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $student['name']?>" required>
            <!--Input for student last name-->
            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" value="<?= $student['last_name']?>" required>
            <!--Input for student date of birth-->
            <label for="date_of_birth">Date of birth</label>
            <input type="date" name="date_of_birth" id="date_of_birth" value="<?= $student['date_of_birth']?>" required>
            <!--Input for student email-->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $student['email']?>" required>
            <!--Form section to select the subjects for the first semester-->
            <h3>First Semester:</h3>
            <div>
                <!--Input for first semester subjects checkboxes-->
                <label for="mathematics1">Mathematics</label>
                <!-- Check if Mathematics is in the list of selected first semester subjects -->
                <?php if (in_array("mathematics", $firstSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="firstSemester[]" value="mathematics" id="mathematics1" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="firstSemester[]" value="mathematics" id="mathematics1">
                <?php endif ?>
                <!-- Check if English is in the list of selected first semester subjects -->
                <label for="english1">English</label>
                <?php if (in_array("english", $firstSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="firstSemester[]" value="english" id="english1" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="firstSemester[]" value="english" id="english1">
                <?php endif ?>
                <!-- Check if Science is in the list of selected first semester subjects -->
                <label for="science1">Science</label>
                <?php if (in_array("science", $firstSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="firstSemester[]" value="science" id="science1" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="firstSemester[]" value="science" id="science1">
                <?php endif ?>
                <!-- Check if Art is in the list of selected first semester subjects -->
                <label for="art1">Art</label>
                <?php if (in_array("art", $firstSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="firstSemester[]" value="art" id="art1" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="firstSemester[]" value="art" id="art1">
                <?php endif ?>
            </div>

            <!--Form section to select the subjects for the second semester-->
            <h3>Second Semester:</h3>
            <div>
                <!--Input for second semester subjects checkboxes-->
                <label for="mathematics2">Mathematics</label>
                <!-- Check if Mathematics is in the list of selected first semester subjects -->
                <?php if (in_array("mathematics", $secondSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="secondSemester[]" value="mathematics" id="mathematics2" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="secondSemester[]" value="mathematics" id="mathematics2">
                <?php endif ?>
                <!-- Check if English is in the list of selected first semester subjects -->
                <label for="english2">English</label>
                <?php if (in_array("english", $secondSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="secondSemester[]" value="english" id="english2" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="secondSemester[]" value="english" id="english2">
                <?php endif ?>
                <!-- Check if Science is in the list of selected first semester subjects -->
                <label for="science2">Science</label>
                <?php if (in_array("science", $secondSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="secondSemester[]" value="science" id="science2" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="secondSemester[]" value="science" id="science2">
                <?php endif ?>
                <!-- Check if Art is in the list of selected first semester subjects --> 
                <label for="art2">Art</label>
                <?php if (in_array("art", $secondSemesterSubjects)): ?>
                    <!--  checkbox is checked -->
                    <input type="checkbox" name="secondSemester[]" value="art" id="art2" checked>
                <?php else: ?>
                    <!-- checkbox is not checked -->
                    <input type="checkbox" name="secondSemester[]" value="art" id="art2">
                <?php endif ?>
            </div>
            <!--Submit button to modify student-->
            <input type="submit" name="btn" id="btn_modify_student" value="Modify">
        </form>
    </section>
    <!-- Include the footer section of the HTML document -->
    <?php require "footer.html"; ?>
<!-- Include the end of the HTML document -->    
<?php require "end_html.html"; ?>