<%@page import="java.sql.*" %>
<%@page import="com.smartride.dao.CustomerDAO" %>
<%@page import="com.smartride.model.Customer" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<%
    // Get username from request
    String username = request.getParameter("username");

    if (username != null && !username.isEmpty()) {
        CustomerDAO customerDAO = new CustomerDAO();
        Customer customer = customerDAO.getCustomerByUsername(username);

        if (customer != null) {
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Delete Customer</h1>

        <p>Are you sure you want to delete the following customer?</p>
        <ul>
            <li><strong>Username:</strong> <%= customer.getUsername() %></li>
            <li><strong>Name:</strong> <%= customer.getFirstName() + " " + customer.getLastName() %></li>
            <li><strong>Email:</strong> <%= customer.getEmail() %></li>
            <li><strong>Phone:</strong> <%= customer.getPhoneNum() %></li>
        </ul>

        <form action="<%= request.getContextPath() %>/DeleteCustomerServlet" method="post">
            <input type="hidden" name="username" value="<%= customer.getUsername() %>">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="customerList.jsp" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>

<%
        } else {
            out.println("<p>Customer not found.</p>");
        }
    } else {
        out.println("<p>Invalid request. No username provided.</p>");
    }
%>
