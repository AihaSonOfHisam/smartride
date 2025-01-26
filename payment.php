<!DOCTYPE html>
<html lang="en" >
	
<head>
  <meta charset="UTF-8">
  <title>CodePen - Daily UI #002 Credit Card Checkout</title>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'><link rel="stylesheet" href="./css/style payment.css">
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
					
					<div class="img-col">
						<img src="./images/myvi.png" alt="" />
					</div>

					<div class="meta-col" style="width: 200px;">
						<h3>Perodua Myvi</h3>
						<p class="price" style="color: rgb(255, 255, 255);">
							Duration: 1 Week<br>
							Start Date: 1 January 2025
						</p>
					</div>
				</div>
				<br><br><br><br>
				<p id="total">
				Total Amount: 
				</p>
				<h4 id="total-price"><span>RM </span>750</h4>
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
			
			<form action="index.html" method="post">
				<label for="">Cardnumber</label>
				
					<input id="cardnumber"
						type="text" 
						maxlength="16" 
						minlength="16" 
						placeholder="Enter 16-digit card number" 
						pattern="\d{16}" 
						title="Please enter exactly 16 digits" 
						 />
				
				<label for="">Cardholder Name</label>
				<input id="cardholder" type="text" placeholder="Enter cardholder name"  />
				<div class="left">
					<label for="">Expiration Date</label>
					<select name="month" id="month" onchange="" size="1" >
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
					<select name="year" id="year" onchange="" size="1" >
					<option value="01">Year</option>
    				<option value="02">2024</option>
    				<option value="03">2025</option>
    				<option value="04">2026</option>
    				<option value="05">2027</option>
    				<option value="06">2028</option>
    				<option value="07">2029</option>
    				<option value="08">2030</option>
    				<option value="09">2031</option>
    				<option value="10">2032</option>
					<option value="10">2033</option>
					<option value="10">2034</option>
					</select>
				</div>
				
				<div class="right">
					<label id="cvc-label" for="">CVC <i class="fa fa-question-circle-o" aria-hidden="true"></i></label>
					<input id="cvc" type="text" placeholder="123" maxlength="3"  />
				</div>
				<button id="purchase" type="submit">Pay</button>

			</form>
		</div>
	</div>
</div>
<!-- partial -->




</body>
</html>
