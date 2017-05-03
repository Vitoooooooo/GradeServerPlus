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
      $username = $_POST['username'];
      echo ">$username</a>!";
    ?>
    <img src="View/sampleIcon.jpg" alt="Imagine a Hulk here.." style="width:50px;height:50px;"><br>
    @Jerry please update this image after you create user table in the database.
    
    
    <h1>Your grades</h1>
    @Shanshi please update this table after you create grade tables in the database. You need to create those tables according to Jerry's users table.
    <table border="1">
      <tr><td>assignment</td><td>grade</td><td>Out Of</td><td>weight(%)</td><td></td></tr>
      <tr><td>1</td><td>80</td><td>100</td><td>40</td><td><button>submit regrade request</button></td></tr> 
      <tr><td>2</td><td>50</td><td>70</td><td>20</td><td><button>submit regrade request</button></td></tr>
      <tr><td>3</td><td>95</td><td>100</td><td>40</td><td><button>submit regrade request</button></td></tr>
    </table>
    You total score: <br>
    You total score after applying what-if scores: 
    <button>clear all what-if scores</button>
    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    
  </body>
</html>