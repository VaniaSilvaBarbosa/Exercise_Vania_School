<?php
    // Create a new connection to the MySQL database
    require "connection_db.php";
    // Check if the connection was successful
    if($db){
        //Select all records from the 'students' table, ordered by 'id' in descending order (see last posted)
        $query = "SELECT * FROM students ORDER BY id DESC";
        //Execute the query and store the result
        $result = mysqli_query($db, $query);
        //Fetch all results as an associative array
        $students = mysqli_fetch_all($result, MYSQLI_ASSOC);

        //Select all records from the 'student_subjects' table
        $query = "SELECT * FROM student_subjects";
        //Execute the query and store the result
        $result = mysqli_query($db, $query);
        //Fetch all results as an associative array
        $student_subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
        //Close the database connection
        mysqli_close($db);
    }else{
        //If the connection was not successful, display an error message
        echo "Error connecting to database";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda+SC:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&display=swap" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--link to the style -->
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Include the header section of the HTML document -->
    <?php require "students/header.html"; ?>
     <!-- Start a section for the students table -->
    <section class="students-table-section">
        <!-- Create a container for the title and a button to add a new student -->
        <div class="students-table-section--div">
            <h2>All Students</h2>
            <a href="students\addStudent.php">Add new student</a>
        </div>
        <!-- Start a form for the search bar -->
        <form class="search-bar--form">
            <!-- Create a container for the search bar -->
            <div class="search-bar">
                <!-- Input field for searching students by name -->
                <input type="text" name="search" id="search-input" placeholder="Search for a name...">
            </div>
        </form>
        <!-- Create a table for displaying the students -->
        <table class="students-table-section--table">
            <!-- Create the table header -->
            <thead>
                <!-- Start a row in the table header -->
                <tr>
                    <th>Name</th>
                    <th>Last name</th>
                    <th>Date of birth</th>
                    <th>Email</th>
                    <th>Subjects</th>
                </tr>
            </thead>
            <!-- Create the table body -->
            <tbody>
                <!-- Goes over each student in the $students array -->
                <?php foreach($students as $student):?>
                <!-- Start a row in the table header -->
                <tr>
                    <td><?= $student['name'] ?></td>
                    <td><?= $student['last_name'] ?></td>
                    <td><?= $student['date_of_birth'] ?></td>
                    <td><?= $student['email'] ?></td>
                    <?php 
                        // Collect all subjects and semesters for this student
                        $subjects = [];
                        $semesters = [];
                        // Loop over all student_subjects
                        foreach($student_subjects as $student_subject) {
                            // Check if this student is the current student
                            if($student_subject['id_student'] == $student['id']) {
                                // Add subjects and semesters to arrays
                                $subjects[] = $student_subject['subject'];
                            }
                        }
                        // Convert arrays to comma-separated strings
                        $subjects_display = implode(", ", $subjects);
                    ?>
                    <!-- Display the student's subjects as a comma-separated list -->
                    <td><?= $subjects_display ?></td>
                    <!-- Create a cell for buttons -->
                    <td id="td_buttons">
                        <!-- Link to view details of the current student -->
                        <a href="students\viewStudent.php?id=<?= $student['id'] ?>">
                            <i class="fa-solid fa-eye" style="color: white;"></i>
                        </a>
                    </td>
                </tr>
                 <!-- End the loop over students -->
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
    <!-- Include the footer section of the HTML document -->
    <?php require "students/footer.html"; ?>
    <!-- Include JavaScript for search bar functionality -->
    <script src="script/searchBar.js"></script>  
</body>
</html>