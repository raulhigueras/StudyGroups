<html>
  <head>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- Font awesome for icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <!-- Custom Javascript -->
    <script src="functions.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css" >
  </head>
  <body>
    <div class="jumbotron text-center">
      <h1 class="main_title">S T U D Y // G R O U P S</h1>
      <h3>Look for a group</h3>
      <br />
      <form method="get" action="getGroups.php" class="form-inline">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-book"></i></span>
          </div>
          <select class="custom-select" name="subject">
            <option selected value=""> -- Subject -- </option>
            <option value="CAL">Calculus</option>
            <option value="PHY">Physics</option>
            <option value="ALG">Algebra</option>
            <option value="LMD">Lógica</option>
          </select>
        </div>
        <div class="input-group"><input class="btn" type="submit" value="SEARCH" /></div>
      </form>
    </div>

    <!-- Aquí empieza el grid -->
    <div class="d-flex flex-wrap">
      <?php
        include './private/db_connect.php';
        if(is_null($_GET["subject"]) or $_GET["subject"] == ""){
          $sql = "SELECT * FROM meetings WHERE full=0";
        }else{
          $subject = $_GET["subject"];
          $sql = "SELECT * FROM meetings WHERE full=0 and subject='".$subject."'";
        }
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)){
      ?>

      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?= $row["subject"] . " - " . $row["classroom"]?></h4>
          <h6 class="card-subtitle mb-2 text-muted"><?= $row["startTime"] ?></h6>
          <p class="card-text">
            <?= $row["maxLearners"] - $row["learners"] ?> places left.
          </p>
          <button href="#!" class="btn btn-primary">Enroll</button>
        </div>
      </div>

      <?php
        }
      ?>

    </div>
  </body>
</html>
