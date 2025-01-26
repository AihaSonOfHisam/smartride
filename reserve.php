<?php
    session_start([
      'cookie_lifetime' => 0,
      'cookie_secure' => true,
      'cookie_httponly' => true,
      'cookie_samesite' => 'Strict',
  ]); // Start the session (if not already started)

   // Implement session timeout
   $timeout = 1800; // 30 minutes
   if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
         session_unset();
         session_destroy();
         header("Location: Login/Login.html");
         exit();
   }
   $_SESSION['last_activity'] = time();

    if (isset($_SESSION['username'])) {
        // User is logged in, continue with the rest of the code
    } else {
        // User is not logged in, redirect to login page
        echo '<script>alert("Please log in to continue!"); window.location.href = "Login/Login.html";</script>';
    }
?>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Reservation</title>
	  <style>
    /* Form container styles */
.reservation-form {
    background-color: #222;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    margin: auto;
    color: #fff;
    font-family: 'Arial', sans-serif;
}

/* Form group spacing */
.form-group {
    margin-bottom: 15px;
}

/* Labels */
.form-group label {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
    color: #f6d601;
}

/* Inputs and select */
.reservation-form input,
.reservation-form select {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 2px solid #444;
    border-radius: 5px;
    background-color: #333;
    color: #fff;
}

.reservation-form input:focus,
.reservation-form select:focus {
    outline: none;
    border-color: #f6d601;
}

/* Button */
.btn.confirm-btn {
    width: 100%;
    padding: 10px;
    font-size: 18px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    background-color: #f6d601;
    color: #000;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn.confirm-btn:hover {
    background-color: #e5c000;
    color: #fff;
    transition: ease-in all 0.3s;
}

/* Responsive design */
@media (max-width: 768px) {
    .reservation-form {
        padding: 15px;
    }
}

    .car-container {
        display: flex;
        align-items: flex-start;
        margin-bottom: 40px;
        flex-wrap: wrap;
         /* Adjust the max-width as per your requirement */
    }

    .car-image {
        width: 520px;
        height: 350px;
        margin-right: 40px;
    }

    .car-details {
        flex-grow: 1;
    }

    .car-model {
        font-weight: bold;
        font-size: 24px;
		color: yellow;
        margin-bottom: 10px;
    }
	
	.search-container {
    display: inline-flex;
    gap: 10px;
	}

	
	.search-label {
        font-weight: bold;
        font-size: 28px;
		color: white;
        margin-bottom: 10px;
    }
	
	.search-box input[type="text"] {
    width: 300px;
    height: 44.74px;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 30px;
	}
	
	input[type="date"] {
	  width: 300px;
	  height: 44.74px;
	  padding: 8px;
	  font-size: 16px;
	  border: 1px solid #ccc;
	  border-radius: 30px;
	}

	
	.search-box input[type="number"] {
    width: 300px;
    height: 44.74px;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 30px;
	}
	
	.search-box select {
    width: 300px;
    height: 44.74px;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 30px;
    /* -webkit-appearance: none; */
    /* -moz-appearance: none; */
    /* appearance: none; */
    /* background: url('dropdown-icon.png') no-repeat right center; */
    /* background-size: 20px; */
    cursor: pointer;
	}



	.search-button {
		width: 100px;
		height: 40px;
		font-size: 16px;
		background-color: #f6d601;
		color: white;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

    .car-manufacturer {
        margin-bottom: 5px;
        font-size: 18px;
    }

    .car-year {
        margin-bottom: 5px;
        font-size: 18px;
    }

    .car-price {
        font-weight: bold;
        color: white;
        font-size: 20px;
    }

    .car-button {
        margin-top: 15px;
        font-size: 18px;
    }
</style>

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   </head>
   <!-- body -->
   <body class="main-layout">
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.html"><img src="images/smartride.png" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9" style="display: flex; align-items: center;">
                    <nav class="navigation navbar navbar-expand-md navbar-dark" style="align-items: center; margin-left: auto;">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        </button>
						 <button id="scrollToTop" title="Scroll to Top">↑</button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
							  <li class="nav-item">
                                 <a class="nav-link" href="index.html">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#section4">Contact us</a>
                              </li>
                           </ul>
                           <?php
                           if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                               echo '<div class="sign_btn"><a href="Login/logout.php">Log out</a></div>';
                           } else {
                               echo '<div class="sign_btn"><a href="Login/Login.html">Sign in</a></div>';
                           }
                           ?>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
<section id="section2">
      <div class="availableCar">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Reservation</h2>
                  </div>
               </div>
            </div>
            
            <?php
            require_once('testdatabase.php'); // Ensure this file contains the correct Oracle DB connection setup

            $selected_plate_num = $_GET['selected_plate_num'];
            $selected_plate_num = htmlspecialchars($selected_plate_num); // Prevent XSS

            // Query to fetch car details by plate number
            $query = "SELECT * FROM car WHERE plate_num = :plate_num";
            $statement = oci_parse($dbconn, $query);

            // Bind the plate number parameter
            oci_bind_by_name($statement, ":plate_num", $selected_plate_num);

            // Execute the query
            oci_execute($statement);

            // Fetch the result
            if ($row = oci_fetch_assoc($statement)) {
                $image_path = $row['IMAGE_PATH'];
                $brand = $row['BRAND'];
                $model = $row['MODEL'];
                $plate_num = $row['PLATE_NUM'];
                $colour = $row['COLOUR'];
                $type = $row['TYPE'];
                $seat_num = $row['SEAT_NUM'];
                $price_per_day = $row['PRICE_PER_DAY'];
                $price_per_week = $row['PRICE_PER_WEEK'];
                $price_per_month = $row['PRICE_PER_MONTH'];
                $status = $row['STATUS'];

                echo '<div class="car-container">';
                echo '<img class="car-image" src="images/' . htmlspecialchars($image_path) . '" alt="' . htmlspecialchars($model) . '">';

                echo '<div class="car-details">';
                echo '<div class="car-model">' . htmlspecialchars($brand) . ' ' . htmlspecialchars($model) . '</div>';
                echo '<div class="car-price">' . htmlspecialchars($colour) . '</div>';
                echo '<div class="car-price">' . htmlspecialchars($type) . '</div>';
                echo '<div class="car-price">' . htmlspecialchars($seat_num) . ' Seater' . '</div>';
                echo '<div class="car-price">Price per Day: RM' . htmlspecialchars($price_per_day) . '</div>';
                echo '<div class="car-price">Price per Week: RM' . htmlspecialchars($price_per_week) . '</div>';
                echo '<div class="car-price">Price per Month: RM' . htmlspecialchars($price_per_month) . '</div>';
                echo '</div>';
                echo '</div>';

                echo '<input type="hidden" name="selected_plate_num" value="' . htmlspecialchars($plate_num) . '">';
                // Add other hidden inputs if needed
            } else {
                echo 'Car not found!';
            }

            // Free resources and close the Oracle connection
            oci_free_statement($statement);
            oci_close($dbconn);
            ?>

            <form action="confirmreserve.PHP" method="post" class="reservation-form">
            <input type="hidden" name="selected_plate_num" value="<?php echo htmlspecialchars($plate_num); ?>">
                <div class="form-group">
                    <label for="rent_duration">Rent Duration (1, 2, 3, ...):</label>
                    <input type="number" name="rent_duration" id="rent_duration" placeholder="Enter Rent Duration" required />
                </div>

                <div class="form-group">
                    <label for="rent_type">Rent Duration Type:</label>
                    <select id="rent_type" name="rent_type">
                        <option value="days">Days</option>
                        <option value="weeks">Weeks</option>
                        <option value="months">Months</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_rent_date">Start Rent Date:</label>
                    <input type="date" name="start_rent_date" id="start_rent_date" required />
                </div>
                <br>

                <button type="submit" class="btn confirm-btn">Confirm</button><br>
            </form>

         </div>
      </div>
</section>
        
      <!--  footer -->
      <section id="section4">
        <footer>
           <div class="footer">
              <div class="container">
                 <div class="row">
                    <div class="col-md-12">
                       <div class="cont_call">
                          <h3> <strong class="multi color_chang"> Call Us</strong><br>
                             
                          </h3>
                       </div>
                       <div class="cont">
                          <h3>(+60) 196046742 smartride@gmail.com</h3>
                          <h3> <strong class="multi">SmartRide</strong> 
                             UiTM Shah Alam Malaysia
                          </h3>
                       </div>
                    </div>
                 </div>
              </div>
              <div class="copyright">
                 <div class="container">
                    <div class="row">
                       <div class="col-md-12">
                          <p>© 2024 All Rights Reserved. Designed by <a href="index.html">SmartRide Rental</a></p>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
        </footer>
        </section>
      <!-- end footer -->
      <!-- Javascript files-->
      <!-- <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script> -->
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
	  <script>
	  // Smooth scrolling to section
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});
    </script>
	
	<script>
        var today = new Date().toISOString().split("T")[0];
        document.getElementById("start_rent_date").setAttribute("min", today);
    </script>
	
	<script>
	// Show the "Scroll to Top" button when user scrolls down
window.addEventListener('scroll', function() {
  var scrollToTopButton = document.getElementById('scrollToTop');
  if (window.pageYOffset > 0) {
    scrollToTopButton.classList.add('fade-in');
    scrollToTopButton.classList.remove('fade-out');
    scrollToTopButton.style.display = 'block';
  } else {
    scrollToTopButton.classList.remove('fade-in');
    scrollToTopButton.classList.add('fade-out');
    setTimeout(function() {
      scrollToTopButton.style.display = 'none';
    }, 400); // Fade-out duration should match transition duration in CSS
  }
});

// Scroll to top when the button is clicked
document.getElementById('scrollToTop').addEventListener('click', function() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});


</script>
	</body>
	</html>

