n = Math.floor(Math.random() * 4) + 1;
function main_home()
{ 
   urll = "url('images/main_home/chhauni_" + n + ".jpg')";
   n++;
   if(n > 4)
   {
      n = 1;
   }
   document.getElementById("home").style.backgroundImage = urll;
   setTimeout(main_home, 3000);
}