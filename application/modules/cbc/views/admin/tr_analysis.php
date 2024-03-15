  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <div class="tools hidden-print">
      <div class="panel panel-primary">
          <div class="panel-heading">Teacher Analysis</div>
          <div class="panel-body">
              <?php echo form_open(current_url()) ?>
              <table class="table table-bordered">
                  <tr>
                      <th>Teacher<span class="required">*</span></th>
                      <th>Class</th>
                      <th>Term</th>
                  </tr>
                  <tr>
                      <td>
                          <?php echo form_dropdown('teacher', ['' => ''] + $teachers, $this->input->post('class'), 'class="select" required') ?>
                      </td>
                      <td>
                          <?php echo form_dropdown('class', ['' => ''] +  $this->streams, $this->input->post('class'), 'class="select"') ?>
                      </td>
                      <td>
                          <?php echo form_dropdown('term', ['' => ''] +  $this->terms, $this->input->post('term'), 'class="select"') ?>
                      </td>
                  </tr>
                  <tr>
                      <th>Year</th>
                      <th>Action</th>
                  </tr>
                  <tr>
                      <td>

                          <?php
                            $range = range(date('Y') - 5, date('Y'));
                            $yrs = array_combine($range, $range);
                            krsort($yrs);
                            echo form_dropdown('year', ['' => ''] +  $yrs, $this->input->post('year'), 'class="select"') ?>
                      </td>

                     

                      <td>
                          <button class="btn btn-primary" type="submit">Filter</button>

                          <button class="btn btn-success" type="button" onclick="window.print()">Print</button>
                      </td>
                  </tr>
              </table>
              <?php echo form_close() ?>
          </div>
      </div>
  </div>


  <div class="invoice">

      <?php
        if ($this->input->post()) {
            $post = (object) $this->input->post();
            $tr = isset($teachers[$post->teacher]) ? $teachers[$post->teacher] : '';
        }
        ?>

      <div class="row">
          <div class="col-xm-12">
              <div class="col-xm-4"></div>
              <div class="col-xm-4">
                  <center>
                      <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                      <h4><?php echo $this->school->school ?></h4>
                      <h3>TEACHER ANALYSIS FOR <?php echo strtoupper($tr)?></h3>
                      <hr>

                  </center>
              </div>
              <div class="col-xm-3"></div>
          </div>
      </div>

      <?php
        if (isset($results)) {

        ?>

          <table class="table table-bordered">
              <thead>
                  <th>#</th>
                  <th>Class</th>
                  <th>Details</th>

              </thead>
              <tbody>
                  <?php
                    $index = 1;
                    foreach ($results as $cl => $payload) {

                    ?>

                      <tr>
                          <td><?php echo $index ?></td>
                          <td><?php echo isset($this->streams[$cl]) ? $this->streams[$cl]  : '' ?></td>
                          <td>
                              <table class="table table-bordered">
                                  <tr>
                                      <td>Learning Area</td>
                                      <td>Year</td>
                                      <td>Term</td>
                                      <td>Average</td>
                                      <td>Grade</td>
                                  </tr>
                                  <?php
                                    foreach ($payload as $yr => $load) {
                                        foreach ($load as $tm => $loads) {
                                            foreach ($loads as $sub => $sc) {
                                                $grad = isset($map_grades[$sc]) ? $map_grades[$sc] : ''
                                    ?>
                                              <tr>
                                                  <td><?php echo isset($subjects[$sub]) ? $subjects[$sub] : '' ?></td>
                                                  <td><?php echo $yr ?></td>
                                                  <td><?php echo $tm ?></td>
                                                  <td><?php echo $sc ?></td>
                                                  <td><?php echo $grad ?></td>
                                              </tr>

                                  <?php }
                                        }
                                    } ?>
                              </table>
                          </td>

                      </tr>

                  <?php $index++;
                    } ?>
              </tbody>
          </table>

          <hr>

          <?php
            $labels = [];
            $averages = [];

            foreach ($results as $cl => $yearData) {
                foreach ($yearData  as  $yrr => $termData) {


                    foreach ($termData as  $trm => $tmm) {
                        foreach ($tmm as $subjec => $p) {
                            $klas = isset($this->streams[$cl]) ? $this->streams[$cl] : 'Class';
                            $sbjs = isset($subjects[$subjec]) ? $subjects[$subjec] : 'Subject';
                            $labels[] = "$klas-$yrr-$trm: $sbjs";
                            $averages[] = $p;
                        }
                    }
                }
            }


            $labelsJSON = json_encode($labels);
            $averagesJSON = json_encode($averages);


            ?>


          <hr>

          <h1>Graphical Representation</h1>

          <div class="row">
              <div class="col-md-6 col-xs-12">

                  <canvas id="averageSubjectChart" width="400" height="200"></canvas>

              </div>

              <div class="col-md-6 hidden-print">

                  <canvas id="pieChart" width="200" height="200"></canvas>

              </div>

          </div>

      <?php  } ?>






      <script>
          // Use PHP-generated data in JavaScript
          var labels = <?php echo $labelsJSON; ?>;
          var averages = <?php echo $averagesJSON; ?>;

          // Create a bar chart
          var ctx = document.getElementById('averageSubjectChart').getContext('2d');
          var averageSubjectChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: labels,
                  datasets: [{
                      label: 'Average Subject Score',
                      data: averages,
                      backgroundColor: '#27BCFD'
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true,
                          suggestedMax: 4,
                          title: {
                              display: true,
                              text: 'Average Score'
                          }
                      }
                  },
                  plugins: {
                      title: {
                          display: true,
                          text: 'Average Subject Scores',
                          responsive: true
                      }
                  }
              }
          });


          // perchart
          var data = {
              labels: labels,
              datasets: [{
                  data: averages, // Data values for each category
                  backgroundColor: ["red", "green", "blue"], // Colors for each category
              }]
          };

          // Create a pie chart
          var ctx = document.getElementById('pieChart').getContext('2d');
          var pieChart = new Chart(ctx, {
              type: 'pie',
              data: data,
              options: {
                  responsive: true,
                  title: {
                      display: true,
                      text: 'Average Scores'
                  }
              }
          });
      </script>





  </div>