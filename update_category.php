<?php
   $conn = mysqli_connect('localhost', 'staff', 'gwOLqOFdr4mxoEe0', 'museum');

   $c_collision = "";
   $pw_collision = "";
   $st_pw = "";
   $c_n = "";
   $c_flag = -1;
   $art_id = -1;
   $c_flag = 0;
   
   $c_id = -1;

   if(isset($_POST['c_update']))
   {
      $c_cat = $_POST['c_category'];
      $query_category_search = "SELECT category_id, c_name FROM category WHERE category_id = $c_cat";
      $result = mysqli_query($conn, $query_category_search);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($final_result as $r)
      {
         $c_id = $r['category_id'];
         $c_n = $r['c_name'];
         $c_flag = 1;
         break;
      }
   }

   if(isset($_POST['c_submit']))
   {
      if($c_flag == 0)
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
            $cat_id = mysqli_real_escape_string($conn, $_POST['c_id']);
            $cat_name = mysqli_real_escape_string($conn, $_POST['c_name']);

            $query_update = "UPDATE category SET c_name = '$cat_name' WHERE category_id = $cat_id";
         
            mysqli_query($conn, $query_update);

            echo '<script>alert("Successfully updated '. $_POST['c_name'] .'."); window.location = "staff.php";</script>';
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

   <body>
      <script>
         function display_update()
         {
            document.getElementById("update_box").classList.remove("invisible");
            document.getElementById("update_box").classList.add("flexbox");
            document.getElementById("update_box").classList.add("flexbox-centre");

            document.getElementById("search_box").classList.remove("flexbox");
            document.getElementById("search_box").classList.remove("flexbox-centre");
            document.getElementById("search_box").classList.add("invisible");
         }
      </script>


      <div class="flexbox flexbox-column">
         <div class="flexbox flexbox-centre">
            <h1>
               Update Category
            </h1>
         </div>

         <div class="flexbox flexbox-centre" id="search_box">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
               <table>
                  <tr>
                     <td align="right">
                        <label for="c_category">Select category to update:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="c_category" id="c_category" required>
                           <option value="">-Select-</option>
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
                        <input type="submit" value="Select" name="c_update" id="c_update" class>                     
                     </td>
                  </tr>
               </table>
            </form>
         </div>

         
         <!-- main form -->
         <div id="update_box" class="invisible">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
               <input type="number" name="c_id" id="c_id" class="invisible" value="<?php echo $c_id;?>">
               <table>
                  <tr>
                     <td align="right">
                        Category Id:
                     </td>
                     <td></td>
                     <td align="left">
                        <?php
                           if($c_flag == 1)
                           {
                              echo '<script>display_update();</script>' . $c_id;
                           }
                        ?>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="c_name">Category name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="c_name" id="c_name" value="<?php echo $c_n;?>">
                        <br>
                        <span class="colour-red">
                           <?php
                              echo $c_collision;
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
                        <select name="c_verifying_staff" id="c_verifying_staff" required>
                           <option value="">-Select-</option>
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
                        <input type="password" minlength="0" name="c_verifying_pw" id="c_verifying_pw"> 
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
            </form>
         </div>
      </div>
      
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