<?php
// Initialize a session.
session_start();
require_once("./include/config.inc.php");
	
if (!isset($_SESSION['userid']) AND (!isset($_SESSION['logged_in']))) { //ตรวจสอบ session ถ้าไม่ตรงกัน
header("Location: $login_page"); // ถ้าไม่มีกลับไปหน้า login
exit(); 
}
$inactive = 600;
// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
	$session_life = time() - $_SESSION['timeout'];
	if($session_life > $inactive)
        { session_destroy(); header("Location: $logout_page"); }
}
$_SESSION['timeout'] = time();
include("./include/header.php");
?>


     
    <!-- // content starts here // -->
        
        <div id="content">
        <form action="" method="post">
         
        <!-- new box -->
        
            <div class="box-25 corners shadow">
                <div class="box-header-25">
                    <h2>Quick info</h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content-25" id="index-1">
                    <ul class="index-info-box">
                    	<li>Visits Today<a href="#">879</a></li>
                        <li>Unique Visits<a href="#">697</a></li>
                        <li>Articles<a href="#">45</a></li>
                        <li>Authors<a href="#">19</a></li>
                        <li>Comments<a href="#">1767</a></li>
                        <li>Pending Comments<a href="#">45</a></li>
                        <li>Spam<a href="#">4567</a></li>
                        <li>Tickets<a href="#">245</a></li>
                    </ul>
                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" --> 
             
        <!-- new box -->
         
        	<div class="box-75 corners shadow" style="margin-left:18px;">
                <div class="box-header-75">
                    <h2>Stats</h2>
                    <div class="box-header-ctrls">	
                    	<a href="javascript:void(null);" title="" class="close"><!-- --></a>
                    </div>
                </div>
                
                <div class="box-content-75" id="index-2">
   					<div id="chart_div"></div>
                </div><!-- END ".box-content" --> 
            </div><!-- END ".box" --> 
                                                    
        </form><!-- END form-->                                              
        </div><!-- END "#content" -->
         
<?php
include("./include/footer.php");
?>
    
    <!-- jquery/javascript per page -->
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
	  // http://code.google.com/apis/visualization/documentation/using_overview.html
	  // http://code.google.com/apis/visualization/documentation/gallery.html
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
        data.addColumn('number', 'Visits');
        data.addColumn('number', 'Unique Visits');
        data.addRows([
          ['2007', 1000, 400],
          ['2008', 1170, 460],
          ['2009', 660, 1120],
          ['2010', 1030, 540]
        ]);

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 640, height: 282, title: 'Stats',
                          hAxis: {title: 'Year', titleTextStyle: {color: '#000000'}}
                         });
      }
    </script>
        
  
        
</body>
</html>