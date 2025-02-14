<%@ page import="java.sql.*, java.util.*" %>
<%@ page contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">Reservation List</h2>

        <a href="adminDashboard.jsp" class="btn btn-success mb-4">Back</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Reservation ID</th>
                    <th>Username</th>
                    <th>Plate Number</th>
                    <th>Rent Duration</th>
                    <th>Start Rent Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <%
                    // Initialize database connection
                    Connection conn = null;
                    Statement stmt = null;
                    ResultSet rs = null;

                    try {
                        // Database connection details for Derby
                        String JDBC_URL = "jdbc:derby://localhost:1527/SmartRideDB";
                        String JDBC_USER = "app";
                        String JDBC_PASSWORD = "app";

                        // Get connection to the database
                        conn = DriverManager.getConnection(JDBC_URL, JDBC_USER, JDBC_PASSWORD);
                        
                        // SQL query to fetch reservations
                        String sql = "SELECT * FROM reservation";
                        stmt = conn.createStatement();
                        rs = stmt.executeQuery(sql);

                        // Loop through result set and display reservations
                        while (rs.next()) {
                %>
                <tr>
                    <td><%= rs.getInt("reservation_id") %></td>
                    <td><%= rs.getString("username") %></td>
                    <td><%= rs.getString("plate_num") %></td>
                    <td><%= rs.getInt("rent_duration") %></td>
                    <td><%= rs.getDate("start_rent_date") %></td>
                    <td><%= rs.getString("status") %></td>
                    <td>
                        <form action="AdminReservationServlet" method="post" style="display: inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="reservationId" value="<%= rs.getInt("reservation_id")%>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</button>
                        </form>
            
                        <form action="AdminReservationServlet" method="post" style="display: inline;">
                            <input type="hidden" name="action" value="verify">
                            <input type="hidden" name="reservationId" value="<%= rs.getInt("reservation_id")%>">
                            <button type="submit" class="btn btn-success btn-sm">Verify</button>
                        </form>
                    </td>
                </tr>
                <%
                    }
                } catch (SQLException e) {
                    e.printStackTrace();
                } finally {
                    // Close the resources
                    try {
                        if (rs != null) rs.close();
                        if (stmt != null) stmt.close();
                        if (conn != null) conn.close();
                    } catch (SQLException e) {
                        e.printStackTrace();
                    }
                }
                %>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
