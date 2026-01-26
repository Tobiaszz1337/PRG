<?php
require_once "Student.php";

$student = new Student("Jan Novák", "jan.novak@email.cz");
$student->save();

$loadedStudent = Student::find(1);
if ($loadedStudent) {
    echo "Načten: {$loadedStudent->name} - {$loadedStudent->email}<br>";
}

if ($loadedStudent) {
    $loadedStudent->delete();
    echo "Student smazán.";
}
