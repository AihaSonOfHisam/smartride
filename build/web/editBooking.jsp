<%@ page import="com.smartride.dao.ReservationDAO" %>
<%@ page import="com.smartride.model.Reservation" %>

<%
    String reservationIdParam = request.getParameter("reservationId");

    if (reservationIdParam == null || reservationIdParam.isEmpty()) {
        response.sendRedirect("MyBookings.jsp?error=invalid_id");
        return;
    }

    int reservationId = Integer.parseInt(reservationIdParam);
    ReservationDAO reservationDAO = new ReservationDAO();
    Reservation reservation = reservationDAO.getReservationById(reservationId);

    if (reservation == null) {
        response.sendRedirect("MyBookings.jsp?error=not_found");
        return;
    }
%>


<%
    if (session == null || session.getAttribute("username") == null) {
        response.sendRedirect("Login/Login.jsp");
        return;
    }
    
    int timeout = 1800;
    session.setMaxInactiveInterval(timeout);
    Long lastActivity = (Long) session.getAttribute("last_activity");
    if (lastActivity != null && (System.currentTimeMillis() - lastActivity) > (timeout * 1000)) {
        session.invalidate();
        response.sendRedirect("Login/Login.jsp");
        return;
    }
    session.setAttribute("last_activity", System.currentTimeMillis());
    String username = (String) session.getAttribute("username");
%>

<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="css/availableCars.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="css/carReservation.css">
</head>
<body>
    <header>
        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col logo_section">
                        <div class="logo">
                            <a href="index.jsp"><img src="images/smartride.png" alt="SmartRide" /></a>
                        </div>
                    </div>
                    <div class="col">
                        <nav class="navigation">
                            <% if (username != null && !username.isEmpty()) { %>
                            <div class="sign_btn">
                                <a href="#" onclick="confirmLogout()">Log out</a>
                            </div>
                            <% } else { %>
                            <div class="sign_btn">
                                <a href="Login/Login.jsp">Sign in</a>
                            </div>
                            <% } %>
                        </nav>
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
        <h2 class="text-center">Edit Booking</h2>
        <form action="UpdateReservationServlet" method="post">
            <input type="hidden" name="reservationId" value="<%= reservation.getReservationId() %>">
            <input type="hidden" name="username" value="<%= username %>">

            <label for="plateNum">Plate Number:</label>
            <input type="text" id="plateNum" name="plateNum" value="<%= reservation.getPlateNum() %>" readonly>

            <label for="rentDurationType">Duration Type:</label>
            <select id="rentDurationType" name="rentDurationType" required>
                <option value="Daily" <%= reservation.getRentDurationType().equals("Daily") ? "selected" : "" %>>Daily</option>
                <option value="Weekly" <%= reservation.getRentDurationType().equals("Weekly") ? "selected" : "" %>>Weekly</option>
                <option value="Monthly" <%= reservation.getRentDurationType().equals("Monthly") ? "selected" : "" %>>Monthly</option>
            </select>

            <label for="rentDuration">Duration:</label>
            <input type="number" id="rentDuration" name="rentDuration" min="1" value="<%= reservation.getRentDuration() %>" required>

            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" value="<%= reservation.getStartRentDate() %>" required>

            <button type="submit" class="btn btn-warning">Update Booking</button>
            <a href="MyBooking.jsp" class="btn btn-secondary">Cancel</a>
        </form>
    </section>
</body>
</html>
