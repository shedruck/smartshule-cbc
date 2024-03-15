  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <div class="tools hidden-print">
      <div class="panel panel-primary">
          <div class="panel-heading">Student Analysis</div>
          <div class="panel-body">
              <?php echo form_open(current_url()) ?>
              <table class="table table-bordered">
                  <tr>
                      <th>Student<span class="required">*</span></th>
                      <th>Class</th>
                      <th>Term</th>
                  </tr>
                  <tr>
                      <td>
                          <?php echo form_dropdown('student', ['' => ''] + $students, $this->input->post('student'), 'class="select" required') ?>
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
                      <th>Exam <span class="required">*</span></th>
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
                          <?php
                            $exm = [1 => 'Opener Exam', 2 => 'Mid Term', 3 => 'End Term'];
                            echo form_dropdown('exam', ['' => ''] +  $exm, $this->input->post('exam'), 'class="select" required') ?>
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
            $std = isset($students[$post->student]) ? $students[$post->student] : '';
        }
        ?>

      <div class="row">
          <div class="col-xm-12">
              <div class="col-xm-4"></div>
              <div class="col-xm-4">
                  <center>
                      <img src="<?php echo base_url('uploads/files/' . $this->school->document) ?>" style="width:80px">
                      <h4><?php echo $this->school->school ?></h4>
                      <h3>STUDENT ANALYSIS FOR <?php echo $std ?></h3>
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
                  <th></th>


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
                                      <td>Score</td>
                                      <td>Grade</td>
                                  </tr>
                                  <?php
                                    $grade_count = [];
                                    foreach ($payload as $yr => $load) {
                                        foreach ($load as $tm => $loads) {
                                            foreach ($loads as $sub => $sc) {
                                                $grade_count[$cl][] = $sc;
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


          <div class="row">
              <div class="col-md-12 col-xs-12">
                  <?php



                    $dd = [];

                    foreach ($results as $class => $yearData) {


                        foreach ($yearData as $year => $termData) {
                            foreach ($termData as $term => $subjectData) {
                                foreach ($subjectData as $subject => $grades) {
                                    $dd[$class] = $subjectData;
                                }
                            }
                        }
                    }




                    ?>


                        <h1>Grade Analyis</h1>

                  <table class="table">
                      <thead>
                          <tr>
                              <th>Class</th>
                              <?php
                                foreach ($map_grades as $k => $v) {
                                    echo '<th>' . $v . '</th>';
                                }
                                ?>
                          </tr>
                      </thead>

                      <tbody>
                          <?php
                            $scoreCounts = [
                                '4' => 0,
                                '3' => 0,
                                '2' => 0,
                                '1' => 0,
                            ];
                            foreach ($grade_count as $kl => $rr) {

                            ?>


                              <tr>
                                  <td><?php echo isset($this->streams[$kl])  ? $this->streams[$kl] : '' ?></td>
                                  <?php
                                    foreach ($rr as $kk => $t) 
                                    {
                                        if ($t == 4) 
                                        {
                                            $scoreCounts['4']++;
                                        } 
                                        elseif ($t == 3) 
                                        {
                                            $scoreCounts['3']++;
                                        } 
                                        elseif ($t == 2) 
                                        {
                                            $scoreCounts['2']++;
                                        } elseif ($t == 1) 
                                        {
                                            $scoreCounts['1']++;
                                        }
                                    }

                                    foreach($map_grades as $score => $grades)
                                    {
                                        $tot =  isset($scoreCounts[$score]) ? $scoreCounts[$score] : '';
                                        ?>
                                        <td><?php echo $tot?></td>
                                    <?php }
 
                                    ?>
                              </tr>
                          <?php }
                            ?>
                      </tbody>
                  </table>


              </div>


          </div>

          <h1>Graphical Representation</h1>
          <div class="row">
              <div class="col-md-12 col-xs-12">

                  <canvas id="averageSubjectChart" width="400" height="200"></canvas>

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
                      label: 'Subject Score',
                      data: averages,
                      backgroundColor: '#2C7BE5'
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
                              text: 'Score'
                          }
                      }
                  },
                  plugins: {
                      title: {
                          display: true,
                          text: 'Subject Scores',
                          responsive: true
                      }
                  }
              }
          });
      </script>





  </div>