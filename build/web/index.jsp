<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" session="true" %>
<%@ page import="java.util.*" %>
<%@ page import="java.sql.*" %>

<!-- If user didnt login yet, go to login page -->
<%
    if (session == null || session.getAttribute("username") == null) {
       response.sendRedirect("Login/Login.jsp");
        return;
    }
%>
        
<%
    // Set session timeout (30 minutes)
    int timeout = 1800; // 1800 seconds = 30 minutes
    session.setMaxInactiveInterval(timeout);

    // Check last activity
    Long lastActivity = (Long) session.getAttribute("last_activity");
    if (lastActivity != null && (System.currentTimeMillis() - lastActivity) > (timeout * 1000)) {
        session.invalidate();
        response.sendRedirect("Login/Login.html");
        return;
    }
    session.setAttribute("last_activity", System.currentTimeMillis());

    // Check if user is logged in
    String username = (String) session.getAttribute("username");
%>




<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>SmartRide Rental</title>
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

                                  <%-- Show "My Booking" only if the user is logged in --%>
                                  <% if (username != null && !username.isEmpty()) { %>
                                  <li class="nav-item">
                                      <a class="nav-link" href="MyBooking.jsp">My Booking</a>
                                  </li>
                                  <% } %>
                              </ul>

                              <!-- Sign in/Logout button -->
                              <% if (username != null && !username.isEmpty()) { %>
                              <div class="sign_btn">
                                  <a href="#" onclick="confirmLogout()">Log out</a>
                              </div>
                              <% } else { %>
                              <div class="sign_btn">
                                  <a href="Login/Login.jsp">Sign in</a>
                              </div>
                              <% }%>
                          </div>

                          <script>
                              function confirmLogout() {
                                  if (confirm("Are you sure you want to log out?")) {
                                      window.location.href = "<%= request.getContextPath()%>/LogoutServlet";
                                  }
                              }
                          </script>
                      </nav>

                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div class="container">
            <div class="row d_flex">
               <div class="col-md-12">
                  <div class="text-bg">
                     <h1>SmartRide Rental</h1>
                     <strong>Discover the Freedom of the Open Road of Selangor</strong>
                     <span>Rent Your Dream Vehicle Today!</span>
                     <a href="carList.jsp">Available Vehicle</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
     
      <!-- car -->
	  <section id="section1">
      <div  class="car">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>VARIETY OF VEHICLE</h2>
                     <span>Our car rental company is proud to offer a diverse fleet of vehicles, including cars, and SUVs, exclusively serving the area of Selangor. Whether you're planning a solo trip and require a compact car, embarking on a family vacation and need a spacious SUV, or seeking a rugged truck for an adventurous weekend, we have the ideal vehicle to fulfill your requirements. Rest assured that our well-maintained vehicles are ready to provide a perfect ride for your next journey in Selangor.</span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4 padding_leri">
                  <div class="car_box">
                     <figure><img src="images/alphard.png" alt="#"/></figure>
                     <h3>Toyota</h3>
                  </div>
               </div>
               <div class="col-md-4 padding_leri">
                  <div class="car_box">
                     <figure><img src="images/axianew.png" alt="#"/></figure>
                     <h3>Perodua</h3>
                  </div>
               </div>
               <div class="col-md-4 padding_leri">
                  <div class="car_box">
                     <figure><img src="images/car_img3.png" alt="#"/></figure>
                     <h3>Proton</h3>
                  </div>
               </div>
            </div>
         </div>
      </div>
	  </section>
      <!-- end car -->
      <!-- choose  section -->
      <div class="choose ">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage1">
                     <h2>Why Choose Us</h2>
					 <p></p>
                     <span>We understand that you have a choice when it comes to renting a vehicle. That's why we're committed to providing you with the best possible experience from start to finish.</span>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="choose_box">
                     <span>01</span>
                     <p>Our number one priority is making sure that our customers are satisfied with their rental experience. From the moment you contact us to reserve a vehicle to the moment you return it, our team will be there to answer any questions you may have and provide assistance whenever you need it.</p>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="choose_box">
                     <span>02</span>
                     <p>We know that every customer has different needs when it comes to renting a vehicle. That's why we offer a wide selection of cars, trucks, and SUVs to choose from. Whether you need a small car for a weekend getaway or a large SUV for a family road trip, we have the perfect vehicle for you.</p>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="choose_box">
                     <span>03</span>
                     <p>We understand that renting a vehicle can be expensive, which is why we offer competitive pricing on all of our rentals. We believe that everyone should have access to reliable transportation at an affordable price.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end choose  section -->

      
      <!--  footer -->
      <section id="section4">
	  <footer style="margin-top: 0;">
         <div class="footer">
            <div class="cutomer" style="margin-top: 0;">
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
        <script src="js/script.js"></script>
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

