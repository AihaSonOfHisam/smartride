package com.smartride.controller;

import com.smartride.dao.CustomerDAO;
import com.smartride.model.Customer;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

public class EditCustomerServlet extends HttpServlet {
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String username = request.getParameter("username");
        String firstName = request.getParameter("firstName");
        String lastName = request.getParameter("lastName");
        String email = request.getParameter("email");
        String phoneNum = request.getParameter("phoneNum");
        String address = request.getParameter("address");
        String gender = request.getParameter("gender");

        CustomerDAO customerDAO = new CustomerDAO();
        Customer customer = new Customer(username, firstName, lastName, email, phoneNum, address, gender, "");

        boolean updated = customerDAO.updateCustomer(customer);

        if (updated) {
            response.sendRedirect("customerList.jsp?success=Customer updated successfully");
        } else {
            response.sendRedirect("editCustomer.jsp?username=" + username + "&error=Update failed");
        }
    }
}
