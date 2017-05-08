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

      <link rel="stylesheet" href="mainCSS.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      <!-- Draw a visual graph -->
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
      $divNum = 0;
      $divNum1 = 0;
      $anotherCourseId = null;
      while ($courseIdResultRow = mysql_fetch_array($courseIdResult)) {
          $courseId = $courseIdResultRow['courseId'];
          $totalScore = 0;
          $whatifTotal = 0;
          // Get course name
          $courseNameResult=mysql_query("SELECT name FROM courses WHERE courseId='$courseId'");  
          $courseNameResultRow = mysql_fetch_array($courseNameResult);

          // Display course name and create table
          echo "<h4>".$courseNameResultRow['name']."</h4>";
          echo "<table border='1'>";
          echo "<tr><th>assignment</th><th>grade</th><th>Out Of</th><th>weight(%)</th><th></th></tr>";
          $anotherCourseId = $courseNameResultRow['name'];


          // Get all assginmentsIds for this course
          $assignmentIdResult=mysql_query("SELECT assignmentId FROM course_assignments WHERE courseId='$courseId'");
          while ($assignmentIdResultRow = mysql_fetch_array($assignmentIdResult)) {

            $assignmentId = $assignmentIdResultRow['assignmentId'];

            //Get the score statistics for this assignment;
            $assignmentTotalScore = 0;
            $numInThisAssignment = 0;
            $lowestScore = 101;
            $highestScore = -1;
            $idName = "displayStatistics$divNum";
            $scoreArray = [];
            $grades = mysql_query("SELECT score FROM grades WHERE assignmentID='$assignmentId'");
            while($scoresRow = mysql_fetch_array($grades, MYSQLI_ASSOC)){
                $scores = $scoresRow['score'];
                if($scores == null){
                    $assignmentTotalScore = 0;
                }else{
                    $assignmentTotalScore += $scores;
                }

                if($scores < $lowestScore){
                    $lowestScore = $scores;
                }
                if($scores > $highestScore){
                    $highestScore = $scores;
                }
                $scoreArray[] = $scores;
                $numInThisAssignment += 1;
            }
            $mean = round($assignmentTotalScore / $numInThisAssignment, 2);
            $curStandard = 0;
            for($i = 0; $i<sizeof($scoreArray); $i++){
                $curStandard += pow(($scoreArray[$i]-$mean), 2);
            }
            $standardDeviation = round((sqrt(($curStandard/$numInThisAssignment))), 2);
            echo "<p id='MeanToPass$divNum' style='display: none'>$mean</p>";
            echo "<p id='StdDeviationToPass$divNum' style='display: none'>$standardDeviation</p>";
            echo "<p id='MaxToPass$divNum' style='display: none'>$highestScore</p>";
            echo "<p id='MinToPass$divNum' style='display: none'>$lowestScore</p>";

            //

            //Draw the Pie Chart
            echo "<p id='CourseId$divNum' style='display: none'>$assignmentId</p>";
            //

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
            // Display assignment details
            $whatIfClass = 'whatif'.$assignmentId;
            $whatifScore = $_GET[$whatIfClass];
            if (isset($whatifScore)) {
              $whatifTotal += 1.0 * $whatifScore * $weight / $maxScore;
              $toshow = $whatifScore;
            } else {
              $toshow = $score;
            }
            echo "<tr><td>$name</td><td>"."<label class=\"pull-left\" title=\"click to input what-if scores\">$toshow</label><input class=\"$assignmentId\" type=\"text\" />"."</td><td>".$maxScore."</td><td>".$weight."</td><td id=$idName><input type='button' id='scoreStat' value='Score Statistics' onclick='showScoreStatistics($divNum)'></td></tr><div></div>";
            $totalScore += $score * $weight / $maxScore;
            
            $divNum+=1;
          }
          echo "</table>";
          
          echo "<span id='pieChart$divNum1' style='width: 450px; display: inline-block'></span><br><br>";
          echo " You total score: $totalScore<br>";
          echo "You total score after applying what-if scores: $whatifTotal<br>";
          echo "<button onclick=\"clearWhatif()\">clear all what-if scores</button><br>";
          echo "<button onclick=\"location.href='regrade.php'\">submit regrade</button>";
          
          $divNum1++;

      }
    echo "<p id='Div2ToPass' style='display: none'>$divNum1</p>";
    if($divNum1 == 1){
        echo "<p id='CourseIdToPass' style='display: none'>$anotherCourseId</p>";
    }
    ?>
    <script type="text/javascript">
      function clearWhatif() {
        var url = window.location.href;
        window.location.href = url.substring(0, url.search("\\?"));
      }
    </script>

    <script>

        /*main()

        function main() {
            var totalScore = document.getElementById("ScoreToPass").textContent;
            var totalPeople = document.getElementById("PeopleToPass").textContent;
        }*/
        
        function showScoreStatistics(index) {
            var mean = document.getElementById("MeanToPass"+index).textContent;
            var std = document.getElementById("StdDeviationToPass"+index).textContent;
            var maxScore = document.getElementById("MaxToPass"+index).textContent;
            var minScore = document.getElementById("MinToPass"+index).textContent;
            var s = "displayStatistics"+index;
            document.getElementById(s).innerHTML = "Mean: "+mean+ ";&nbsp&nbspStd Dev: "+std+";&nbsp&nbspMaximum: "+maxScore+";&nbsp&nbspMinimum: "+minScore+"&nbsp&nbsp<input type='button' value='Close' onclick='BackButton("+index+")'>";
            google.charts.setOnLoadCallback(drawChart(index));
        }

        function BackButton(index1){
            var s = "displayStatistics"+index1;
            document.getElementById(s).innerHTML = "<input type='button' value='Score Statistics' onclick='showScoreStatistics("+index1+")'>";
            var a = "pieChart";
            if(index1 === 0 || index1 === 1){
                a += "0";
            }else{
                a += "1";
            }
            document.getElementById(a).innerHTML = "";
        }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
      
      
      function endEdit(val, url, i) {
        var s = "whatif" + i;
        var pos = url.lastIndexOf(s);
        if (pos == -1) {
            if (url.search("\\?") !== -1) 
              window.location.href += "&" + s + "=" + val;
            else 
              window.location.href += "?" + s + "=" + val;
          }
        else {
          var toReplace = url.substring(pos, pos + 10);
          var target = s + "=" + val;
          window.location.href = url.replace(toReplace, target);
        }
        
        
      }
      
      $('.1').hide()
      .focusout(function(e) {
          var val = $(e.target).val();
          
          if (val < 10)
            val = "0" + val;
          
          var url = window.location.href;
          endEdit(val, url, 1);
          
        })
      .prev().click(function () {
        
        $(this).hide();
        $(this).next().show().focus();
      });
      $('.3').hide()
      .focusout(function(e) {
          var val = $(e.target).val();
         
          if (val < 10)
            val = "0" + val;
          
          var url = window.location.href;
          endEdit(val, url, 3);
          
        })
      .prev().click(function () {
        
        $(this).hide();
        $(this).next().show().focus();
      });
      $('.4').hide()
      .focusout(function(e) {
          var val = $(e.target).val();
         
          if (val < 10)
            val = "0" + val;
          
          var url = window.location.href;
          endEdit(val, url, 4);
          
        })
      .prev().click(function () {
        
        $(this).hide();
        $(this).next().show().focus();
      });
      $('.5').hide()
      .focusout(function(e) {
          var val = $(e.target).val();
         
          if (val < 10)
            val = "0" + val;
          
          var url = window.location.href;
          endEdit(val, url, 5);
          
        })
      .prev().click(function () {
        
        $(this).hide();
        $(this).next().show().focus();
      });
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages:['corechart']});

        function drawChart(index) {
            var divNum = document.getElementById("Div2ToPass").textContent;
            var Course0Data = google.visualization.arrayToDataTable([
                ['Major', 'Degrees'],
                ['Exam1', 50], ['Exam2', 50]]);
            var Course1Data = google.visualization.arrayToDataTable([
                ['Major', 'Degrees'],
                ['Exam1', 40], ['Exam2', 60]]);
            var options = { pieSliceText: 'none' };
            var chart;
            if(divNum == 1) {
                chart = new google.visualization.PieChart(document.getElementById('pieChart' + 0));
                var courseId = document.getElementById("CourseIdToPass").textContent;
                if (courseId === "CMSC389N") {
                    chart.draw(Course0Data, options);
                } else {
                    chart.draw(Course1Data, options);
                }
            }else{
                if(index === 0 || index === 1){
                    chart = new google.visualization.PieChart(document.getElementById('pieChart' + 0));
                    chart.draw(Course0Data, options);
                }else{
                    chart = new google.visualization.PieChart(document.getElementById('pieChart' + 1));
                    chart.draw(Course1Data, options);
                }
            }
        }

    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <style>
      table {
  font-family: "Helvetica Neue", Helvetica, sans-serif
}

caption {
  text-align: left;
  color: silver;
  font-weight: bold;
  text-transform: uppercase;
  padding: 5px;
}

thead {
  background: SteelBlue;
  color: white;
}

th,
td {
  padding: 5px 10px;
}

tbody tr:nth-child(even) {
  background: WhiteSmoke;
}

tbody tr td:nth-child(2) {
  text-align:center;
}

tbody tr td:nth-child(3),
tbody tr td:nth-child(4) {
  text-align: right;
  font-family: monospace;
}

tfoot {
  background: SeaGreen;
  color: white;
  text-align: right;
}

tfoot tr th:last-child {
  font-family: monospace;
}

    </style>
  </body>
</html>