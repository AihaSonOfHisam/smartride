package com.smartride.controller;

import com.smartride.dao.CustomerDAO;
import com.smartride.model.Customer;
import com.smartride.util.PasswordUtil;

import javax.servlet.ServletException;

import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;


public class AddCustomerServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Get form parameters
        String username = request.getParameter("username");
        String firstName = request.getParameter("first_name");
        String lastName = request.getParameter("last_name");
        String email = request.getParameter("email");
        String phoneNum = request.getParameter("phone_num");
        String address = request.getParameter("address");
        String gender = request.getParameter("gender");
        String password = request.getParameter("password");

        // Hash the password for security
        String hashedPassword = PasswordUtil.hashPassword(password);

        // Create a Customer object
        Customer newCustomer = new Customer(username, firstName, lastName, email, phoneNum, address, gender, hashedPassword);

        // Add customer to database
        CustomerDAO customerDAO = new CustomerDAO();
        boolean isAdded = customerDAO.addCustomer(newCustomer);

        if (isAdded) {
            response.sendRedirect("customerList.jsp"); // Redirect to customer list if successful
        } else {
            response.getWriter().println("Error adding customer. Please try again.");
        }
    }
}
