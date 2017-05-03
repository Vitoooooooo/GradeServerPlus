<?php

/**
 * Using Object-Oriented Approach as Project's requirement
 *
 */
class Student
{
    var $name;
    var $class;
    var $UID;
    var $grades;   // grades as an array, assignment->grade

    function __construct($name, $class, $UID, $grades) {
        $this->name = $name;
        $this->class = $class;
        $this->UID = $UID;
        $this->grades = $grades;
    }

    function getName() {
        return $this->name;
    }

    function getClass() {
        return $this->class;
    }

    function getUID() {
        return $this->UID;
    }

    function getGrades() {
        return $this->grades;
    }
}