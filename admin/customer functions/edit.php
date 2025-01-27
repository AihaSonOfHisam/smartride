<?php
require_once('../../testdatabase.php'); // Ensure this connects using oci_connect()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $username = $_POST['username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_num'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    // Update the customer data in the database, excluding password
    $query = "UPDATE customers 
              SET first_name = :first_name,
                  last_name = :last_name,
                  email = :email,
                  phone_num = :phone_num,
                  address = :address,
                  gender = :gender
              WHERE username = :username";

    $statement = oci_parse($dbconn, $query);
    oci_bind_by_name($statement, ':first_name', $firstName);
    oci_bind_by_name($statement, ':last_name', $lastName);
    oci_bind_by_name($statement, ':email', $email);
    oci_bind_by_name($statement, ':phone_num', $phoneNumber);
    oci_bind_by_name($statement, ':address', $address);
    oci_bind_by_name($statement, ':gender', $gender);
    oci_bind_by_name($statement, ':username', $username);

    if (oci_execute($statement)) {
        echo '<script>alert("Customer details updated successfully."); window.location.href = "../admin customer.php";</script>';
    } else {
        $e = oci_error($statement);
        echo "Failed to update customer details: " . $e['message'];
    }

    oci_free_statement($statement);
} else {
    // Retrieve the username from the query string
    if (isset($_GET['username'])) {
        $username = $_GET['username'];

        // Retrieve the customer data from the database
        $query = "SELECT * FROM customers WHERE username = :username";
        $statement = oci_parse($dbconn, $query);
        oci_bind_by_name($statement, ':username', $username);
        oci_execute($statement);

        $customer = oci_fetch_assoc($statement);

        if (!$customer) {
            echo "Invalid username.";
            exit();
        }

        oci_free_statement($statement);
    } else {
        echo "Invalid username.";
        exit();
    }
}
?>

<!-- HTML Form (No changes in the form) -->
<div style="background-color: yellow;">
  <div class="formbold-form-wrapper">
  <div style="text-align: center;">
    <img src="../../images/smartride.png" style="display: inline-block;">
</div>

    <form action="edit.php" method="POST">
      <div class="formbold-form-title">
        <h2 class="">Edit customer details</h2>
      </div>

      <div class="formbold-mb-3">
        <label for="username" class="formbold-form-label">
          Username
        </label>
        <input
          type="text"
          name="username"
          id="username"
          class="formbold-form-input"
          value="<?php echo htmlspecialchars($customer['USERNAME'], ENT_QUOTES); ?>"
          readonly
        />
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="first_name" class="formbold-form-label">
            First name
          </label>
          <input
            type="text"
            name="first_name"
            id="first_name"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($customer['FIRST_NAME'], ENT_QUOTES); ?>"
          />
        </div>
        <div>
          <label for="last_name" class="formbold-form-label"> Last name </label>
          <input
            type="text"
            name="last_name"
            id="last_name"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($customer['LAST_NAME'], ENT_QUOTES); ?>"
          />
        </div>
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="email" class="formbold-form-label"> Email </label>
          <input
            type="email"
            name="email"
            id="email"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($customer['EMAIL'], ENT_QUOTES); ?>"
          />
        </div>
        <div>
          <label for="phone_num" class="formbold-form-label"> Phone number </label>
          <input
            type="text"
            name="phone_num"
            id="phone_num"
            class="formbold-form-input"
            value="<?php echo htmlspecialchars($customer['PHONE_NUM'], ENT_QUOTES); ?>"
          />
        </div>
      </div>

      <div class="formbold-mb-3">
        <label for="address" class="formbold-form-label">
          Street Address
        </label>
        <input
          type="text"
          name="address"
          id="address"
          class="formbold-form-input"
          value="<?php echo htmlspecialchars($customer['ADDRESS'], ENT_QUOTES); ?>"
        />
      </div>

      <div class="formbold-input-flex">
        <div>
          <label for="gender" class="formbold-form-label"> Gender </label>
          <select name="gender" id="gender" class="formbold-form-input">
            <option value="">Select Gender</option>
            <option value="male" <?php echo ($customer['GENDER'] === 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($customer['GENDER'] === 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($customer['GENDER'] === 'other') ? 'selected' : ''; ?>>Other</option>
          </select>
        </div>
      </div>

      <button class="formbold-btn">Update</button>
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