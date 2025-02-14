<%@ page import="java.sql.*" %>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@page import="com.smartride.dao.CustomerDAO" %>
<%@page import="com.smartride.model.Customer" %>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">Customer List</h1>
        <a href="addCustomer.jsp" class="btn btn-success mb-4">Add Customer</a>
         <a href="adminDashboard.jsp" class="btn btn-success mb-4">Back</a>
        
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Password</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <%
                    // Database connection parameters
                    String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
                    String JDBC_USER = "app";
                    String JDBC_PASSWORD = "app";
                    
                    Connection conn = null;
                    Statement stmt = null;
                    ResultSet rs = null;

                    try {
                        // Load database driver
                        Class.forName("org.apache.derby.jdbc.ClientDriver");
                        
                        // Establish connection
                        conn = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
                        
                        // Create statement and execute query
                        stmt = conn.createStatement();
                        String sql = "SELECT * FROM customers";
                        rs = stmt.executeQuery(sql);

                        // Iterate through results and display in table
                        while (rs.next()) {
                %>
                <tr>
                    <td><%= rs.getString("username") %></td>
                    <td><%= rs.getString("first_name") %></td>
                    <td><%= rs.getString("last_name") %></td>
                    <td><%= rs.getString("email") %></td>
                    <td><%= rs.getString("phone_num") %></td>
                    <td><%= rs.getString("address") %></td>
                    <td><%= rs.getString("gender") %></td>
                    <td><%= rs.getString("password") %></td>
                    <td>
                        <a href="editCustomer.jsp?username=<%= rs.getString("username") %>" class="btn btn-primary">Edit</a>
                      <form action="<%= request.getContextPath() %>/DeleteCustomerServlet" method="post" style="display:inline;">
    <input type="hidden" name="username" value="<%= rs.getString("username") %>">
    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?');">
        Delete
    </button>
</form>


                    </td>
                </tr>
                <%
                        }
                    } catch (Exception e) {
                        out.println("<tr><td colspan='9' class='text-danger'>Error: " + e.getMessage() + "</td></tr>");
                    } finally {
                        // Close resources
                        if (rs != null) rs.close();
                        if (stmt != null) stmt.close();
                        if (conn != null) conn.close();
                    }
                %>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
