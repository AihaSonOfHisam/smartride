<?php
require_once('./connectdb.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_num'];
    $ic = $_POST['ic'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Insert the admin data into the database
    $query = "INSERT INTO admin (username, email, phone_num, ic, address, gender, password)
              VALUES ('$name', '$email', '$phoneNumber', '$ic', '$address', '$gender', '$password')";

    $result = mysqli_query($connection, $query);

    if ($result) {
         echo '<script>alert("New admin was added successfully."); window.location.href = "../admin admins.php";</script>';
    } else {
        echo "Failed to add the admin.";
    }
}
?>

<div style="background-color: yellow;">
    <div class="formbold-form-wrapper">
        <img src="/smartride/images/logo.png">

        <form action="add.php" method="POST">
            <div class="formbold-form-title">
                <h2 class="">Add new staffs</h2>
            </div>
            <div class="formbold-mb-3">
                <label for="name" class="formbold-form-label">Username</label>
                <input type="text" name="name" id="name" class="formbold-form-input" />
            </div>
			<div class="formbold-mb-3">
                    <label for="password" class="formbold-form-label">Password</label>
                    <input type="password" name="password" id="password" class="formbold-form-input" />
                </div>
            <div class="formbold-input-flex">
                
				<div class="formbold-mb-3">
                <label for="ic" class="formbold-form-label">IC</label>
                <input type="text" name="ic" id="ic" class="formbold-form-input" />
            </div>
                <div>
                    <label for="phone_num" class="formbold-form-label">Phone number</label>
                    <input type="number" name="phone_num" id="phone_num" class="formbold-form-input" />
                </div>
            </div>
			<div class="formbold-mb-3">
                    <label for="email" class="formbold-form-label">Email</label>
                    <input type="email" name="email" id="email" class="formbold-form-input" />
                </div>
            <div class="formbold-mb-3">
                <label for="address" class="formbold-form-label">Street Address</label>
                <input type="text" name="address" id="address" class="formbold-form-input" />
            </div>
            <div class="formbold-input-flex">
                <div>
                    <label for="gender" class="formbold-form-label">Gender</label>
                    <select name="gender" id="gender" class="formbold-form-input">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
            </div>
            <button class="formbold-btn">Add</button>
        </form>

  </div>
</div>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    font-family: 'Inter', sans-serif;
  }
  .formbold-mb-3 {
    margin-bottom: 15px;
  }
  .formbold-relative {
    position: relative;
  }
  .formbold-opacity-0 {
    opacity: 0;
  }
  .formbold-stroke-current {
    stroke: currentColor;
  }
  #supportCheckbox:checked ~ div span {
    opacity: 1;
  }

  .formbold-main-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px;
  }

  .formbold-form-wrapper {
    margin: 0 auto;
    max-width: 570px;
    width: 100%;
    background: white;
    padding: 40px;
  }

  .formbold-img {
    margin-bottom: 45px;
  }

  .formbold-form-title {
    margin-bottom: 30px;
  }
  .formbold-form-title h2 {
    font-weight: 600;
    font-size: 28px;
    line-height: 34px;
    color: #07074d;
  }
  .formbold-form-title p {
    font-size: 16px;
    line-height: 24px;
    color: #536387;
    margin-top: 12px;
  }

  .formbold-input-flex {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
  }
  .formbold-input-flex > div {
    width: 50%;
  }
  .formbold-form-input {
    text-align: center;
    width: 100%;
    padding: 13px 22px;
    border-radius: 5px;
    border: 1px solid #dde3ec;
    background: #ffffff;
    font-weight: 500;
    font-size: 16px;
    color: #536387;
    outline: none;
    resize: none;
  }
  .formbold-form-input:focus {
    border-color: #6a64f1;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
  .formbold-form-label {
    color: black;
    font-size: 14px;
    line-height: 24px;
    display: block;
    margin-bottom: 10px;
  }

  .formbold-checkbox-label {
    display: flex;
    cursor: pointer;
    user-select: none;
    font-size: 16px;
    line-height: 24px;
    color: #536387;
  }
  .formbold-checkbox-label a {
    margin-left: 5px;
    color: #6a64f1;
  }
  .formbold-input-checkbox {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border-width: 0;
  }
  .formbold-checkbox-inner {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    margin-right: 16px;
    margin-top: 2px;
    border: 0.7px solid #dde3ec;
    border-radius: 3px;
  }

  .formbold-btn {
    font-size: 16px;
    border-radius: 20px;
    padding: 14px 25px;
    border: none;
    font-weight: 500;
    background-color: yellow;
    color: black;
    cursor: pointer;
    margin-top: 25px;
	width: 100%;
  }
  .formbold-btn:hover {
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
  }
</style>
