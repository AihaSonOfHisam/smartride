<!DOCTYPE html>
<html lang="en" >
	
<head>
  <meta charset="UTF-8">
  <title>CodePen - Daily UI #002 Credit Card Checkout</title>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
<link rel="stylesheet" href="./css/style payment.css">
<style>
.center-input {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Adjust the height as needed */
}
</style>
</head>
<body>
<!-- partial:index.partial.html -->
<div id="wrapper">
	<div id="container">
		<div id="left-col">
		<div id="left-col-cont">
			<h2>Summary</h2>
			<div class="car">
				<?php
				require_once('testdatabase.php');

				// // Retrieve reservation ID and selected plate number from the previous page
				// $selected_plate_num = $_POST['selected_plate_num']; 
				// $reservation_id = $_POST['reservation_id']; 
				$reservation_id = $_GET['reservation_id'];
				$selected_plate_num = $_GET['selected_plate_num'];

				// Fetch reservation details using reservation_id
				$reservation_query = "SELECT rent_duration_type, rent_duration, start_rent_date FROM reservation WHERE reservation_id = :reservation_id";
				$reservation_statement = oci_parse($dbconn, $reservation_query);
				oci_bind_by_name($reservation_statement, ":reservation_id", $reservation_id);
				oci_execute($reservation_statement);

				if ($reservation_row = oci_fetch_assoc($reservation_statement)) {
					$rent_type = $reservation_row['RENT_DURATION_TYPE'];
					$rent_duration = $reservation_row['RENT_DURATION'];
					$start_rent_date = $reservation_row['START_RENT_DATE'];
				} else {
					echo '<p>Reservation details not found.</p>';
					exit();
				}

				// Fetch car details using the selected plate number
				$car_query = "SELECT * FROM car WHERE plate_num = :plate_num";
				$car_statement = oci_parse($dbconn, $car_query);
				oci_bind_by_name($car_statement, ":plate_num", $selected_plate_num);
				oci_execute($car_statement);

				if ($car_row = oci_fetch_assoc($car_statement)) {
					$image_path = $car_row['IMAGE_PATH'];
					$brand = $car_row['BRAND'];
					$model = $car_row['MODEL'];
					$price_per_day = $car_row['PRICE_PER_DAY'];
					$price_per_week = $car_row['PRICE_PER_WEEK'];
					$price_per_month = $car_row['PRICE_PER_MONTH'];
				?>
					<div class="img-col">
						<img src="images/<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($model); ?>" />
					</div>

					<div class="meta-col" style="width: 200px;">
						<h3><?php echo htmlspecialchars($brand) . ' ' . htmlspecialchars($model); ?></h3>
						<p class="price" style="color: rgb(255, 255, 255);">
							Duration: <?php echo htmlspecialchars($rent_duration) . ' ' . htmlspecialchars(ucfirst($rent_type)); ?><br>
							Start Date: <?php echo htmlspecialchars(date("j F Y", strtotime($start_rent_date))); ?>
						</p>
					</div>
				<?php
				} else {
					echo '<p>Car details not found.</p>';
				}

				// Free resources
				oci_free_statement($reservation_statement);
				oci_free_statement($car_statement);
				oci_close($dbconn);
				?>
			</div>
			<br><br><br><br>
			<p id="total">Total Amount:</p>
			<h4 id="total-price"><span>RM </span>
				<?php // Calculate the total price based on the rent type
               $total_amount = 0;
               if ($rent_type == 'days') {
                  $total_amount = $price_per_day * $rent_duration;
               } elseif ($rent_type == 'weeks') {
                  $total_amount = $price_per_week * $rent_duration;
               } elseif ($rent_type == 'months') {
                  $total_amount = $price_per_month * $rent_duration;
               }
			   
			   echo htmlspecialchars(number_format($total_amount, 2)); ?>
			</h4>
		</div>
	</div>

		<div id="right-col">
			<h2>Payment</h2>
			<div id="logotype">
				<img id="mastercard" src="./images/mastercard.png" alt="" />
			</div>
			<div id="logotype2">
				<img id="mastercard" src="./images/visa.jpg" alt="" />
			</div>
			
			<form action="paymentprocess.php" method="post">
				<!-- Hidden inputs to pass required values -->
				<input type="hidden" name="total_amount" value="<?php echo htmlspecialchars(number_format($total_amount, 2)); ?>">
				<input type="hidden" name="selected_plate_num" value="<?php echo htmlspecialchars($selected_plate_num); ?>">
				<input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($reservation_id); ?>">

				<!-- Cardnumber input -->
				<label for="">Cardnumber</label>
				<input id="cardnumber"
					type="text" 
					maxlength="16" 
					minlength="16" 
					placeholder="Enter 16-digit card number" 
					pattern="\d{16}" 
					title="Please enter exactly 16 digits" 
				/>

				<!-- Cardholder Name input -->
				<label for="">Cardholder Name</label>
				<input id="cardholder" type="text" placeholder="Enter cardholder name" />

				<!-- Expiration Date inputs -->
				<div class="left">
					<label for="">Expiration Date</label>
					<select name="month" id="month" onchange="" size="1">
						<option value="00">Month</option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="year" id="year" onchange="" size="1">
						<option value="01">Year</option>
						<option value="2024">2024</option>
						<option value="2025">2025</option>
						<option value="2026">2026</option>
						<option value="2027">2027</option>
						<option value="2028">2028</option>
						<option value="2029">2029</option>
						<option value="2030">2030</option>
						<option value="2031">2031</option>
						<option value="2032">2032</option>
						<option value="2033">2033</option>
						<option value="2034">2034</option>
					</select>
				</div>

				<!-- CVC input -->
				<div class="right">
					<label id="cvc-label" for="">CVC <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
					<input id="cvc" type="text" placeholder="123" maxlength="3" />
				</div>

				<!-- Submit button -->
				<button id="purchase" type="submit">Pay</button>
			</form>
		</div>
	</div>
</div>
<!-- partial -->




</body>
</html>
