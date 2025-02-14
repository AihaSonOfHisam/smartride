<%@ page import="com.smartride.model.Car" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>

<%
    Car car = (Car) request.getAttribute("car");
    if (car == null) {
        response.sendRedirect("carList.jsp");
        return;
    }
%>

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
<html>
<head>
    <title>Reservation</title>
    <link rel="stylesheet" href="css/availableCars.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/carReservation.css">

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
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" 
                                    aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            </button>

                            <div class="collapse navbar-collapse" id="navbarsExample04">
                                <ul class="navbar-nav mr-auto">
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
                            </div> <!-- ✅ Properly closed the collapse navbar -->

                        </nav>

                        <!-- Moved scroll button outside the navbar to avoid conflicts -->
                        <button id="scrollToTop" title="Scroll to Top">↑</button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "<%= request.getContextPath()%>/LogoutServlet";
            }
        }
    </script>
<script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "<%= request.getContextPath()%>/LogoutServlet";
            }
        }
    </script>


    <section class="reservation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>RESERVATION</h1>
                    <div class="car-detail">
                        <h2><%= car.getBrand() + " " + car.getModel() %></h2>
                        <p>Color: <%= car.getColour() %></p>
                        <p>Type: <%= car.getType() %></p>
                        <p>Transmission: <%= car.getTransmission() %></p>
                        <p>Seats: <%= car.getSeatNum() %></p>
                        <p>Price per Day: RM<%= car.getPricePerDay() %></p>
                        <p>Price per Week: RM<%= car.getPricePerWeek() %></p>
                        <p>Price per Month: RM<%= car.getPricePerMonth() %></p>
                    </div>

                    <form action="ConfirmReservation.jsp" method="post">
                        <input type="hidden" name="plateNum" value="<%= car.getPlateNum() %>">
                        <input type="hidden" name="brand" value="<%= car.getBrand() %>">
                        <input type="hidden" name="model" value="<%= car.getModel() %>">
                        <input type="hidden" name="colour" value="<%= car.getColour() %>">
                        <input type="hidden" name="type" value="<%= car.getType() %>">
                        <input type="hidden" name="transmission" value="<%= car.getTransmission() %>">
                        <input type="hidden" name="seatNum" value="<%= car.getSeatNum() %>">
                        <input type="hidden" name="pricing" value="<%= car.getPricePerDay() %>">

                          <label for="durationType">Duration Type:</label>
                             <select id="durationType" name="rentDurationType" required>
                              <option value="Daily">Daily</option>
                               <option value="Weekly">Weekly</option>
                               <option value="Monthly">Monthly</option>
                             </select>   
                       
                        <label for="days">Number of Days:</label>
                        <input type="number" id="days" name="days" min="1" required>

                        <label>Start Rent Date:</label>
                        <input type="date" name="startDate" required>

                        <button type="submit" class="btn btn-warning">Confirm</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
</body>
</html>