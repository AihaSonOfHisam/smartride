<?php
// Assuming you have a database connection established
require_once('../../testdatabase.php');

if (isset($_GET['ic'])) {
  $ic = $_GET['ic'];

  // Retrieve the staff details from the database
  $query = "SELECT * FROM staff WHERE ic = :ic";
  $stid = oci_parse($dbconn, $query);

  // Bind the IC variable
  oci_bind_by_name($stid, ":ic", $ic);

  // Execute the query
  oci_execute($stid);

  // Fetch the staff details
  $staff = oci_fetch_assoc($stid);

  // Check if the staff exists
  if ($staff) {
    $name = $staff['NAME'];
    $email = $staff['EMAIL'];
    $phoneNumber = $staff['PHONE_NUM'];
    $ic = $staff['IC'];
    $address = $staff['ADDRESS'];
    $role = $staff['ROLE'];
    $salary = $staff['SALARY'];
    $gender = $staff['GENDER'];

    // Display the form for editing the staff information
    ?>
    <div style="background-color: yellow;">
      <div class="formbold-form-wrapper">
      <div style="text-align: center;">
    <img src="../../images/smartride.png" style="display: inline-block;">
</div>
        <form action="update.php" method="POST">
          <div class="formbold-form-title">
            <h2>Edit Staff Information</h2>
          </div>
          <div class="formbold-mb-3">
            <label for="name" class="formbold-form-label">Name</label>
            <input type="text" name="name" id="name" class="formbold-form-input" value="<?php echo $name; ?>">
          </div>
          <div class="formbold-input-flex">
            <div>
              <label for="email" class="formbold-form-label">Email</label>
              <input type="email" name="email" id="email" class="formbold-form-input" value="<?php echo $email; ?>">
            </div>
            <div>
              <label for="phone_num" class="formbold-form-label">Phone number</label>
              <input type="text" name="phone_num" id="phone_num" class="formbold-form-input" value="<?php echo $phoneNumber; ?>">
            </div>
          </div>
          <div class="formbold-mb-3">
            <label for="ic" class="formbold-form-label">IC</label>
            <input type="text" name="ic" id="ic" class="formbold-form-input" value="<?php echo $ic; ?>">
          </div>
          <div class="formbold-mb-3">
            <label for="address" class="formbold-form-label">Street Address</label>
            <input type="text" name="address" id="address" class="formbold-form-input" value="<?php echo $address; ?>">
          </div>
          <div class="formbold-mb-3">
            <label for="role" class="formbold-form-label">Role</label>
            <input type="text" name="role" id="role" class="formbold-form-input" value="<?php echo $role; ?>">
          </div>
          <div class="formbold-mb-3">
            <label for="salary" class="formbold-form-label">Salary</label>
            <input type="text" name="salary" id="salary" class="formbold-form-input" value="<?php echo $salary; ?>">
          </div>
          <div>
              <label for="gender" class="formbold-form-label">Gender</label>
              <select name="gender" id="gender" class="formbold-form-input">
                <option value="" <?php if ($gender === '') echo 'selected'; ?>>Select Gender</option>
                <option value="male" <?php if ($gender === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($gender === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($gender === 'other') echo 'selected'; ?>>Other</option>
              </select>
            </div>
          <button class="formbold-btn" type="submit">Update</button>
        </form>
      </div>
    </div>
    <?php
  } else {
    echo "Staff not found.";
  }

  // Free the result variable
  oci_free_statement($stid);
}

// Close the connection
oci_close($dbconn);
?>


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
