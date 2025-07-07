<?php
include 'includes/db_connect.php';
include 'includes/header.php';

$selectedDistrict = $_POST['districtID'] ?? '';

?>

<h3 class="text-center mb-4">Admin Login</h3>

<form method="POST" action="adminLogin.php" class="col-md-6 mx-auto">
  <!-- District Dropdown -->
  <div class="mb-3">
    <label>District</label>
    <select name="districtID" class="form-select" onchange="this.form.submit()" required>
      <option value="">Select District</option>  <!-- This option is selected by default and place holder for the dropdown -->
      <?php
      $districts = mysqli_query($conn, "SELECT districtID, district_name FROM Districts");
      while ($d = mysqli_fetch_assoc($districts)) {
        $selected = ($d['districtID'] == $selectedDistrict) ? 'selected' : '';
        echo "<option value='{$d['districtID']}' $selected>{$d['district_name']}</option>";
      }
      ?>
    </select>
  </div>

 

  <!-- Username -->
  <div class="mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>

  <!-- Password -->
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <!-- Submit Button -->
  <button type="submit" formaction="auth/adminLoginProcess.php" class="btn btn-primary w-100">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
