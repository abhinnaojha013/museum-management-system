<?php
   $conn = mysqli_connect('localhost', 'staff', 'gwOLqOFdr4mxoEe0', 'museum');
   $art_collision = "";
   $pw_collision = "";
   $a_idd = 0;
   $flag = 0;
   $st_pw = "";
   


   if(isset($_POST['a_submit']))
   {
      $query_artifact_detail = 'SELECT artifact_id, a_name FROM artifact';
      $result = mysqli_query($conn, $query_artifact_detail);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($final_result as $r)
      {
         $a_idd = $r['artifact_id'];
         if(strtolower($r['a_name']) == strtolower($_POST['a_name']))
         {
            $art_collision = "Artifact already exists.<br>Please update instead.";
            $flag = 1;
            break;
         }
      }


      if($flag == 0)
      {
         $query_staff_ver = "SELECT staff_id, s_password FROM staff";
         $result = mysqli_query($conn, $query_staff_ver);
         $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

         foreach ($final_result as $r)
         {
            if($r['staff_id'] == $_POST['a_verifying_staff'])
               $st_pw = $r['s_password'];
         }

         if($st_pw == $_POST['a_verifying_pw'])
         {
            $a_idd++;
            
            $art_id = mysqli_real_escape_string($conn, $a_idd);
            $art_name = mysqli_real_escape_string($conn, $_POST['a_name']);
            $art_cat = mysqli_real_escape_string($conn, $_POST['a_category']);
            $art_date = mysqli_real_escape_string($conn, 1);
            $art_staff = mysqli_real_escape_string($conn, $_POST['a_verifying_staff']);
            $art_status = mysqli_real_escape_string($conn, "0");
            $a_new_name = mysqli_real_escape_string($conn, 'NULL');
            $a_new_address = mysqli_real_escape_string($conn, 'NULL');


            $query_insert = "INSERT INTO artifact(artifact_id, a_name, a_category, a_date, a_verifying_officer, a_status, a_new_name, a_new_address) 
                              VALUES ($art_id, '$art_name', $art_cat, $art_date, $art_staff, $art_status, $a_new_name, $a_new_address)";
         
            mysqli_query($conn, $query_insert);

            echo '<script>alert("Successfully inserted '. $_POST['a_name'] .' into database."); window.location = "staff.php";</script>';

         }
         else
         {
            $pw_collision = "Incorrect password.";
         }
      } 
   }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="Museum, museum">

        <title>Staff page</title>

        <!-- css connections -->
        <link rel="stylesheet" href="scss/style.css">
        
    </head>

   <body onload="update_condition('1')">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
         <div class="flexbox flexbox-column">
            <div class="flexbox flexbox-centre">

            </div>

            <div class="flexbox flexbox-centre">
               <h1>
                  Insert Artifact
               </h1>
            </div>

            <!-- main form -->
            <div class="flexbox flexbox-centre">
               <table>
                  <tr>
                     <td align="right">
                        <label for="a_name">Artifact name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="a_name" id="a_name">
                        <br>
                        <span class="colour-red">
                           <?php
                              echo $art_collision;
                           ?>
                        </span>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_category">Category:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="a_category" id="a_category">
                           <?php
                              $query_category = 'SELECT category_id, c_name FROM category';
                              $result = mysqli_query($conn, $query_category);
                              $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

                              foreach ($final_result as $r)
                              {
                                 echo '<option value="' . $r['category_id'] . '">' . $r['c_name'] . '</option>';
                              }
                           ?>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_verifying_staff">Verified by:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="a_verifying_staff" id="a_verifying_staff">
                           <?php
                              $query_staff = 'SELECT staff_id, s_username, s_password, s_first_name, s_middle_names, s_last_name FROM staff';
                              $result = mysqli_query($conn, $query_staff);
                              $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

                              foreach ($final_result as $r)
                              {
                                 echo '<option value="' . $r['staff_id'] . '">' . $r['s_first_name'] . ' ' . $r['s_middle_names'] .' ' . $r['s_last_name'] . '</option>';
                              }
                           ?>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_verifying_pw">Password:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="password" min="8" name="a_verifying_pw" id="a_verifying_pw">
                        <br>
                        <span class="colour-red">
                           <?php
                              echo $pw_collision;
                           ?>
                        </span>  
                     </td>
                  </tr>

                  <tr>
                     <td align="right"></td>
                     <td></td>
                     <td align="left">
                        <input type="submit" name="a_submit" id="a_submit">  
                     </td>
                  </tr>


               </table>
            </div>
            
                     
         </div> 
           
      </form>

      <div style="height: 30px;"></div>
      <div class="flexbox flexbox-centre">
         <button onclick="staff()" style="height: 30px; width: 90px; cursor: pointer;">Staff page</button>

         <script>
            function staff()
            {
               window.location = "staff.php";
            }
         </script>

      </div>

      
   </body>

</html>