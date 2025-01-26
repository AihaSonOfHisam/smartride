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
      <title>Available Vehicle</title>

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- availableCars css -->
      <link rel="stylesheet" href="css/availableCars.css"> 
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
      <!-- loader  -->
       <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
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
                              <a href="index.php"><img src="images/smartride.png" alt="#" /></a>
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
                                 <a class="nav-link" href="index.php">Home</a>
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
                     <h2>Available vEHICLE</h2>
                  </div>
               </div>
            </div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="search-label">  
						<div class="titlepage">
							<div class="search-container">
								Search Brand:
								<div class="search-box">
									<input type="text" name="searched_brand" id="search-brand" placeholder="Search..." />
								</div>
								<div class="sign_btn">
									<a id="search-btn" href="#">Search</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        
        <?php
         require_once('testdatabase.php'); // Include your database connection

         // Query to retrieve cars with status = 'available'
         $query = "SELECT * FROM car WHERE status = 'available'";
         $statement = oci_parse($dbconn, $query);
         oci_execute($statement);

         // Loop through the results and display each car
         while ($row = oci_fetch_assoc($statement)) {
             $carLabel = $row['BRAND'] . ' ' . $row['MODEL']; // Combine brand and model
            echo '
            <div class="car-container">
               <img class="car-image" src="images/' . htmlspecialchars($row['IMAGE_PATH']) .'">
               <div class="car-details">
                     <div class="car-label">' . htmlspecialchars($carLabel) . '</div>
                     <div class="car-info">Color: ' . htmlspecialchars($row['COLOUR']) . '</div>
                     <div class="car-info">Type: ' . htmlspecialchars($row['TYPE']) . '</div>
                     <div class="car-info">Transmission: ' . htmlspecialchars($row['TRANSMISSION']) . '</div>
                     <div class="car-info">' . htmlspecialchars($row['SEAT_NUM']) . ' Seater</div>
                     <div class="car-info">Price per Day: RM ' . htmlspecialchars($row['PRICE_PER_DAY']) . '</div>
                     <div class="car-info">Price per Week: RM ' . htmlspecialchars($row['PRICE_PER_WEEK']) . '</div>
                     <div class="car-info">Price per Month: RM ' . htmlspecialchars($row['PRICE_PER_MONTH']) . '</div>
                     <div class="select-btn"><a href="reserve.php?selected_plate_num=' . $row['PLATE_NUM'] . '">Select</a></div>
               </div>
            </div>
            ';
         }

         oci_free_statement($statement);
         oci_close($dbconn);
         ?>


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
                        <p>© 2024 All Rights Reserved. Designed by <a href="index.php">SmartRide Rental</a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
	  </section>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
	  <script>
		document.getElementById("search-btn").addEventListener("click", function() {
			var searched_brand = document.getElementById("search-brand").value;
			var url = "availablecars.html?searched_brand=" + encodeURIComponent(searched_brand);
			window.location.href = url;
		});
	  </script>
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
		<script>
	document.getElementById('loginButton').addEventListener('click', function() {
	  document.getElementById('loginOverlay').style.display = 'block';
	});

	document.getElementById('loginOverlay').addEventListener('click', function(e) {
	  if (e.target === this) {
		this.style.display = 'none';
	  }
	});
	</script>
	</body>
	</html>

