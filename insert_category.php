<?php
   $conn = mysqli_connect('localhost', 'staff', 'gwOLqOFdr4mxoEe0', 'museum');
   $cat_collision = "";
   $pw_collision = "";
   $c_idd = 0;
   $flag = 0;
   $st_pw = "";
   


   if(isset($_POST['c_submit']))
   {
      $query_category_detail = 'SELECT category_id, c_name FROM category';
      $result = mysqli_query($conn, $query_category_detail);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($final_result as $r)
      {
         $c_idd = $r['category_id'];
         if(strtolower($r['c_name']) == strtolower($_POST['c_name']))
         {
            $cat_collision = "Category already exists.";
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
            if($r['staff_id'] == $_POST['c_verifying_staff'])
               $st_pw = $r['s_password'];
         }

         if($st_pw == $_POST['c_verifying_pw'])
         {
            $c_idd++;
            
            $cat_id = mysqli_real_escape_string($conn, $c_idd);
            $cat_name = mysqli_real_escape_string($conn, $_POST['c_name']);


            $query_insert = "INSERT INTO category(category_id, c_name)
                              VALUES ($cat_id, '$cat_name')";
         
            mysqli_query($conn, $query_insert);

            echo '<script>alert("Successfully inserted '. $_POST['c_name'] .' into database."); window.location = "staff.php";</script>';

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
                  Insert Category
               </h1>
            </div>

            <!-- main form -->
            <div class="flexbox flexbox-centre">
               <table>
                  <tr>
                     <td align="right">
                        <label for="c_name">Category name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="c_name" id="c_name">
                        <br>
                        <span class="colour-red">
                           <?php
                              echo $cat_collision;
                           ?>
                        </span>
                     </td>
                  </tr>

                  
                  <tr>
                     <td align="right">
                        <label for="c_verifying_staff">Verified by:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="c_verifying_staff" id="c_verifying_staff">
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
                        <label for="c_verifying_pw">Password:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="password" min="8" name="c_verifying_pw" id="c_verifying_pw">
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
                        <input type="submit" name="c_submit" id="c_submit">  
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