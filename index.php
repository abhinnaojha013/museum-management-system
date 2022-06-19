<?php
$a_name = "";
$a_category = "";
$a_new_name = "";
$a_new_address = "";
$new_flag = 0;
$a_flag = -1;
$sb_flag = 0;

   if(isset($_POST['search_button']))
   {
      $conn = mysqli_connect('localhost', 'staff', 'gwOLqOFdr4mxoEe0', 'museum');
      $query_artifact_detail = 'SELECT a_name, category.c_name, a_new_name, a_new_address 
                                 FROM artifact 
                                 JOIN category 
                                 ON artifact.a_category = category.category_id';
      $result = mysqli_query($conn, $query_artifact_detail);
      $final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);

      $sb_flag = 1;

      foreach($final_result as $r)
      {
         if(strtolower($r['a_name']) == strtolower($_POST['artifact']))
         {
            $a_name = $r['a_name'];
            $a_category = $r['c_name'];
            $a_flag = 1;
   
            if($r['a_new_name'] != NULL)
            {
               $a_new_name = $r['a_new_name'];
               $a_new_address = $r['a_new_address'];
               $new_flag = 1;
            }
            else
            {
               $a_new_name = "";
               $a_new_address = "";
               $new_flag = 0;
            }

            break;
         }
         else
         {
            $a_flag = 0;
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

   <meta name="keywords" content="Chhauni, chhauni, Museum, museum, National, national, Nepal, nepal, museum of nepal, Museum of nepal, national museum of nepal, chhauni museum">

    <title>National Museum of Nepal, Chhauni</title>
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="scss/r_styles.css">
    <link rel="stylesheet" href="scss/style.css">
    <link rel="stylesheet" href="scss/carousel.css">

    <script src="js/source.js"></script>


</head>

<body onload="main_home()">
   <div id="top"></div>
    <header>
        <nav>
            <input type="checkbox" id="check-box">
            <label for="check-box" class="check-button">
                <i class="fa fa-bars"></i>
            </label>
            <label class="logo">Chhauni Museum</label>
            <ul>
                <li><a href="#top">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

    </header>

   <div>

      <div id="home">
         <div class="container">

            <div style="height: 300px; width: 400px"></div>
            <h1 class="heading colour-heading stroke" id="about">THEMATIC PRESENTATIONS OF NEPALESE ART</h1>

        
           
         </div>
      </div>

      


      <div>
         <div class="container">
            <p>
            The National Museum of Nepal (Rashtriya Sangrahlaya) is a popular attraction of the capital city of Nepal,Kathmandu. About a century old, the museum stands as a tourist destination and historical symbol for Nepal. Being the largest museum of the country of Nepal, it plays an important role in nationwide archaeological works and development of museums. For the residents of Kathmandu, the monument serves to relive the battles fought on the grounds of Nepal. The main attractions are collection of historical artworks (sculpture and paintings) and a historical display of weapons used in the wars in the 18-19th century. The museum has separate galleries dedicated to statues, paintings, murals, coins and weapons. It has three buildings — Juddha Jayatia Kala Shala, Buddha Art Gallery and the main building which consists of natural historical section (collection of species of animals, butterflies and plants), cultural section and philatelic section.
            </p>
         </div>
         <div class="slideshow-container">
         <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
               <div class="flexbox flexbox-centre">
                  <img src="images/carousel/1.jpg" height="450">
               </div>
               <div class="text">Jayavarma (185 AD), with inscriptions in Brahmi script and Sanskrit language</div>
            </div>
         
            <div class="mySlides fade">
               <div class="flexbox flexbox-centre">
                  <img src="images/carousel/2.jpg" height="450">
               </div>
               <div class="text">Nah Bahal's Dharmadhatu Mandala in Patan</div>
            </div>
         
            <div class="mySlides fade">
               <div class="flexbox flexbox-centre">
                  <img src="images/carousel/3.jpg" height="450">
               </div>
               <div class="text">Surya with Navagraha (15th century)</div>
            </div>
         
            <!-- Next and previous buttons -->
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
         </div>

         <script src="js/carousel.js"></script>         
      </div>
      <div id="search_box_position">
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="container flexbox flexbox-column">
               <div>
                  <h3>
                     Search for artifacts in museum
                  </h3>
               </div>
               <div>
                  <input type="text" name="artifact" id="artifact" placeholder="Artifact name" class="search">
               </div>
               <div>
                  <input type="submit" name="search_button" id="search_button" value="Search" class="search_button">                  
               </div>
               <div class="flexbox flexbox-centre">
                  <?php
                     if($a_flag == 1)
                     {
                  ?>
                     <table class="flexbox flexbox-basis-per100">
                        <tr>
                           <td align="right"><p class="artifact_name_td">Artifact name:</p></td>
                           <td></td>
                           <td align="left"><?php echo $a_name ?></td>
                        </tr>
                        <tr>
                           <td align="right">Category:</td>
                           <td></td>
                           <td align="left"><?php echo $a_category ?></td>
                        </tr>
                        <?php

                           if($new_flag == 1)
                           {
                        ?>
                           <tr>
                              <td align="right">Currently in:</td>
                              <td></td>
                              <td align="left"><?php echo $a_new_name . ", " . $a_new_address?></td>
                           </tr>
                        <?php
                           }  
                        ?>
                     </table>
                  <?php
                     }
                     else if($a_flag == 0)
                     {
                  ?>
                     <span class="colour-red">Artifact not found.</span>
                  <?php
                      }
                  ?>
               </div>
            </div>
         </form>
      </div>

      <div class="container" id="contact">

         <button>Sign Up</button>
         <button>Sign In</button>
         <div></div>


         <div class="flexbox flexbox-centre">
               <div class="flexbox-basis-per05">
                  <a href="fb.com" class="facebook foot_link" target="fb">
                     <i class="fa fa-facebook"></i>
                  </a>
               </div>

               <div class="flexbox-basis-per05">
                  <a href="twitter.com" class="twitter foot_link" target="tw">
                     <i class="fa fa-twitter"></i>
                  </a>
               </div>

               <div class="flexbox-basis-per05">
                  <a href="google.com" class="google foot_link" target="gp">
                     <i class="fa fa-google"></i>
                  </a>
               </div>
         </div>           

      </div>
   </div>

   <?php
      if($sb_flag == 1)
      {
         echo '<script>document.getElementById("search_box_position").scrollIntoView();</script>';

      }
   ?>
    
   

    
</body>

</html>