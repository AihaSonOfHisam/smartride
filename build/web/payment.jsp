<%@ page import="com.smartride.dao.ReservationDAO" %>
<%@ page import="com.smartride.model.Reservation" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%@ page import="java.util.Date" %>

<%
    // Get reservationId from request
    String reservationIdStr = request.getParameter("reservationId");
    if (reservationIdStr == null || reservationIdStr.isEmpty()) {
%>
        <h2>Error: Reservation ID is missing.</h2>
<%
        return;
    }

    // Parse reservationId safely
    int reservationId = Integer.parseInt(reservationIdStr);
    ReservationDAO reservationDAO = new ReservationDAO();
    Reservation reservation = reservationDAO.getReservationById(reservationId);

    // Check if reservation exists
    if (reservation == null) {
%>
        <h2>Error: Reservation not found.</h2>
<%
        return;
    }

    // Get car details
    String plateNum = reservation.getPlateNum();
    double dailyRate = reservationDAO.getCarPrice(plateNum);  // Ensure this method exists in ReservationDAO.java
    int rentDuration = reservation.getRentDuration();
    double totalAmount = dailyRate * rentDuration;

    // Format date
    SimpleDateFormat sdf = new SimpleDateFormat("dd MMMM yyyy");
    String formattedStartDate = sdf.format(reservation.getStartRentDate());
%>

<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <link rel="stylesheet" type="text/css" href="style_payment.css">
</head>
<body>
    <div class="payment-container">
        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Plate Number:</strong> <%= plateNum %></p>
            <p><strong>Duration:</strong> <%= rentDuration %> Days</p>
            <p><strong>Start Date:</strong> <%= formattedStartDate %></p>
            <p><strong>Total Amount:</strong> RM <%= totalAmount %></p>
        </div>
        
        <div class="payment-form">
            <h2>Payment</h2>
            <form action="PaymentServlet" method="post">
                <input type="hidden" name="reservationId" value="<%= reservationId %>">
                <label>Card Number</label>
                <input type="text" name="cardNumber" required>
                
                <label>Cardholder Name</label>
                <input type="text" name="cardholderName" required>

                <label>Expiration Date</label>
                <input type="text" name="expirationMonth" placeholder="MM" required>
                <input type="text" name="expirationYear" placeholder="YYYY" required>

                <label>CVC</label>
                <input type="text" name="cvc" required>

                <button type="submit">Pay</button>
            </form>
        </div>
    </div>
</body>
</html>
