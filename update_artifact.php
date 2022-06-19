<?php
   $conn = mysqli_connect('localhost', 'staff', 'gwOLqOFdr4mxoEe0', 'museum');

   $art_collision = "";
   $pw_collision = "";
   $st_pw = "";
   $a_n = "";
   $s_flag = -1;
   $art_id = -1;
   $a_flag = 0;
   
   $a_id = -1;

   if(isset($_POST['a_update']))
   {
      $query_artifact_search = 'SELECT artifact_id, a_name FROM artifact';
      $result = mysqli_query($conn, $query_artifact_search);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($final_result as $r)
      {
         if(strtolower($r['artifact_id']) == strtolower($_POST['s_a_id']) || strtolower($r['a_name']) == strtolower($_POST['s_a_name']))
         {
            $a_id = $r['artifact_id'];
            $a_n = $r['a_name'];
            $s_flag = 1;
            break;
         }
         else
         {
            $s_flag = 0;
         }
      }
   }

   if(isset($_POST['a_submit']))
   {
      $s_flag = 1;
      $a_id = $_POST['a_id'];

      $query_artifact_detail = 'SELECT artifact_id, a_name FROM artifact';
      $result = mysqli_query($conn, $query_artifact_detail);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      foreach ($final_result as $r)
      {
         if((strtolower($r['a_name']) == strtolower($_POST['a_name'])) && ($r['artifact_id'] == $_POST['a_id']))
         {
            break;
         }
         else if(strtolower($r['a_name']) == strtolower($_POST['a_name']))
         {
            $art_collision = "Artifact already exists.<br>Please update that instead.";
            $a_flag = 1;
            break;
         }
      }

      if($a_flag == 0)
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
            $i = $_POST['a_current_location'];
            $ii = $_POST['a_condiion'];

            if($ii == "6") // stolen
            {
               $a_st = "4";
            }
            else if($ii == "4") // destroyed completely
            {
               $a_st = "3";
            }
            else if($ii == "5") // restorration process
            {
               if($i == "1")
               {
                  $a_st = "0";
               }
               else if($i == "2")
               {
                  $a_st = "1";
               }
               else if($i == "3")
               {
                  $a_st = "1";
               }
            }
            else if($ii == "3") // destroyed partially
            {
               if($i == "1")
               {
                  $a_st = "0";
               }
               else if($i == "2")
               {
                  $a_st = "2";
               }
               else if($i == "3")
               {
                  $a_st = "2";
               }
            }
            else if($ii == "2") // restored historicall
            {
               if($i == "1")
               {
                  $a_st = "0";
               }
               else if($i == "2")
               {
                  $a_st = "1";
               }
               else if($i == "3")
               {
                  $a_st = "1";
               }
            }
            else if($ii == "1") // initial
            {
               if($i = "1")
               {
                  $a_st = "0";
               }
               else if($i == "2")
               {
                  $a_st = "1";
               }
            }


            $art_id = mysqli_real_escape_string($conn,$a_id);
            $art_name = mysqli_real_escape_string($conn, $_POST['a_name']);
            $art_cat = mysqli_real_escape_string($conn, $_POST['a_category']);
            $art_date = mysqli_real_escape_string($conn, 1);
            $art_staff = mysqli_real_escape_string($conn, $_POST['a_verifying_staff']);
            $art_status = mysqli_real_escape_string($conn,$a_st);

            if(isset($_POST['a_new_name']))
            {
               $art_new_name = mysqli_real_escape_string($conn, $_POST['a_new_name']); 
            }
            else
            {
               $art_new_name = mysqli_real_escape_string($conn, 'NULL'); 
            }

            if(isset($_POST['a_new_address']))
            {
               $art_new_address = mysqli_real_escape_string($conn, $_POST['a_new_address']); 
            }
            else
            {
               $art_new_address = mysqli_real_escape_string($conn, 'NULL'); 
            }



            $query_update = "UPDATE artifact SET a_name = '$art_name', a_category = $art_cat, a_date = $art_date, a_verifying_officer = $art_staff, a_status = $art_status, a_new_name = '$art_new_name', a_new_address = '$art_new_address' WHERE artifact_id = $art_id";
         
            mysqli_query($conn, $query_update);

            echo '<script>alert("Successfully updated '. $_POST['a_name'] .'."); window.location = "staff.php";</script>';

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
               Update Artifact
            </h1>
         </div>

         <div class="flexbox flexbox-centre" id="search_box">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
               <table>
                  <tr>
                     <td align="right">
                        <label for="s_a_id">Search by artifact id:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="number" name="s_a_id" id="s_a_id">
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="s_a_name">Search by artifact name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="s_a_name" id="s_a_name">
                     </td>
                  </tr>
                  <tr>
                     <td align="right">
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="submit" name="a_update" id="a_update" value="Search">
                        <?php
                           if($s_flag == 0)
                           {
                              echo '<br><span class="colour-red">No record found</span>';
                           }
                        ?>  
                     </td>
                  </tr>
               </table>
            </form>
         </div>

         
         <!-- main form -->
         <div id="update_box" class="invisible">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
               <input type="number" name="a_id" id="a_id" class="invisible" value="<?php echo $a_id;?>">
               <table>
                  <tr>
                     <td align="right">
                        Artifact Id:
                     </td>
                     <td></td>
                     <td align="left">
                        <?php
                           if($s_flag == 1)
                           {
                              echo '<script>display_update();</script>' . $a_id;
                           }
                        ?>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_name">Artifact name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="a_name" id="a_name" value="<?php echo $a_n;?>">
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
                        <select name="a_category" id="a_category" required>
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
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_current_location">Current location:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="a_current_location" id="a_current_location" onchange="update_condition(this.value)" required>
                           <option value="">-Select-</option>
                           <option value="1">In museum</option>
                           <option value="2">Another museum</option>
                           <option value="3">Third party</option>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_condiion">Condition:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="a_condiion" id="a_condiion" required>
                           <option value="">-Select-</option>
                           <option value="1" id="initial">In initial condition</option>
                           <option value="2">Restored to historically accurate condition</option>
                           <option value="3">Destroyed partially</option>
                           <option value="4" id="complete">Destroyed completely</option>
                           <option value="5">In restoration process</option>
                           <option value="6" id="stolen">Stolen</option>
                        </select>
                     </td>
                  </tr>

                  <tr class="third_p invisible">
                     <td colspan="3" align="center">
                        New location details 
                     </td>
                  </tr>

                  <tr class="third_p invisible">
                     <td align="right">
                        <label for="a_new_name">Name:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="a_new_name" id="a_new_name">
                     </td>
                  </tr>

                  <tr class="third_p invisible">
                     <td align="right">
                        <label for="a_new_address">Address:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <input type="text" name="a_new_address" id="a_new_address">
                     </td>
                  </tr>

                  <tr>
                     <td colspan="3" align="center">
                        &nbsp;
                     </td>
                  </tr>

                  <tr>
                     <td align="right">
                        <label for="a_verifying_staff">Verified by:</label>
                     </td>
                     <td></td>
                     <td align="left">
                        <select name="a_verifying_staff" id="a_verifying_staff" required>
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
                        <label for="a_verifying_pw">Password:</label>
                     </td>
                     <td></td>
                     <td align="left"> 
                        <input type="password" minlength="0" name="a_verifying_pw" id="a_verifying_pw"> 
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
           
      



      <script>
         function update_condition(idd)
         {
            switch(idd)
            {
               case "0":
                  document.getElementById("complete").classList.remove("invisible");
                  document.getElementById("initial").classList.remove("invisible");
                  document.getElementById("stolen").classList.remove("invisible");

                  tp = document.getElementsByClassName("third_p");

                  for(i = 0; i < tp.length; i++)
                  {
                     tp[i].classList.add("invisible");
                  }
               break;
               case "1":
                  document.getElementById("initial").classList.remove("invisible");

                  document.getElementById("stolen").classList.add("invisible");
                  document.getElementById("complete").classList.add("invisible");

                  tp = document.getElementsByClassName("third_p");

                  for(i = 0; i < tp.length; i++)
                  {
                     tp[i].classList.add("invisible");
                  }
               break;

               case "2":
                  document.getElementById("complete").classList.remove("invisible");
                  document.getElementById("initial").classList.remove("invisible");
                  document.getElementById("stolen").classList.remove("invisible");

                  tp = document.getElementsByClassName("third_p");

                  for(i = 0; i < tp.length; i++)
                  {
                     tp[i].classList.remove("invisible");
                  }
               break;
               
               case "3":
                  document.getElementById("stolen").classList.remove("invisible");
                  document.getElementById("complete").classList.remove("invisible");

                  document.getElementById("initial").classList.add("invisible");

                  tp = document.getElementsByClassName("third_p");

                  for(i = 0; i < tp.length; i++)
                  {
                     tp[i].classList.remove("invisible");
                  }
               break;
            }
         }


      


      
      </script>
   </body>

</html>