<?php
require_once('../../testdatabase.php');
?>
<div style="background-color: yellow;"> 
  <div class="formbold-form-wrapper">
    
  <div style="text-align: center;">
    <img src="../../images/smartride.png" style="display: inline-block;">
</div>

<form action="addprocess.php" method="POST">
    <div class="formbold-form-title">
        <h2 class="">Add new car</h2>
    </div>
    <div class="formbold-mb-3">
        <label for="plate_number" class="formbold-form-label">Plate Number</label>
        <input type="text" name="plate_number" id="plate_number" class="formbold-form-input" />
    </div>
    <div class="formbold-mb-3">
        <label for="brand" class="formbold-form-label">Brand</label>
        <input type="text" name="brand" id="brand" class="formbold-form-input" />
    </div>
    <div class="formbold-mb-3">
        <label for="model" class="formbold-form-label">Model</label>
        <input type="text" name="model" id="model" class="formbold-form-input" />
    </div>
    <div >
        <label for="colour" class="formbold-form-label">Colour</label>
        <input type="text" name="colour" id="colour" class="formbold-form-input" />
    </div>
    <div >
        <label for="type" class="formbold-form-label">Type</label>
        <input type="text" name="type" id="type" class="formbold-form-input" />
    </div>
    <div >
        <label for="seats" class="formbold-form-label">Seats</label>
        <input type="number" name="seats" id="seats" class="formbold-form-input" />
    </div>
    <div >
        <label for="transmission" class="formbold-form-label">Transmission</label>
    <select name="transmission" id="transmission" class="formbold-form-input">
        <option value="automatic">Automatic</option>
        <option value="manual">Manual</option>
    </select>
    </div>
    <div >
        <label for="price_per_day" class="formbold-form-label">Price per Day</label>
        <input type="number" name="price_per_day" id="price_per_day" class="formbold-form-input" />
    </div>
    <div >
        <label for="price_per_week" class="formbold-form-label">Price per Week</label>
        <input type="number" name="price_per_week" id="price_per_week" class="formbold-form-input" />
    </div>
    <div>
        <label for="price_per_month" class="formbold-form-label">Price per Month</label>
        <input type="number" name="price_per_month" id="price_per_month" class="formbold-form-input" />
    </div>
   <div >
    <label for="status" class="formbold-form-label">Status</label>
    <select name="status" id="status" class="formbold-form-input">
      <option value="available">Available</option>
        <option value="in-rent">In-Rent</option>
        <option value="maintenance">Maintenance</option>
    </select>
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