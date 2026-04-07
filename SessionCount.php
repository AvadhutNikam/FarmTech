<?php

 session_start();

 if(isset($_SESSION["count"]))
 {
   echo "Currently User Visited On Your Website is : = ".$_SESSION["count"];
   $_SESSION["count"]++;

 }
 else
 {
   $_SESSION["count"]=1;
   echo "Currently User Visited On Your Website is : = ".$_SESSION["count"];
 }

?>