package com.smartride.controller;

import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;


public class DeleteCustomerServlet extends HttpServlet {
    
    private static final String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
    private static final String JDBC_USER = "app";
    private static final String JDBC_PASSWORD = "app";

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Redirect GET request to POST method
        doPost(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String username = request.getParameter("username");

        try (Connection conn = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
             PreparedStatement stmt = conn.prepareStatement("DELETE FROM CUSTOMERS WHERE username = ?")) {

            stmt.setString(1, username);
            int rowsDeleted = stmt.executeUpdate();

            if (rowsDeleted > 0) {
                System.out.println("Customer deleted successfully.");
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        // Redirect back to customer list
        response.sendRedirect(request.getContextPath() + "/customerList.jsp");
    }
}
