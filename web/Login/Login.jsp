

<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartRide - Login</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
     <%
        String error = request.getParameter("error");
        if (error != null) {
    %>
        <script>
            alert("<%= error %>");
        </script>
    <%
        }
    %>

  <div class="container">
    <div class="left-section">
      <img src="Icon.png" alt="Smart Ride" class="icon">
      <h1>Smart Ride</h1>
    </div>
    <div class="right-section">
      <div class="login-box">
        <h2>Log In</h2>
        <form action="../LoginServlet" method="post">
          <!-- Username field -->
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Username" required>
          
          <!-- Password field -->
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Password" required>

          <!-- Buttons -->
          <button type="submit" name="login" value="user" class="btn">Log In</button>
        </form>

        <!-- Links for sign-up and return -->
        <p class="guest-option">
          Don’t have an account? <a href="SignUp.jsp">Sign Up Now</a>
        </p>
        <p class="guest-option">
          <a href="../index.jsp">Return to Main Page</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
