<%@ page import="java.util.List" %>
<%@ page import="com.smartride.model.Reservation" %>
<%@ page import="com.smartride.dao.ReservationDAO" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<%
    // Redirect to login if not logged in
    if (session == null || session.getAttribute("username") == null) {
        response.sendRedirect("Login/Login.jsp");
        return;
    }

    // Set session timeout (30 minutes)
    int timeout = 1800;
    session.setMaxInactiveInterval(timeout);

    // Check last activity
    Long lastActivity = (Long) session.getAttribute("last_activity");
    if (lastActivity != null && (System.currentTimeMillis() - lastActivity) > (timeout * 1000)) {
        session.invalidate();
        response.sendRedirect("Login/Login.jsp");
        return;
    }
    session.setAttribute("last_activity", System.currentTimeMillis());

    // Retrieve username from session
    String username = (String) session.getAttribute("username");

    // Retrieve reservations
    ReservationDAO reservationDAO = new ReservationDAO();
    List<Reservation> reservations = reservationDAO.getReservationsByUsername(username);
%>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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

    
    <section class="container mt-5">
        <h2 class="text-center">My Bookings</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Plate Number</th>
                    <th>Duration Type</th>
                    <th>Duration</th>
                    <th>Start Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <% if (reservations == null || reservations.isEmpty()) { %>
                    <tr><td colspan="7" class="text-center">No bookings found.</td></tr>
                <% } else { %>
                    <% for (Reservation reservation : reservations) { %>
                        <tr>
                            <td><%= reservation.getReservationId() %></td>
                            <td><%= reservation.getPlateNum() %></td>
                            <td><%= reservation.getRentDurationType() %></td>
                            <td><%= reservation.getRentDuration() %></td>
                            <td><%= reservation.getStartRentDate() %></td>
                            <td><%= reservation.getStatus() %></td>
                             <td>
                                 <a href="editBooking.jsp?reservationId=<%= reservation.getReservationId()%>" 
                                    class="btn btn-warning btn-sm">Edit</a>
                                    <form action="DeleteReservationServlet" method="post">
                                        <input type="hidden" name="reservationId" value="<%= reservation.getReservationId()%>">
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</button>
                                    </form>

                            </td>
                        </tr>
                    <% } %>
                <% } %>
            </tbody>
        </table>
    </section>
</body>
</html>
