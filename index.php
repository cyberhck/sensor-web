<?php
   $con = new SQLite3('sensor.db');
   $query =  "SELECT * FROM humidity;";
   $result=$con->query($query);
   while($data=$result->fetchArray(SQLITE3_ASSOC)){
      echo $data["humidity"]."--->".$data["time"]."<br>";
   }


?>