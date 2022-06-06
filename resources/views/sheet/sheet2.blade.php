<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>RMO Monitoring System</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/jpg" href="../RMO-icon.jpg"/>
  <!-- Fontawesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <!-- Bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Main Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!--Main CSS-->
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">

  <style>
    .table thead th {
      border: 2px solid #dee2e6;
    }

    .table tbody tr {
      background-color: unset;
    }

    .table thead {
      background-color: unset;
      color: unset;
    }

    .table td {
      padding: 0.75rem;
    }

    @media print {
     #printPageButton {
       display: none;
     }
     @page { margin: 0; }
      body { margin: 1.6cm; }
    }
  </style>
</head>

<body>
          <!-- Start of content table -->
          <div class="container py-4 px-4">
                <!-- new code here for generate output -->
                <div class="card-body py-4 text-center">
                  <div class="row pb-3">
                    <div class="col-6">
                      <p>Name of SUC: <b>BULACAN STATE UNIVERSITY</b></p>
                    </div>
                    <div class="col-6">
                      <p>Region: <b>III</b></p>
                    </div>
                  </div>
                  <h3>SUMMARY SHEET</h3>
                  <h3 class="pb-4">FORM SL KRA 2.1b Percentage of Researchers</h3>

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col"><b>PERIOD COVERED</b></th>
                        <th scope="col"><b>NUMBER OF RESEARCHERS**</b></th>
                        <th scope="col"><b>NUMBER OF PLANTILLA FACULTY MEMBERS</b></th>
                        <th scope="col"><b>% OF RESEARCHERS TO TOTAL PLANTILLA</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Col1</td>
                        <td>Col2</td>
                        <td>Col3</td>
                        <td>(Col2/Col3)*100</td>
                      </tr>
                      
                      <tr>
                       
                        <td>{{ $year1 }}</td>
                        <td>{{ $total1 }}</td>
                        <td>{{ $faculty_no }}</td>
                        <td>{{ $percent1 }}</td>
                      </tr>
                      <tr>
                        
                        <td>{{ $year2 }}</td>
                        <td>{{ $total2 }}</td>
                        <td>{{ $faculty_no }}</td>
                        <td>{{ $percent2 }}</td>
                      </tr>
                      <tr>
                     
                        <td>{{ $year3 }}</td>
                        <td>{{ $total3}}</td>
                        <td>{{ $faculty_no }}</td>
                        <td>{{ $percent3 }}</td>
                      </tr>
                      <tr>
                        <td colspan="4"></td>
                        <td><b>EQUIVALENT POINTS</b></td>
                      </tr>

                      <tr>
                        <td colspan="3"><p class="text-right m-0"><b>AVERAGE %</b></p></td>
                        <td>{{ $ave }}</td>
                        <td>0.25</td>
                    
                      </tr>
                    </tbody>

                  </table>
                  <!-- date today -->
                  <p class="pt-4 small text-left"><b>**as of {{ $formatdate }}; only researchers with at least 2 research works considered per guidelines</b></p> 

                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col"></th>
                        <th scope="col">Prepared by:</th>
                        <th scope="col">Certified True and Correct:</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Signature</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Printed Name</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Designation</td>
                        <td>Research Director or its equivalent</td>
                        <td>Head of the SUC</td>
                      </tr>
                      <tr>
                        <td>Date</td>
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          </div>
          <div class="text-center"><button id="printPageButton" class="btn btn-primary px-4 mb-4" onClick="window.print();">Print</button></div>



<!-- Bootstrap JS-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Custom JS-->
<script src="../js/vendor/modernizr-3.11.2.min.js"></script>
<script src="../js/plugins.js"></script>
<script src="../js/main.js"></script>

<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
