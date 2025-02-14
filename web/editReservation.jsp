<%@ page import="com.smartride.model.Reservation" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>

<%
    // Check if user is logged in
    if (session == null || session.getAttribute("username") == null) {
        response.sendRedirect("Login/Login.jsp");
        return;
    }

    // Set session timeout (30 minutes)
    int timeout = 1800; // 1800 seconds = 30 minutes
    session.setMaxInactiveInterval(timeout);
    session.setAttribute("last_activity", System.currentTimeMillis());

    // Retrieve reservation details from request
    Reservation reservation = (Reservation) request.getAttribute("reservation");
    if (reservation == null) {
        response.sendRedirect("myBooking.jsp");
        return;
    }
%>
<html>
<head>
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Edit Reservation</h2>
        <form action="UpdateReservationServlet" method="post">
            <input type="hidden" name="reservationId" value="<%= reservation.getReservationId() %>">

            <div class="form-group">
                <label>Plate Number:</label>
                <input type="text" class="form-control" value="<%= reservation.getPlateNum() %>" disabled>
            </div>

            <div class="form-group">
                <label>Duration Type:</label>
                <select class="form-control" name="rentDurationType">
                    <option value="daily" <%= reservation.getRentDurationType().equals("daily") ? "selected" : "" %>>Daily</option>
                    <option value="weekly" <%= reservation.getRentDurationType().equals("weekly") ? "selected" : "" %>>Weekly</option>
                    <option value="monthly" <%= reservation.getRentDurationType().equals("monthly") ? "selected" : "" %>>Monthly</option>
                </select>
            </div>

            <div class="form-group">
                <label>Duration:</label>
                <input type="number" class="form-control" name="rentDuration" value="<%= reservation.getRentDuration() %>" required>
            </div>

            <div class="form-group">
                <label>Start Date:</label>
                <input type="date" class="form-control" name="startRentDate" value="<%= reservation.getStartRentDate() %>" required>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select class="form-control" name="status">
                    <option value="Pending" <%= reservation.getStatus().equals("Pending") ? "selected" : "" %>>Pending</option>
                    <option value="Confirmed" <%= reservation.getStatus().equals("Confirmed") ? "selected" : "" %>>Confirmed</option>
                    <option value="Cancelled" <%= reservation.getStatus().equals("Cancelled") ? "selected" : "" %>>Cancelled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Reservation</button>
            <a href="myBookings.jsp" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
