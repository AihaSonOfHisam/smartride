package com.smartride.controller;

import com.smartride.dao.CustomerDAO;
import com.smartride.model.Customer;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

public class LoginServlet extends HttpServlet {
    
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        String username = request.getParameter("username");
        String password = request.getParameter("password");
        
        boolean isValid = new CustomerDAO().validateLogin(username, password);
        
        if (isValid) {
            // Retrieve user details
            Customer customer = new CustomerDAO().getCustomerByUsername(username);

            // Create session
            HttpSession session = request.getSession();
            session.setAttribute("user", customer);
            session.setAttribute("username", username); // Store username separately

            System.out.println("Login successful for user: " + username);
            response.sendRedirect("index.jsp"); // Redirect to user dashboard
        } else {
            // Pass error message as a URL parameter
            response.sendRedirect("Login/Login.jsp?error=Invalid+username+or+password");
        }
    }
}
