<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page session="true" %>
<%
    if (session.getAttribute("admin") != null) {
        response.sendRedirect("adminDashboard.jsp");
        return;
    }
    String errorMessage = (String) request.getAttribute("errorMessage");
%>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartRide - Admin Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="left-section">
      <img src="Icon.png" alt="Smart Ride" class="icon">
      <h1>Smart Ride - Admin</h1>
    </div>
    <div class="right-section">
      <div class="login-box">
        <h2>Admin Log In</h2>

        <!-- Display error message if login fails -->
        <% if (errorMessage != null) { %>
          <p style="color: red;"><%= errorMessage %></p>
        <% } %>

        <form action="../AdminLoginServlet" method="post">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Username" required>
          
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" required>

          <button type="submit" class="btn">Log In as Admin</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
