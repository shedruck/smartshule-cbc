<?php
$m_sales = array();
$svc     = array();
?>
<div class="divider"><div><span></span></div></div>
<div class="col-md-9">
  <div class="widget">
    <div class="tabbable">
      <div class="wTitle">  <div class="wIcon">
          <?php echo theme_image('icons/14x14/dice1.png'); ?> 
        </div>   <h5>Reports </h5>
      </div> 
      <div class="widget-content">

        <?php if (isset($services) && !empty($services)): ?>
          <div class='clear'></div>
          <p>&nbsp;</p>
          <span class="col-md-8">
            <table   class="ltable "   >
              <thead>
                <tr>
                  <th> </th><th>Jan</th><th>Feb</th><th>Mar</th><th>April</th>
                  <th>May</th><th>Jun</th><th>July</th><th>Aug</th><th>Sep</th>
                  <th>Oct</th><th>Nov</th><th>Dec</th><th>Total (Kshs)</th>
                </tr>
              </thead>  <tbody><tr><td>Services</td>
                  <?php
                  $s = 0;
                  foreach ($services as $key => $value):
                    echo '<td>' . number_format($value) . '</td>';
                    $s += $value;
                  endforeach;
                  ?>
                  <?php echo '<td class="bld"> ' . number_format($s) . '</td>'; ?>
                </tr> 
                 
              </tbody>
            </table>
          </span>
          <div id="compare" style="width:100%;height:300px"></div>
          <div id="chartdiv" style="width: 100%; height: 400px;"></div>
          <?php
          $ms = array('1'  => 'Jan', '2'  => 'Feb', '3'  => 'Mar', '4'  => 'Apr',
              '5'  => 'May', '6'  => 'Jun', '7'  => 'Jul', '8'  => 'Aug', '9'  => 'Sept',
              '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');

          foreach ($services as $key => $value)
          {
            $m_sales[] = array('Month' => $ms[$key], "Tot"   => (int) $value, "Sales" => 0);
          }
          
                 
          ?>

        </div></div></div></div>

<?php else: ?>
  <p class='text'><?php //echo lang('web_no_elements');     ?></p>
  <div id="conpage" style="width: 100%; height: 400px;"></div>

<?php endif; ?>

<script type = "text/javascript">
  var m_sales = <?php echo json_encode($m_sales); ?>;
 
  AmCharts.ready(function() {
// SERIAL CHART  
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = "../amcharts/images/";
    chart.dataProvider = m_sales;
    chart.categoryField = "Month";
    chart.startDuration = 1;
    chart.depth3D = 8;
    chart.angle = 68;

// AXES
    var categoryAxis = chart.categoryAxis;
    categoryAxis.labelRotation = 1;
    categoryAxis.dashLength = 5;
    categoryAxis.gridPosition = "start";

// value
    var valueAxis = new AmCharts.ValueAxis();
    valueAxis.title = "Kshs";
    valueAxis.dashLength = 5;
    chart.addValueAxis(valueAxis);

// column GRAPH
    var graph1 = new AmCharts.AmGraph();
    graph1.type = "column";
    graph1.title = "Services";
    graph1.valueField = "Tot";
    graph1.balloonText = "[[category]]: Kshs [[value]]";
    graph1.lineAlpha = 0;
    graph1.fillAlphas = 1;

    chart.addGraph(graph1);

// LEGEND                
    var legend = new AmCharts.AmLegend();
    chart.addLegend(legend);
// WRITE
    chart.write("compare");

  });


  var chart;
  var legend;
  AmCharts.ready(function() {
// PIE CHART
    chart = new AmCharts.AmPieChart();
    chart.dataProvider = m_sales;
    chart.titleField = "Month";
    chart.valueField = "Tot";
    chart.outlineColor = "#FFFFFF";
    chart.outlineAlpha = 0.8;
    chart.outlineThickness = 2;
// this makes the chart 3D
    chart.depth3D = 15;
    chart.angle = 30;

// WRITE
    chart.write("chartdiv");

  });
</script>



