package com.smartride.controller;

import com.smartride.dao.CustomerDAO;
import com.smartride.model.Customer;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.List;

public class CustomerListServlet extends HttpServlet {
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        CustomerDAO customerDAO = new CustomerDAO();
        List<Customer> customerList = customerDAO.getAllCustomers();
        
        // Store the customer list in session
        request.getSession().setAttribute("customerList", customerList);
        
        // Redirect to JSP to display the data
        response.sendRedirect("customerList.jsp");
    }
}
