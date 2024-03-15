<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="invoice">
  <div class="row row-fluid">

    <div class="col-md-6" style="border-left: 1px solid #ccc; height: 180px;">
      <div id="chart"></div>
      <?php

      // Individual means for subjects
      $individual_means = [
        "english" => 75,
        "kisw" => 85,
        "maths" => 70,
        // Add more subjects as needed
      ];

      // Class means for subjects
      $class_means = [
        "english" => 80,
        "kisw" => 82,
        "maths" => 78,
        // Add more subjects as needed
      ];


      ?>
      <script>
        var options = {
          series: [{
            name: 'Individual Means',
            data: <?php echo json_encode(array_values($individual_means)); ?>
          }, {
            name: 'Class Means',
            data: <?php echo json_encode(array_values($class_means)); ?>
          }],
          chart: {
            height: 200,
            width: 450,
            type: 'area',
            zoom: {
              enabled: false
            }
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            curve: 'smooth'
          },
          xaxis: {
            type: 'category',
            categories: <?php echo json_encode(array_keys($individual_means)); ?>
          },
          tooltip: {
            x: {
              format: 'dd/MM/yy HH:mm'
            },
          },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      </script>

    </div>
  </div>
</div>

<script>
  $(document).ready(
    function() {
      $(".tsel").select2({
        'placeholder': 'Please Select',
        'width': '200px'
      });
      $(".tsel").on("change", function(e) {
        notify('Select', 'Value changed: ' + e.added.text);
      });
      $(".fsel").select2({
        'placeholder': 'Please Select',
        'width': '400px'
      });
      $(".fsel").on("change", function(e) {
        notify('Select', 'Value changed: ' + e.added.text);
      });
    });
</script>

<style>
  .report-form {
    padding: 10px;

  }

  .remarks h3 {
    margin-bottom: 10px;
  }

  .signature {
    border-bottom: 2px solid black;
    padding-top: 50px;

  }

  .table-row {
    margin-top: 20px;
  }

  .custom-table {
    border: 2px solid black;
    background-color: white;
    /* Set border to black */
  }

  .custom-table th,
  .custom-table td {
    border: 2px solid black;
    /* Set border for table cells to black */
  }

  .bg-light {

    background-color: #e0eaf1;
    color: black;
    border-radius: 2px;
    height: 70px;
    margin-top: 20px;
    padding-top: 5px;


  }

  .profile {
    margin-left: 0%;
    width: 180px;
    height: 180px;
    overflow: hidden;
    border: 2px solid white;

  }

  .profile-pic {
    width: 100%;
    height: auto;
  }

  .blue-bg {
    background-color: #7fc1fc;
    color: white;
    padding: 10px;
    height: 40px;
    text-align: center;
    font-size: medium;
    font-family: sans-serif;
  }

  .blue-text {
    color: #7fc1fc;
    font-size: medium;
    font-weight: bold;


  }

  .text-right {
    padding-top: 0px;
  }

  .logo {
    margin-top: 10px;
  }

  .details {
    margin-right: 1px;
  }

  .xxd,
  .editableform textarea {
    height: 150px !important;
  }

  .editable-container.editable-inline {
    width: 89%;
  }

  .col-sm-2 {
    width: 16.66666667%;
  }

  .col-sm-8 {
    width: 66.66666667%;
  }

  .editable-input {
    display: inline;
    width: 89%;
  }

  .editableform .form-control {
    width: 89%;
  }

  .invoice {
    padding: 20px;
  }

  .topdets {
    width: 85%;
    margin: 6px auto;
    border: 0;
  }

  .topdets th,
  .topdets td,
  .topdets {
    border: 0;
  }

  .morris-hover {
    position: absolute;
    z-index: 1000;
  }

  .morris-hover.morris-default-style {
    border-radius: 10px;
    padding: 6px;
    color: #666;
    background: rgba(255, 255, 255, 0.8);
    border: solid 2px rgba(230, 230, 230, 0.8);
    font-family: sans-serif;
    font-size: 12px;
    text-align: center;
  }

  .morris-hover.morris-default-style .morris-hover-row-label {
    font-weight: bold;
    margin: 0.25em 0;
  }

  .morris-hover.morris-default-style .morris-hover-point {
    white-space: nowrap;
    margin: 0.1em 0;
  }

  .tablex {
    width: 95% !important;
    margin: auto 15px !important;
    border: 1px solid #000 !important;
  }

  .tablex tr {
    border: 1px solid #000 !important;
  }

  .tablex td {
    border: 1px solid #000;
  }

  .tablex th {
    border: 1px solid #000 !important;
  }

  .page-break {
    margin-bottom: 15px;
  }

  .dropped {
    border-bottom: 3px solid silver !important;
  }

  legend {
    width: auto;
    padding: 4px;
    margin-bottom: 0;
    border: 0;
    font-size: 11px;
  }

  fieldset {
    padding: 5px;
    border: 1px solid silver;
    border-radius: 7px;
  }

  @media print {
    .invoice {
      padding: 20px !important;
    }

    .text-right {
      padding-top: 0px;
    }

    .col-md-6 {
      width: 50%;

    }

    .row {
      width: 100%;
    }

    .logo {
      width: 50%;
    }



    .topdets {
      width: 85% !important;
      margin: auto 15px !important;
      border: 0;
    }

    .tablex {
      width: 100%;
    }

    .page-break {
      display: block;
      page-break-after: always;
      position: relative;
    }

    table td,
    table th {
      padding: 4px;
    }

    .editable-click,
    a.editable-click,
    a.editable-click:hover {
      text-decoration: none;
      border-bottom: none !important;
    }

    .dropped {
      border-bottom: 3px solid silver !important;
    }


    .row-fluid {
      width: 100%;
    }
  }
</style>