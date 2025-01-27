<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .invoice {
      padding: 20px;
      background-color: #f9f9f9;
    }
    .invoice-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .invoice-header .logo {
      font-size: 24px;
      font-weight: bold;
    }
    .invoice-header .invoice-number {
      font-size: 18px;
      font-weight: bold;
    }
    .invoice-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }
    .invoice-info .info-block {
      width: 50%;
    }
    .invoice-table {
      width: 100%;
      border-collapse: collapse;
    }
    .invoice-table th,
    .invoice-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    .invoice-total {
      margin-top: 20px;
      text-align: right;
      font-weight: bold;
    }
    .print-button {
      text-align: right;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="invoice">
    <div class="invoice-header">
	<div class="logo">
        <img src="images/smartride.png" alt="#" />
    </div>
      <div class="invoice-number"><?php
        require_once('testdatabase.php');

        // Retrieve form data
        $reservation_id = $_REQUEST['reservation_id'];
        $payment_id = $_REQUEST['payment_id'];
        $total = $_REQUEST['total'];

        echo 'Invoice: ' . $payment_id;
      ?> </div>
    </div>

    <?php
    // Corrected Query for Car Plate Number
    $query = "SELECT c.plate_num
              FROM car c
              JOIN reservation r ON c.plate_num = r.plate_num
              WHERE r.reservation_id = :reservation_id";
    $stmt = oci_parse($dbconn, $query);
    oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
    oci_execute($stmt);

    if ($row = oci_fetch_assoc($stmt)) {
        $plate_num = $row['PLATE_NUM'];

        // Update car status
        $updateQuery = "UPDATE car SET status = 'in rent' WHERE plate_num = :plate_num";
        $stmt = oci_parse($dbconn, $updateQuery);
        oci_bind_by_name($stmt, ":plate_num", $plate_num);
        oci_execute($stmt);
    } else {
        echo "No data found for the provided reservation ID.";
    }
    ?>

    <div class="invoice-info">
      <div class="info-block">
        <strong>From:</strong><br>
        SmartRide Car Rental<br>
        UiTM Shah Alam<br>
        Selangor Malaysia
      </div>
      <div class="info-block">
        <strong>To:</strong>
        <?php
        // Corrected Query for Customer Data
        $query = "SELECT c.first_name, c.last_name, c.address, r.username
                  FROM customers c
                  JOIN reservation r ON c.username = r.username
                  WHERE r.reservation_id = :reservation_id";
        $stmt = oci_parse($dbconn, $query);
        oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
        oci_execute($stmt);

        if ($row = oci_fetch_assoc($stmt)) {
            $first_name = $row['FIRST_NAME'];
            $last_name = $row['LAST_NAME'];
            $address = $row['ADDRESS'];

            echo "<br>" . $first_name . " " . $last_name;
            echo "<br>" . $address;
        } else {
            echo "No data found for the provided reservation ID.";
        }
        ?>
      </div>
    </div>

    <table class="invoice-table">
      <thead>
        <tr>
          <th>Car Model</th>
          <th>Rent Duration</th>
          <th>Start Rent Date</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php
            // Corrected Query for Car Model
            $query = "SELECT c.brand, c.model
                      FROM car c
                      JOIN reservation r ON c.plate_num = r.plate_num
                      WHERE r.reservation_id = :reservation_id";
            $stmt = oci_parse($dbconn, $query);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
            oci_execute($stmt);

            if ($row = oci_fetch_assoc($stmt)) {
                $brand = $row['BRAND'];
                $model = $row['MODEL'];
                echo $brand . " " . $model;
            } else {
                echo "No data found for the provided reservation ID.";
            }
            ?></td>
          <td><?php
            // Corrected Query for Rent Duration
            $query = "SELECT rent_duration, rent_duration_type
                      FROM reservation
                      WHERE reservation_id = :reservation_id";
            $stmt = oci_parse($dbconn, $query);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
            oci_execute($stmt);

            if ($row = oci_fetch_assoc($stmt)) {
                $rent_duration = $row['RENT_DURATION'];
                $rent_duration_type = $row['RENT_DURATION_TYPE'];
                echo $rent_duration . " " . $rent_duration_type;
            } else {
                echo "No data found for the provided reservation ID.";
            }
            ?></td>
          <td><?php
            // Corrected Query for Start Rent Date
            $query = "SELECT start_rent_date
                      FROM reservation
                      WHERE reservation_id = :reservation_id";
            $stmt = oci_parse($dbconn, $query);
            oci_bind_by_name($stmt, ":reservation_id", $reservation_id);
            oci_execute($stmt);

            if ($row = oci_fetch_assoc($stmt)) {
                $start_rent_date = $row['START_RENT_DATE'];
                echo $start_rent_date;
            } else {
                echo "No data found for the provided reservation ID.";
            }
            ?></td>
          <td><?php echo "RM " . $total;?></td>
        </tr>
      </tbody>
    </table>

    <div class="invoice-total">
      <strong>Total: </strong><?php echo "RM " . $total; ?>
    </div>

    <div class="print-button">
      <button onclick="window.print()">Print to PDF</button>
    </div>
    <div class="print-button">
      <button onclick="window.location.href='index.php'">Return To Main Page</button>
    </div>

  </div>
</body>
</html>
