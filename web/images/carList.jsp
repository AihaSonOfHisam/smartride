<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="java.util.List, com.smartride.Car" %>
<html>
<head>
    <title>Car Listings</title>
</head>
<body>
    <h2>Car Listings</h2>
    
    <!-- Filters -->
    <form method="GET" action="CarServlet">
        Brand: <input type="text" name="brand">
        Transmission: <select name="transmission">
            <option value="">Any</option>
            <option value="Automatic">Automatic</option>
            <option value="Manual">Manual</option>
        </select>
        Status: <select name="status">
            <option value="">Any</option>
            <option value="Available">Available</option>
            <option value="Rented">Rented</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    
    <table border="1">
        <tr>
            <th>Image</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Transmission</th>
            <th>Price Per Day</th>
            <th>Status</th>
        </tr>
        <%
            List<Car> carList = (List<Car>) request.getAttribute("carList");
            if (carList != null) {
                for (Car car : carList) {
        %>
            <tr>
                <td><img src="<%= car.getImagePath() %>" width="100"></td>
                <td><%= car.getBrand() %></td>
                <td><%= car.getModel() %></td>
                <td><%= car.getTransmission() %></td>
                <td>$<%= car.getPricePerDay() %></td>
                <td><%= car.getStatus() %></td>
            </tr>
        <%
                }
            }
        %>
    </table>
    
    <!-- Pagination -->
    <div>
        <a href="CarServlet?page=1">First</a>
        <a href="CarServlet?page=2">Next</a>
    </div>
</body>
</html>
