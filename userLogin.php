<?php
include 'includes/db_connect.php';
include 'includes/header.php';

$selectedDistrict = $_POST['districtID'] ?? '';
$selectedTaluk = $_POST['talukID'] ?? '';
?>

<h3 class="text-center mb-4">User Login</h3>

<form method="POST" action="userLogin.php" class="col-md-6 mx-auto">
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

  <!-- Taluk Dropdown -->
  <div class="mb-3">
    <label>Taluk</label>
    <select name="talukID" class="form-select" required>
      <option value="">Select Taluk</option>
      <?php
      if (!empty($selectedDistrict)) {
        $taluks = mysqli_query($conn, "SELECT talukID, taluk_name FROM Taluks WHERE districtID = $selectedDistrict");
        while ($t = mysqli_fetch_assoc($taluks)) {
          $selected = ($t['talukID'] == $selectedTaluk) ? 'selected' : '';
          echo "<option value='{$t['talukID']}' $selected>{$t['taluk_name']}</option>";
        }
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
  <button type="submit" formaction="auth/userLoginProcess.php" class="btn btn-primary w-100">Login</button>
</form>

<?php include 'includes/footer.php'; ?>
