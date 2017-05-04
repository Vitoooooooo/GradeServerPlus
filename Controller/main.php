<?php
  session_start();
  error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Grade Server Plus</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php
      $username = $_SESSION['username'];
      echo "Welcome, <a href='settings.html'>$username</a>!";
    ?>
    <img src="../View/sampleIcon.jpg" alt="Imagine a Hulk here.." style="width:50px;height:50px;">
    <a href="logout.php?logout"></span>Log Out</a>
    <br />
    @Jerry please update this image after you create user table in the database.
    
    
    <h1>Your grades</h1>
    @Shanshi please update this table after you create grade tables in the database. You need to create those tables according to Jerry's users table.
    <br />
    
      
    <?php
      require_once 'dbconnect.php';

      // Get userId
      $userNameResult=mysql_query("SELECT userId FROM users WHERE name='$username'");
      $userNameResultRow=mysql_fetch_array($userNameResult);

      $_SESSION['userId'] = $userNameResultRow['userId'];
      $userId = $userNameResultRow['userId'];

      // Get courseId
      $courseIdResult=mysql_query("SELECT courseId FROM user_courses WHERE userId='$userId'");
      while ($courseIdResultRow = mysql_fetch_array($courseIdResult)) {
          $courseId = $courseIdResultRow['courseId'];
          $totalScore = 0;
          // Get course name
          $courseNameResult=mysql_query("SELECT name FROM courses WHERE courseId='$courseId'");  
          $courseNameResultRow = mysql_fetch_array($courseNameResult);

          // Display course name and create table
          echo "<h4>".$courseNameResultRow['name']."</h4>";
          echo "<table border='1'>";
          echo "<tr><th>assignment</th><th>grade</th><th>Out Of</th><th>weight(%)</th><th></th></tr>";


          // Get all assginmentsIds for this course
          $assignmentIdResult=mysql_query("SELECT assignmentId FROM course_assignments WHERE courseId='$courseId'");
          while ($assignmentIdResultRow = mysql_fetch_array($assignmentIdResult)) {
            
            $assignmentId = $assignmentIdResultRow['assignmentId'];
            
            // Get grade for this assignment
            $gradeResult=mysql_query("SELECT score FROM grades WHERE assignmentId='$assignmentId' And userId='$userId'");
            $score = mysql_fetch_array($gradeResult)['score'];
            if ($score == null) {
              $score = 0;
            }

            // Get maxScore and weight for this assignment
            $maxScoreWeightResult=mysql_query("SELECT max_score, weight, name FROM assignments WHERE assignmentId='$assignmentId'");
            $maxScoreWeightResultRow = mysql_fetch_array($maxScoreWeightResult);
            $maxScore = $maxScoreWeightResultRow['max_score'];
            $weight = $maxScoreWeightResultRow['weight'];
            $name = $maxScoreWeightResultRow['name'];
            // Display assgnment details
            echo "<tr><td>$assignmentId</td><td>"."<span id=\"lblName\" class=\"editable\">$score</span>"."</td><td>".$maxScore."</td><td>".$weight."</td><td><button>submit regrade request</button></td></tr>";
            $totalScore += $score * $weight / 100.0;
            $whatifTotal += $score * $weight / 100.0;
          }
          echo "</table>";
          echo " You total score: $totalScore<br>";
          echo "You total score after applying what-if scores: $whatifTotal";
          echo "<button>clear all what-if scores</button>";
      }
    ?>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
  </body>
</html>