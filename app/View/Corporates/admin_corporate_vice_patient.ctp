<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            h1 {
                font-size: 24px;
                color: #333;
                background-color: #f8f9fa;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            }
            
            .table {
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }
            
            .table thead th {
                text-align: center;
                background-color: #343a40;
                color: #fff;
            }
            
            .table-hover tbody tr:hover {
                background-color: #f1f1f1;
            }
            
            .table-responsive {
                margin: 20px 0;
            }
            
        </style>
    </head>
    <body>
   <h1 style="text-align: center; margin: 20px 0;">Monthly Patient Count </h1>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                 <th>Sr. No.</th>
                <!--<th>TariffStandard ID</th>-->
                <th>TariffStandard Name</th>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <th><?php echo date('F', mktime(0, 0, 0, $month, 1)); ?></th>
                <?php endfor; ?>
                <th>Yearly Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $dataByTariffStandard = [];
            $monthlyTotals = array_fill(1, 12, 0); // Initialize monthly totals for all months
            $yearlyTotal = 0;

            // Prepare the data for each tariff and each month
            foreach ($monthlyPatientCounts as $data) {
                $tariffId = $data['TariffStandard']['id'];
                $month = $data[0]['month'];
                $patientCount = $data[0]['patient_count'];

                // Organize data for easier display
                if (!isset($dataByTariffStandard[$tariffId])) {
                    $dataByTariffStandard[$tariffId] = array_fill(1, 12, 0); // Initialize months
                    $dataByTariffStandard[$tariffId]['name'] = $data['TariffStandard']['name'];
                }
                $dataByTariffStandard[$tariffId][$month] = $patientCount;
                
                // Update monthly total
                $monthlyTotals[$month] += $patientCount;
                $yearlyTotal += $patientCount;
            }
  $srNo = 1;
            // Render the table rows for each tariff
            foreach ($dataByTariffStandard as $tariffId => $data):
            ?>
                <tr>
                    <td><?php echo $srNo++; ?></td> 
                    <!--<td><?php echo h($tariffId); ?></td>-->
                    <td><?php echo h($data['name']); ?></td>
                    <?php $monthlyTotal = 0; ?>
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <td><?php echo h($data[$month]); ?></td>
                        <?php $monthlyTotal += $data[$month]; ?>
                    <?php endfor; ?>
                    <td><?php echo h($monthlyTotal); ?></td> <!-- Total for this tariff -->
                </tr>
            <?php endforeach; ?>
        </tbody>

        <!-- Monthly Total Row -->
        <tfoot>
            <tr>
                <td colspan="2"><strong>Monthly Total</strong></td>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <td><strong><?php echo h($monthlyTotals[$month]); ?></strong></td>
                <?php endfor; ?>
                <td><strong><?php echo h($yearlyTotal); ?></strong></td> <!-- Total for all tariffs -->
            </tr>
        </tfoot>
    </table>
</div>

    </body>
</html>