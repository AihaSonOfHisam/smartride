<%@ page import="com.smartride.model.Customer" %>
<%@ page import="com.smartride.dao.CustomerDAO" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>

<%
    String username = request.getParameter("username");
    CustomerDAO customerDAO = new CustomerDAO();
    Customer customer = customerDAO.getCustomerByUsername(username);

    if (customer == null) {
        response.sendRedirect("customerList.jsp"); // Redirect if user not found
        return;
    }
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Edit Customer</h1>
        <form action="EditCustomerServlet" method="post">
            <input type="hidden" name="username" value="<%= customer.getUsername() %>">

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="firstName" value="<%= customer.getFirstName() %>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="lastName" value="<%= customer.getLastName() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<%= customer.getEmail() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phoneNum" value="<%= customer.getPhoneNum() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<%= customer.getAddress() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select class="form-control" name="gender" required>
                    <option value="Male" <%= customer.getGender().equals("Male") ? "selected" : "" %>>Male</option>
                    <option value="Female" <%= customer.getGender().equals("Female") ? "selected" : "" %>>Female</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="customerList.jsp" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
