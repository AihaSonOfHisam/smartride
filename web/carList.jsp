<%@ page import="java.util.List" %>
<%@ page import="com.smartride.model.Car" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>

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

<html>
<head>
    <title>Available Cars</title>
    <link rel="stylesheet" href="css/availableCars.css">
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
<body>
    <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="index.jsp"><img src="images/smartride.png" alt="#" /></a>
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
                           <!--<ul class="navbar-nav mr-auto">
                              <li class="nav-item">
                                 <a class="nav-link" href="#section1">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#section4">Contact us</a>
                              </li>
                           </ul>--!>
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
      <section class="banner_main">
         <div class="container">
            <div class="row d_flex">
               <div class="col-md-12">
                  <div class="text-bg">
                     <h1 class="search-label">AVAILABLE VEHICLE</h1>
                      <form action="carlist" method="get">
                        <label for="search" class="car-label">Search Brand:</label>
                        <input type="text" id="search" name="search" class="search-box" placeholder="Search...">
                        <button type="submit" class="search-button">Search</button>
                    </form>
                  </div>
               </div>
            </div>
         </div>
      </section>

    <section class="car-list">
    <%
        List<Car> carList = (List<Car>) request.getAttribute("carList");
        if (carList == null || carList.isEmpty()) {
    %>
        <p class="car-info">No cars available or data retrieval failed.</p>
    <%
        } else {
            for (Car car : carList) {
    %>
    <div class="car-container">
        <!-- Car Details Section -->
        <div class="car-details">
            <h2 class="car-model"><%= car.getBrand() + " " + car.getModel() %></h2>
            <p class="car-info">Color: <%= car.getColour() %></p>
            <p class="car-info">Type: <%= car.getType() %></p>
            <p class="car-info">Transmission: <%= car.getTransmission() %></p>
            <p class="car-info">Seats: <%= car.getSeatNum() %></p>
            <p class="car-info">Price per Day: RM<%= car.getPricePerDay() %></p>
            <p class="car-info">Price per Week: RM<%= car.getPricePerWeek() %></p>
            <p class="car-info">Price per Month: RM<%= car.getPricePerMonth() %></p>
        </div>

        <!-- Button Section -->
        <div class="button-container">
            <form action="carDetail" method="get">
               <input type="hidden" name="plateNum" value="<%= car.getPlateNum() %>">
               <button type="submit" class="book-btn">Book Now</button>
           </form>
        </div>
    </div>
    <%
            }
        }
    %>
</section>
</body>
</html>
