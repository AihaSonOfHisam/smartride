package com.smartride.controller;

import java.io.*;
import java.sql.*;
import javax.servlet.*;
import javax.servlet.annotation.*;
import javax.servlet.http.*;

public class AdminReservationServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    // Database connection details for Derby
    private static final String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String JDBC_USER = "app";
    private static final String JDBC_PASSWORD = "app";
    
    // Utility method to get a connection to Derby database
    private static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
    }

    // DoPOST method to handle delete and verify actions
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Get the action and reservationId from the form
        String action = request.getParameter("action");
        int reservationId = Integer.parseInt(request.getParameter("reservationId"));
        
        // Initialize database resources
        Connection conn = null;
        PreparedStatement stmt = null;
        
        try {
            // Get connection
            conn = getConnection();

            // Perform action based on the 'action' parameter (delete or verify)
            if ("delete".equals(action)) {
                // SQL query to delete a reservation
                String deleteSQL = "DELETE FROM reservation WHERE reservation_id = ?";
                stmt = conn.prepareStatement(deleteSQL);
                stmt.setInt(1, reservationId);
                stmt.executeUpdate();
            } else if ("verify".equals(action)) {
                // SQL query to update reservation status to 'returned'
                String verifySQL = "UPDATE reservation SET status = 'Approved' WHERE reservation_id = ?";
                stmt = conn.prepareStatement(verifySQL);
                stmt.setInt(1, reservationId);
                stmt.executeUpdate();
            }
            
            // Redirect to refresh the reservation list after action
            response.sendRedirect("reserveList.jsp");
        } catch (SQLException e) {
            e.printStackTrace();
            // Optionally, handle error gracefully (e.g., show an error message)
        } finally {
            // Close database resources
            try {
                if (stmt != null) stmt.close();
                if (conn != null) conn.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }
    
    // DoGet method if you want to use it for GET requests (e.g., display the list of reservations)
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // This can be used to show the list of reservations (if needed)
        // Currently, it redirects to the same page where the list is displayed
        response.sendRedirect("reserveList.jsp");
    }
}
