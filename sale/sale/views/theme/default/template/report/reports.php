<?php echo $header;//装载header?>
<?php echo $top;//装载top?>
<div class="container">
 <div class="row">
  	<div class="col-md-12">
  	<div class="panel panel-default">
       <div class="panel-body">
          <div class="col-md-4">
          	<h3>Vizitor</h3>
            <div class="stats-box-all-info"><p class="glyphicon glyphicon-user" style="color:#3366cc;"></p>&nbsp;555K</div>
            <div class="wrap-chart"><div id="visitor-stat" class="chart" style="padding: 0px; position: relative;"><canvas id="bar-chart1" class="chart-holder" height="150" width="325"></canvas></div></div>
          </div>
          <div class="col-md-4">
            <h3>Likes</h3>
            <div class="stats-box-all-info"><p class="glyphicon glyphicon-th"  style="color:#F30"></p>&nbsp;66.66</div>
            <div class="wrap-chart"><div id="order-stat" class="chart" style="padding: 0px; position: relative;"><canvas id="bar-chart2" class="chart-holder" height="150" width="325"></canvas></div></div>
          </div>
          <div class="col-md-4">
            <h3>Orders</h3>
            <div class="stats-box-all-info"><p class="glyphicon glyphicon-shopping-cart" style="color:#3C3"></p>&nbsp;15.55</div>
            <div class="wrap-chart">
            <div id="user-stat" class="chart" style="padding: 0px; position: relative;"><canvas id="bar-chart3" class="chart-holder" height="150" width="325"></canvas></div>
            </div>
          </div>
       </div>
     </div>
 </div>
 </div>
  <!-- /row -->
  <div class="row">
  	<div class="col-md-6 middle-flat-left">
  		<div class="panel panel-default">
			<h3 class="panel-heading row row-panel-heading bg-info"><i class="glyphicon glyphicon-star"></i>&nbsp;Some Stats</h3><!-- /widget-header -->
			<div class="panel-body">
				<canvas id="pie-chart" class="chart-holder"></canvas>
			</div> <!-- /widget-content -->
		</div> <!-- /widget -->
    </div> <!-- /span6 -->
  	<div class="col-md-6 middle-flat-left">
  		<div class="panel panel-default">
			<h3 class="panel-heading row row-panel-heading bg-info"><i class="glyphicon glyphicon-th-large"></i>&nbsp;Another Chart</h3><!-- /widget-header -->
			<div class="panel-body">
				<canvas id="bar-chart" class="chart-holder" height="250" width="538"></canvas>
			</div> <!-- /widget-content -->
		</div> <!-- /widget -->
      </div> <!-- /span6 -->
  </div> <!-- /row -->
</div> <!-- /container -->
 <?php echo $footer;//装载header?>
<script>
    var pieData = [
				{
				    value: 30,
				    color: "#F38630"
				},
				{
				    value: 50,
				    color: "#E0E4CC"
				},
				{
				    value: 100,
				    color: "#69D2E7"
				}

			];
    var myPie = new Chart(document.getElementById("pie-chart").getContext("2d")).Pie(pieData);
    var barChartData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
				{
				    fillColor: "rgba(220,220,220,0.5)",
				    strokeColor: "rgba(220,220,220,1)",
				    data: [65, 59, 90, 81, 56, 55, 40]
				},
				{
				    fillColor: "rgba(151,187,205,0.5)",
				    strokeColor: "rgba(151,187,205,1)",
				    data: [28, 48, 40, 19, 96, 27, 100]
				}
			]

    }
    var myLine = new Chart(document.getElementById("bar-chart").getContext("2d")).Bar(barChartData);
	var myLine = new Chart(document.getElementById("bar-chart1").getContext("2d")).Bar(barChartData);
	var myLine = new Chart(document.getElementById("bar-chart2").getContext("2d")).Bar(barChartData);
	var myLine = new Chart(document.getElementById("bar-chart3").getContext("2d")).Bar(barChartData);
	</script>
  </body>
</html>
