<?php

/*
* 1
Create a database and name it "school"
Inside it, create a table "students" with the following fields:
    id (int)
    name (varchar)
    last_name (varchar)
    date_of_birth (date)
    email (varchar)

    another table named "student_subjects"
    fields:
    id_student (int)
    subject (enum ['mathematics', 'english', 'science', 'art'])
    semester (int)

    A student can take more than 1 subject per semester (there are 2 semesters in a year)
*/

/*
* 2
Create a form to add students in the table 'students'.
All fields are required from student table.
If there is a field not fulfilled, display error messages in red

Add 2 checkbox sections, once for each semester, with the subjects ['mathematics', 'english', 'science', 'art'] as options in each (not mandatory when creating student) for the first and second semester

*Each student will be added to the created database. If subjects were selected, add to table student_subjects.

A success message will be displayed if no errors.
*/

/*
* 3
Create a page to display all students with the subjects they are taking.

Add a search bar, when typing name or last name, filter accordingly without reloading the page.

We should be able to find all the students with their respective information.

For each student, add a button 'more' that will redirect to a page with that student information

*/

/*
* 4
On the individual student page, add a 'modify' button, that will redirect to a form where we can update that student information and subjects

*/
