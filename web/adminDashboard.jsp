<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ page import="java.sql.*, java.io.*" %>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admincss/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    .wrapper {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: #fff;
      padding: 20px;
    }
    .sidebar-header h3 {
      text-align: center;
    }
    .sidebar-list {
      list-style: none;
      padding: 0;
    }
    .sidebar-link {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px 0;
      text-align: center;
    }
    .sidebar-link:hover {
      background-color: #495057;
    }
    .main-content {
      flex: 1;
      padding: 20px;
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #007bff;
      color: white;
      padding: 15px;
      text-align: center;
    }
    .dashboard-summary {
      display: flex;
      justify-content: space-around;
      margin-top: 20px;
      gap: 20px; /* Space between cards */
    }
    .summary-card {
      background-color: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      flex: 1; /* Ensures all cards have the same width */
      max-width: 300px; /* Optional: Limits card width */
      min-height: 150px; /* Ensures cards are the same height */
    }
    .summary-card h3 {
      margin-bottom: 10px;
      font-size: 24px;
      color: #333;
    }
    .summary-card p {
      font-size: 18px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="wrapper d-flex">
    <aside id="sidebar" class="sidebar">
      <div class="sidebar-header p-3">
        <h3 class="text-center">Admin Dashboard</h3>
      </div>
      <ul class="sidebar-list">
        <li><a href="car.jsp" class="sidebar-link">Car</a></li>
        <li><a href="customerList.jsp" class="sidebar-link">Customer</a></li>
        <li><a href="reserveList.jsp" class="sidebar-link">Reservation</a></li>               
        <li><a href="Login/LoginAdmin.jsp" class="sidebar-link text-center">Logout</a></li>
      </ul>
    </aside>

     <main class="main-content">
      <section id="dashboard" class="dashboard-content">

        <!-- Summary Section -->
        <div class="dashboard-summary">
          <%
            // Database connection parameters
            String url = "jdbc:derby://localhost:1527/SmartRideDB";
            String user = "app";
            String password = "app";

            int totalCars = 0;
            int totalCustomers = 0;
            int totalReservations = 0;

            Connection conn = null;
            Statement stmt = null;
            ResultSet rs = null;

            try {
              // Establish connection
              Class.forName("org.apache.derby.jdbc.ClientDriver");
              conn = DriverManager.getConnection(url, user, password);
              stmt = conn.createStatement();

              // Query to get total cars
              rs = stmt.executeQuery("SELECT COUNT(*) AS total FROM Car");
              if (rs.next()) {
                totalCars = rs.getInt("total");
              }

              // Query to get total customers
              rs = stmt.executeQuery("SELECT COUNT(*) AS total FROM Customers");
              if (rs.next()) {
                totalCustomers = rs.getInt("total");
              }

              // Query to get total reservations
              rs = stmt.executeQuery("SELECT COUNT(*) AS total FROM Reservation");
              if (rs.next()) {
                totalReservations = rs.getInt("total");
              }

            } catch (Exception e) {
              e.printStackTrace();
            } finally {
              // Close resources
              if (rs != null) rs.close();
              if (stmt != null) stmt.close();
              if (conn != null) conn.close();
            }
          %>

          <div class="summary-card">
            <h3>Total Cars</h3>
            <p><%= totalCars %></p>
          </div>
          <div class="summary-card">
            <h3>Total Customers</h3>
            <p><%= totalCustomers %></p>
          </div>
          <div class="summary-card">
            <h3>Total Reservations</h3>
            <p><%= totalReservations %></p>
          </div>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
