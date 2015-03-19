<?php
   $con = new SQLite3('sensor.db');
   $query =  "SELECT * FROM magneticField;";
   $result=$con->query($query);
   $a=array();
   $i=0;
   while($data=$result->fetchArray(SQLITE3_ASSOC)){
      $time=$data["time"];
      $time=explode(" ", $time);
      $date=$time[0];
      $time=$time[1];
      $date=explode(":", $date);
      $time=explode(":", $time);
      $a[$i]='[new Date("'.($date[1]+1)."/".$date[0]."/".$date[2]." ".$time[0].":".$time[1].":".$time[2];
      $a[$i]=$a[$i].'"),'.$data["x"].','.$data["y"].','.$data["z"].']';
      $i++;
   }
   $b=implode(",\n", $a);    
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['annotationchart']}]}"></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {'packages':['annotationchart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
var dataTable= new google.visualization.DataTable();
        dataTable.addColumn('datetime', 'Time');
        dataTable.addColumn('number', 'Magnet x');
        dataTable.addColumn('number', 'Magnet y');
        dataTable.addColumn('number', 'Magnet z');
        dataTable.addRows([
         <?php echo $b; ?>
      ]);

       // For some reason, it doesn't work correctly
       var formatter = new google.visualization.DateFormat({pattern: 'dd:MM:YYYY'});
        //formatter.format(dataTable, 0);

        // Create and draw the visualization.
         var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(dataTable, {curveType: "function"});   
      }
    </script>
  </head>

  <body>
      <a href="/ambient.php">ambient</a>
      <a href="/pressure.php">pressure</a>
      <a href="/objectTemp.php">object temperature</a>
      <a href="/magnet.php">Magnetic Field</a>
<!--       <a href="/light.php">Light</a>
 -->    <div id='chart_div' style='width: 100%; height: 500px;'></div>
  </body>
</html>
