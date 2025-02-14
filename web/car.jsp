<%@ page import="java.sql.*" %>
<%@page import="com.smartride.dao.CarDAO" %>
<%@page import="com.smartride.model.Car" %>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Car List</h1>

        <a href="addCar.jsp" class="btn btn-success mb-4">Add New Car</a>
        <a href="adminDashboard.jsp" class="btn btn-success mb-4">Back</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Colour</th>
                    <th>Plate Number</th>
                    <th>Type</th>
                    <th>Seat Number</th>
                    <th>Transmission</th>
                    <th>Price per Day</th>
                    <th>Price per Week</th>
                    <th>Price per Month</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <%
                    Connection conn = null;
                    PreparedStatement stmt = null;
                    ResultSet rs = null;
                    
                    try {
                        Class.forName("org.apache.derby.jdbc.ClientDriver"); // Load Derby Driver
                        conn = DriverManager.getConnection("jdbc:derby://localhost:1527/SmartRideDB", "app", "app");
                        String sql = "SELECT * FROM car";
                        stmt = conn.prepareStatement(sql);
                        rs = stmt.executeQuery();
                        
                        while (rs.next()) {
                %>
                <tr>
                    <td><%= rs.getString("brand") %></td>
                    <td><%= rs.getString("model") %></td>
                    <td><%= rs.getString("colour") %></td>
                    <td><%= rs.getString("plate_num") %></td>
                    <td><%= rs.getString("type") %></td>
                    <td><%= rs.getInt("seat_num") %></td>
                    <td><%= rs.getString("transmission") %></td>
                    <td><%= rs.getBigDecimal("price_per_day") %></td>
                    <td><%= rs.getBigDecimal("price_per_week") %></td>
                    <td><%= rs.getBigDecimal("price_per_month") %></td>
                    <td><%= rs.getString("status") %></td>
                    <td>
                        <a href="editCar.jsp?plateNum=<%= rs.getString("plate_num")%>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm" 
                           onclick="confirmDelete('<%= rs.getString("plate_num")%>')">
                            Delete
                        </a>
                    </td>

            <script>
                function confirmDelete(plateNum) {
                    if (confirm('Are you sure you want to delete this car?')) {
                        window.location.href = 'DeleteCarServlet?plateNum=' + plateNum;
                    }
                }
            </script>

                <%
                        }
                    } catch (Exception e) {
                        e.printStackTrace();
                    } finally {
                        if (rs != null) rs.close();
                        if (stmt != null) stmt.close();
                        if (conn != null) conn.close();
                    }
                %>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
