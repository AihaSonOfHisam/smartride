<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SmartRide - User Sign Up</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="left-section">
      <img src="Icon.png" alt="Smart Ride" class="icon">
      <h1>Smart Ride</h1>
    </div>
    <div class="right-section">
      <div class="login-box">
        <h2>Sign Up</h2>
        <div class="form-scroll-container">
            <form action="../SignUpServlet" method="post">
                <!-- Input fields -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="phone_num">Phone Number</label>
            <input type="tel" id="phone_num" name="phone_num" placeholder="Phone Number" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Address" required>

            <label for="gender">Select Gender</label>
            <select id="gender" name="gender">
              <option value="">Select gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <!-- Button -->
            <button type="submit" class="btn">Sign Up as a User</button>
          </form>
        </div>

        <!-- Links -->
        <p class="guest-option">
          Already have an account? <a href="Login.jsp">Login</a>
        </p>
        <p class="guest-option">
          <a href="../index.jsp">Return to Main Page</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
