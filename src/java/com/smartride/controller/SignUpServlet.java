package com.smartride.controller;

import com.smartride.dao.CustomerDAO;
import com.smartride.model.Customer;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class SignUpServlet extends HttpServlet {
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        // Retrieve form data
        String username = request.getParameter("username");
        String firstName = request.getParameter("first_name");
        String lastName = request.getParameter("last_name");
        String email = request.getParameter("email");
        String phoneNum = request.getParameter("phone_num");
        String address = request.getParameter("address");
        String gender = request.getParameter("gender");
        String password = request.getParameter("password");

        // Debugging: Print values to console
        System.out.println("Received Registration Request:");
        System.out.println("Username: " + username);
        System.out.println("First Name: " + firstName);
        System.out.println("Last Name: " + lastName);
        System.out.println("Email: " + email);
        System.out.println("Phone: " + phoneNum);
        System.out.println("Address: " + address);
        System.out.println("Gender: " + gender);

        if (firstName == null || firstName.trim().isEmpty()) {
            System.out.println("Error: First Name is NULL or EMPTY");
        }
        if (lastName == null || lastName.trim().isEmpty()) {
            System.out.println("Error: Last Name is NULL or EMPTY");
        }

        // Validation: Prevent NULL values
        if (username == null || username.isEmpty()
                || password == null || password.isEmpty()
                || firstName == null || firstName.isEmpty()
                || lastName == null || lastName.isEmpty()
                || email == null || email.isEmpty()) {

            System.out.println("Error: Missing required fields");
            response.setContentType("text/html");
            response.getWriter().println("<script>");
            response.getWriter().println("alert('All fields are required!');");
            response.getWriter().println("history.back();");
            response.getWriter().println("</script>");
            return;
        }

        // Create new Customer object
        Customer newCustomer = new Customer(username, firstName, lastName, email, phoneNum, address, gender, password);
        System.out.println("New customer object created successfully");

        // Register customer using DAO
        CustomerDAO customerDAO = new CustomerDAO();
        boolean isRegistered = customerDAO.registerCustomer(newCustomer);

        if (isRegistered) {
            System.out.println("Registration successful!");
            response.sendRedirect("Login/Login.jsp");
        } else {
            System.out.println("Registration failed at DAO layer!");
            response.setContentType("text/html");
            response.getWriter().println("<script>");
            response.getWriter().println("alert('Registration failed! Try again.');");
            response.getWriter().println("history.back();");
            response.getWriter().println("</script>");
        }
    }

}
