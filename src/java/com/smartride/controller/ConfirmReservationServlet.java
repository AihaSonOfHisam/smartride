package com.smartride.controller;

import com.smartride.dao.ReservationDAO;
import com.smartride.model.Reservation;
import java.io.IOException;
import java.sql.Date;
import java.time.LocalDate;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

public class ConfirmReservationServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        
        HttpSession session = request.getSession(false); // Prevents creating a new session
        if (session == null || session.getAttribute("username") == null) {
            response.sendRedirect("login.jsp");
            return;
        }
        
        String daysParam = request.getParameter("rentDuration");
        String rentDurationType = request.getParameter("rentDurationType"); // Get the duration type (Daily, Weekly, Monthly)

        // Retrieve username from session
        String username = (String) session.getAttribute("username");

        // Retrieve form parameters
        String plateNum = request.getParameter("plateNum");
        int days = (daysParam != null && !daysParam.isEmpty()) ? Integer.parseInt(daysParam) : 1; // Default value
        if (rentDurationType == null || rentDurationType.isEmpty()) {
            rentDurationType = "Daily"; // Default to Daily if no value is passed
        }
        
        LocalDate startDate = LocalDate.now(); // Booking starts today
        String status = "Pending"; // Initial booking status

        // Create Reservation object
        Reservation reservation = new Reservation(0, username, plateNum, rentDurationType, days, Date.valueOf(startDate), status);

        // Save to database
        ReservationDAO reservationDAO = new ReservationDAO();
        boolean success = reservationDAO.saveReservation(reservation);

        // Generate JavaScript alert message and redirect
        response.setContentType("text/html");
        String message = success ? "Your booking has been saved successfully!" : "Failed to save your booking. Please try again.";
        
        response.getWriter().println("<script type='text/javascript'>"
                + "alert('" + message + "');"
                + "window.location.href='index.jsp';"
                + "</script>");
    }
}
