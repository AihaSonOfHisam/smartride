<%@ page import="java.sql.*, com.smartride.dao.ReservationDAO" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<%
    // Retrieve parameters safely with defaults
    String brand = request.getParameter("brand");
    String model = request.getParameter("model");
    String colour = request.getParameter("colour");
    String plateNum = request.getParameter("plateNum");
    String type = request.getParameter("type");
    String transmission = request.getParameter("transmission");

    // Handle seatNum safely
    int seatNum = 4; // Default to 4 seats
    String seatNumParam = request.getParameter("seatNum");
    if (seatNumParam != null && !seatNumParam.isEmpty()) {
        try {
            seatNum = Integer.parseInt(seatNumParam);
        } catch (NumberFormatException e) {
            out.println("<p style='color:red;'>Invalid seat number. Using default: 4</p>");
        }
    }

        // Handle days safely
    int days = 1; // Default to 1 day
    String daysParam = request.getParameter("days");
    if (daysParam != null && !daysParam.isEmpty()) {
        try {
            days = Integer.parseInt(daysParam);
        } catch (NumberFormatException e) {
            out.println("<p style='color:red;'>Invalid number of days. Using default: 1</p>");
        }
    }

    

    // Handle pricing safely
    double pricing = 0.0;
    String pricingParam = request.getParameter("pricing");
    if (pricingParam != null && !pricingParam.isEmpty()) {
        try {
            pricing = Double.parseDouble(pricingParam);
        } catch (NumberFormatException e) {
            out.println("<p style='color:red;'>Invalid pricing. Using default: 0.0</p>");
        }
    }

    // Retrieve rentDurationType safely
    String rentDurationType = request.getParameter("rentDurationType");
    if (rentDurationType == null  || rentDurationType.isEmpty()) {
        rentDurationType = "Daily"; // Default to "Daily"
    }

    // Check if user is logged in
    if (session == null || session.getAttribute("username") == null) {
        response.sendRedirect("Login/Login.jsp");
        return;
    }

    // Set session timeout (30 minutes)
    int timeout = 1800; // 1800 seconds = 30 minutes
    session.setMaxInactiveInterval(timeout);

    // Handle session activity tracking
    Long lastActivity = (Long) session.getAttribute("last_activity");
    if (lastActivity != null && (System.currentTimeMillis() - lastActivity) > (timeout * 1000)) {
        session.invalidate();
        response.sendRedirect("Login/Login.jsp");
        return;
    }
    session.setAttribute("last_activity", System.currentTimeMillis());

    // Retrieve username
    String username = (String) session.getAttribute("username");
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Reservation</title>
    <link rel="stylesheet" href="css/ConfirmReservation.css">
</head>
<body>

    <%-- Display Alert Message if Exists --%>
    <%
        String message = (String) session.getAttribute("message");
        if (message != null) {
    %>
        <div class="alert"><%= message %></div>
    <%
            session.removeAttribute("message"); // Clear message after displaying
        }
    %>

    <div class="reservation-container">
        <h2>CONFIRM RESERVATION</h2>

        <p><strong>Username:</strong> <%= username != null ? username : "Guest" %></p>
<div class="car-detail">
            <div class="car-info">
                <h3><%= brand %> <%= model %></h3>
                <p><strong>Color:</strong> <%= colour %></p>
                <p><strong>Type:</strong> <%= type %></p>
                <p><strong>Transmission:</strong> <%= transmission %></p>
                <p><strong>Seating Capacity:</strong> <%= seatNum %></p>
                <p><strong>Duration Type:</strong> <%= rentDurationType %></p>
                <p><strong>Duration:</strong> <%= days %></p>
                
    
        </div>

        <div class="buttons">
            <form action="carList.jsp" method="post">
                <button type="submit" class="cancel-btn">Cancel</button>
            </form>
            <form action="ConfirmReservationServlet" method="post">
                <input type="hidden" name="username" value="<%= username %>">
                <input type="hidden" name="plateNum" value="<%= plateNum %>">
                <input type="hidden" name="rentDurationType" value="<%= rentDurationType %>">
                <input type="hidden" name="rentDuration" value="<%= days %>">
                <input type="hidden" name="startRentDate" value="<%= new java.sql.Date(System.currentTimeMillis()) %>">
                <input type="hidden" name="status" value="Pending">
        
                <button type="submit" class="proceed-btn">Confirm</button>
            </form>
        </div>
    </div>

</body>
</html>