<?php include 'connection.php';
  $token = openssl_random_pseudo_bytes(8);
  $token = bin2hex($token);
  $order_id = openssl_random_pseudo_bytes(12);
  $order_id = "YGK" . bin2hex($order_id);
 $date = date('Y:m:d');
 $time = date("H:i:s");
if (isset($_POST['first'])) {
  $val = $_POST['disease'];
 
 
  $name = $_POST['disease'];

  //data inserting in male_report table
  $inmain = "INSERT INTO `male_report` (`id`, `order_id`, `token`, `Date`, `time`, `datetime`, `status`) VALUES (NULL, '$order_id', '$token', '$date', '$time', current_timestamp(), '0')";

  $mainrun = mysqli_query($conn, $inmain);
  if ($mainrun) {
    echo "data inserted succcesfully";
  } else {
    echo "data not inserted";
  }
  //data inserting in disease_input_male table
  $name = $_POST['disease'];

  foreach ($name as  $value) {
    $display = " INSERT INTO `disease_input_male` (`id`, `value`, `datetime`, `status`) VALUES (NULL, '$value', current_timestamp(), '1')";
    $res = mysqli_query($conn, $display);
  }
  if ($res) {
    echo "<br> data inserted in  disease_input_male table ";
  }
  $get = mysqli_query($conn, "select * from mon_dis");
  //getting disease id in loop
  $name = $_POST['disease'];
  //getting input data in foreach loop   
  foreach ($name as $key => $value) {
    //data inserting in disease_male table
    $dissql = "INSERT INTO `disease_male` (`id`, `order_id`, `token`, `D_id`, `DiseaseVal`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$key', '$value', '$date', '$time', current_timestamp())";
    $res = mysqli_query($conn, $dissql);
  }
  if ($res) {
    echo "<br> data inserted";
  } else {
    echo "data not inserted " .  mysqli_error($conn);
  }
}

//inserting male_drugs_input name in drug table
if (isset($_POST['second'])) {
     
    $drugName = $_POST['drugs'];
       foreach ($drugName as  $Dname) {
   $drugsdata = " INSERT INTO `drug_input_male` (`id`, `value`, `datetime`, `status`) VALUES (NULL, '$Dname', current_timestamp(), '1')";
    $res = mysqli_query($conn, $drugsdata);
  }
  if ($res) {
    echo "<br> data inserted in drugs input table ";
  } 
  //data inserting in drugs_male table 

  foreach ($drugName as $drg_id => $value) {
    $maleDrug = "INSERT INTO `drugs_male` (`id`, `order_id`, `token`, `drg_id`, `DrugValue`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$drg_id', '$value', '$date', '$time', current_timestamp())";

    $run = mysqli_query($conn, $maleDrug);
  }
  if ($run) {
    echo "data inserted in male_drug table <br>";
  } else {
    echo "<br> data not inserted due to " . mysqli_error($conn);
  } 
}




//getting complex disease data from 
if (isset($_POST['third'])) {
  $complex = $_POST['complex'];

  foreach ($complex as $key => $value) {

    $yrRisk = $complex[$key]['yourRisk'];
    $avgRisk = $complex[$key]['AvgRisk'];
    $compRisk = $complex[$key]['CompRisk'];

    $insert = "INSERT INTO `complex_disease_male` (`id`, `order_id`, `token`, `com_id`, `yourRisk`, `Avg Risk`, `CompAvgRisk`, `Date`, `time`, `DateTime`) VALUES (NULL, '$order_id', '$token', $key, '$yrRisk', '$avgRisk', '$compRisk', '$date', '$time', current_timestamp());";
    $run = mysqli_query($conn, $insert);
  }
  if ($run) {
    echo "data inserted in complex_disease_male table  succesfully ";
  } else {
    echo "data not inserted in complex disease table " . mysqli_error($conn);
  }

} 

  //getting trait values from table
  if (isset($_POST['fourth'])) {
       $trait = $_POST['trait'];
     //inserting data into male_trait_input table
    foreach ($trait as $value) {
      $trait = "INSERT INTO `male_trait_input` (`id`, `value`, `status`, `datetime`) VALUES (NULL, '$value', '1', current_timestamp());";
      $run = mysqli_query($conn, $trait);
    }
    if ($run) {
    echo "data enter in trait table";
   } else {
     echo "data not inserted due to : " . mysqli_error($conn);
   }

    //inserting trait id and value into male_trait table 
   $trait = $_POST['trait'];
   foreach ($trait as $key => $value) {
    $male_trait = "INSERT INTO `male_trait` (`id`, `order_id`, `token`, `trait_id`, `trait_value`, `date`, `time`, `datetime`) VALUES (NULL, '$order_id', '$token', '$key', '$value', '$date', '$time', current_timestamp())";
    $run = mysqli_query($conn, $male_trait);
    }
   if ($run) {
    echo "data entered in male_trait table succesfully";
   } else {
    echo "data not inserted due to : " . mysqli_error($conn);
   } 

  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="refresh.js"></script>
  <title>YouTurn | Genetic Testing Kit</title>
  <style>
    .button {
      padding: 5px 3px;
      width: 10%;
      font-weight: bold;
      text-transform: uppercase;
      margin: 12px 0;
      background-color: #bdc3c7;
      cursor: pointer;
      border-radius: 12px;
    }

    .tab {
      display: block;
    }
  </style>
</head>

<body>

  <!-- Disease name table -->
  <form action="index.php " method="post" class="tab" id="firstform">
    <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
      <h2>GENERAL REPORT FOR MONOGENIC DISEASES </h2>
      <thead class="thead-dark">
        <tr>
          <th scope="col"> Id</th>
          <th scope="col"> Disease Name</th>
          <th scope="col"> Result</th>
        </tr>
      </thead>

      <tbody>
        <?php

        $select = " select * from  mon_dis_male  where status= 1 LIMIT 5";
        $run = mysqli_query($conn, $select);

        while ($data = mysqli_fetch_assoc($run)) { ?>
          <tr>
            <th scope="row" name="Ds_id">
              <?php echo $data['D_id']; ?>
            </th>
            <td>
              <?php echo $data['D_Name']; ?>
            </td>
            <td><input type="text" name="disease[<?php echo $data['D_id'] ?>]" id=" " placeholder="Enter value" required>

            </td>
          </tr>

        <?php }  ?>
      </tbody>

    </table>

    <div>
      <button type="button" id="prevBtn" class="button" onclick="nextPrev(-1)">Back</button>
      <!-- <button type="submit" name="submit" id="nextBtn" class="button " onclick="nextPrev(1)">Next</button>-->
      <input type="submit" value="Next" name="first" id="nextBtn" class="button " onclick="nextPrev(1)">
    </div>
  </form>

  <!-- Drugs name Table -->
  <form action="" method="post" class="tab">
    <h2>GENERAL REPORT FOR DRUGS </h2>
    <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
      <thead class="thead-dark">
        <tr>
          <th scope="col"> Id</th>
          <th scope="col"> Drugs Name</th>
          <th scope="col"> Result</th>
        </tr>
      </thead>

      <tbody>
        <?php

        $select = "select * from   drugsname_male  where status= 1 LIMIT 5";
        $run = mysqli_query($conn, $select);

        while ($data = mysqli_fetch_assoc($run)) { ?>
          <tr>
            <th scope="row">
              <?php echo $data['drg_id']; ?>
            </th>
            <td>
              <?php echo $data['Drg_name']; ?>
            </td>
            <td><input type="text" name="drugs[<?php echo $data['drg_id']; ?>]" id=" " placeholder="Enter value">

            </td>
          </tr>

        <?php }  ?>
      </tbody>
    </table>

    <div>
      <button type="button" id="prevBtn" class="button" onclick="nextPrev(-1)">Back</button>
      <button type="submit" name="second" id="nextBtn" class="button " onclick="nextPrev(1)">Next</button>
    </div>

  </form>
  <div class="error">
    <p style="color : red;" id="errMsg"></p>
  </div>
  <!-- Complex Disease name Table -->
  <form action="" method="post" class="tab">
    <h2>GENERAL REPORT FOR COMPLEX DISEASES </h2>
    <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
      <thead class="thead-dark">
        <tr>
          <th scope="col"> Id</th>
          <th scope="col"> Complex Disease Name</th>
          <th scope="col" colspan="3"> Result</th>
        </tr>
      </thead>

      <tbody>
        <?php

        $select =  'SELECT * FROM ` complex_dis_name_male` WHERE status = 1 limit 5';
        $run = mysqli_query($conn, $select);

        while ($data = mysqli_fetch_assoc($run)) { ?>
          <tr>
            <th scope="row">
              <?php echo $data['com_id']; ?>
            </th>
            <td>
              <?php echo $data['ComDisName']; ?>
            </td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][yourRisk]" id=" " placeholder="Your Risk" value="0"></td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][AvgRisk]" id=" " placeholder="Average Risk" value="0"></td>
            <td><input type="text" name="complex[<?php echo $data['com_id']; ?>][CompRisk]" id=" " placeholder="Compare to Average Risk"></td>
          </tr>

        <?php }  ?>

      </tbody>
    </table>
    <div>
      <button type="button" id="prevBtn" class="button" onclick="nextPrev(-1)">Back</button>
      <button type="submit" name="third" id="nextBtn" class="button " onclick="nextPrev(1)">Next</button>
    </div>
  </form>

  <!-- traits name Table -->
  <form action="" method="post" class="tab">
    <h2>GENERAL REPORT FOR TRAITS </h2>
    <table class="table" border="1px" cellspacing="0px" cellpadding="5px">
      <thead class="thead-dark">
        <tr>
          <th scope="col"> Id</th>
          <th scope="col"> Traits</th>
          <th scope="col"> Result</th>
        </tr>
      </thead>

      <tbody>
        <?php

        $select = "SELECT * FROM `traits_name_male` where status= 1 LIMIT 5";
        $run = mysqli_query($conn, $select);

        while ($data = mysqli_fetch_assoc($run)) { ?>
          <tr>
            <th scope="row">
              <?php echo $data['trait_id']; ?>
            </th>
            <td>
              <?php echo $data['Trait_Name']; ?>
            </td>
            <td><input type="text" name="trait[<?php echo $data['trait_id']; ?>]" id=" " placeholder="Enter Value"></td>
          </tr>

        <?php }  ?>
      </tbody>
    </table>
    <div>
      <button type="button" id="prevBtn" class="button" onclick="nextPrev(-1)">Back</button>
      <button type="submit" name="fourth" id="nextBtn" class="button " onclick="nextPrev(1)">Submit</button>
    </div>
  </form>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
  </div>



  



</body>
<!-- show cuureent tab -->

</html>