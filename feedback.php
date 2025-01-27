<?php
session_start([
   'cookie_lifetime' => 0,
   'cookie_secure' => true,
   'cookie_httponly' => true,
   'cookie_samesite' => 'Strict',
]);
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
      <title>Available Cars</title>
	  <style>
    .car-container {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
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
	
    body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container1 {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
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
                                 <a class="nav-link" href="#section1">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#section4">Contact us</a>
                              </li>
                           </ul>
                           <?php
                           // Implement session timeout
                           $timeout = 1800; // 30 minutes
                           if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
                               session_unset();
                               session_destroy();
                               header("Location: Login/Login.html");
                               exit();
                           }
                           $_SESSION['last_activity'] = time();
                           
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
                     <h2>Add Feedback</h2>
                  </div>
               </div>
            </div>
			<div class="container1">
			  <form action="feedbackprocess.php" method="post"">
				<label for="username">Username</label>
				<input type="text" id="username" name="username" placeholder="Username" required="">

				<label for="email">Email</label>
				<input type="text" id="email" name="email" placeholder="Email" required="">
				
				<label for="subject">Feedback</label>
				<textarea id="subject" name="feedback" placeholder="Write something.." style="height:200px" required=""></textarea>

				<input type="submit" value="Submit">
			  </form>
			</div>
		 </div>
	  </div>
</section>
        
      <!--  footer -->
      <section id="section4">
	  <footer>
         <div class="footer">
            <div class="cutomer">
               <div class="row">
                  <div class="col-md-12">
                     <div class="cont_call">
                     <h3>
                        <strong class="multi">Call Us</strong><br>
                     </h3>

                     </div>
                     <div class="cont">
                        <h3> 
                        <span style="color: white;">(+60) 196046742 smartride@gmail.com</span>
                        </h3>
                        <h3> <strong class="multi">SmartRide</strong> 
                        <span style="color: white;">UiTM Shah Alam Malaysia</span>
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
	   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#feedbackForm').submit(function(e) {
                e.preventDefault();

                // Get the feedback text entered by the user
                var feedbackText = $('#feedbackText').val();

                // Perform any validation or additional processing here before submitting

                // Send an AJAX request to the backend to store the feedback in the database
                // You need to implement the backend API endpoint to handle this

                // For demonstration purposes, let's assume the feedback is successfully stored

                // Display a success message or perform any desired action
                $('.feedback-container').html('<p>Feedback submitted successfully!</p>');
            });
        });
    </script>
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

