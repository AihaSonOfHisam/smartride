<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="com.smartride.dao.CarDAO" %>
<%@ page import="com.smartride.model.Car" %>

<%
    String plateNum = request.getParameter("plateNum");
    if (plateNum == null || plateNum.isEmpty()) {
        response.sendRedirect("carList.jsp?error=InvalidPlateNumber");
        return;
    }

    CarDAO carDAO = new CarDAO();
    Car car = carDAO.getCarByPlateNum(plateNum);

    if (car == null) {
        response.sendRedirect("carList.jsp?error=CarNotFound");
        return;
    }
%>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Car</h2>
        <form action="EditCarServlet" method="post">
            <input type="hidden" name="plateNum" value="<%= car.getPlateNum() %>">

            <div class="mb-3">
                <label class="form-label">Brand</label>
                <input type="text" class="form-control" name="brand" value="<%= car.getBrand() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Model</label>
                <input type="text" class="form-control" name="model" value="<%= car.getModel() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Colour</label>
                <input type="text" class="form-control" name="colour" value="<%= car.getColour() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" class="form-control" name="type" value="<%= car.getType() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Seat Number</label>
                <input type="number" class="form-control" name="seatNum" value="<%= car.getSeatNum() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Transmission</label>
                <select class="form-select" name="transmission">
                    <option value="Manual" <%= "Manual".equals(car.getTransmission()) ? "selected" : "" %>>Manual</option>
                    <option value="Automatic" <%= "Automatic".equals(car.getTransmission()) ? "selected" : "" %>>Automatic</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Price Per Day</label>
                <input type="number" step="0.01" class="form-control" name="pricePerDay" value="<%= car.getPricePerDay() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price Per Week</label>
                <input type="number" step="0.01" class="form-control" name="pricePerWeek" value="<%= car.getPricePerWeek() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price Per Month</label>
                <input type="number" step="0.01" class="form-control" name="pricePerMonth" value="<%= car.getPricePerMonth() %>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="Available" <%= "Available".equals(car.getStatus()) ? "selected" : "" %>>Available</option>
                    <option value="Rented" <%= "Rented".equals(car.getStatus()) ? "selected" : "" %>>Rented</option>
                    <option value="Under Maintenance" <%= "Under Maintenance".equals(car.getStatus()) ? "selected" : "" %>>Under Maintenance</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>
    </div>
</body>
</html>
