<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="com.smartride.model.Car" %>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="mb-4">Add New Car</h1>

        <!-- Form to add new car -->
        <form action="AddCarServlet" method="POST">
            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" required>
            </div>
            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="mb-3">
                <label for="colour" class="form-label">Colour</label>
                <input type="text" class="form-control" id="colour" name="colour" required>
            </div>
            <div class="mb-3">
                <label for="plateNum" class="form-label">Plate Number</label>
                <input type="text" class="form-control" id="plateNum" name="plateNum" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            <div class="mb-3">
                <label for="seatNum" class="form-label">Seat Number</label>
                <input type="number" class="form-control" id="seatNum" name="seatNum" required>
            </div>
            <div class="mb-3">
                <label for="transmission" class="form-label">Transmission</label>
                <input type="text" class="form-control" id="transmission" name="transmission" required>
            </div>
            <div class="mb-3">
                <label for="pricePerDay" class="form-label">Price per Day</label>
                <input type="number" class="form-control" id="pricePerDay" name="pricePerDay" required>
            </div>
            <div class="mb-3">
                <label for="pricePerWeek" class="form-label">Price per Week</label>
                <input type="number" class="form-control" id="pricePerWeek" name="pricePerWeek" required>
            </div>
            <div class="mb-3">
                <label for="pricePerMonth" class="form-label">Price per Month</label>
                <input type="number" class="form-control" id="pricePerMonth" name="pricePerMonth" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Car</button>
            <p class="mt-4"><a href="car.jsp" class="btn btn-secondary">Back to Car List</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
