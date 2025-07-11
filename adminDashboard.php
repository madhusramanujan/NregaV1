<?php session_start();
include 'includes/db_connect.php';
include 'includes/header.php';?>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    ✅ <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    ❌ <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<?php
$selectedTaluk = $_POST['talukID'] ?? '';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: adminLogin.php");
    exit;
}

$userID = $_SESSION['user_id'];
$username = $_SESSION['username'];
$districtID = $_SESSION['district_id'];
$talukID = $_SESSION['taluk_id'];
$role = $_SESSION['role'];


// Handle date filtering
$whereClause = "districtID = $districtID";
if (!empty($_GET['from']) && !empty($_GET['to'])) {
  $from = $_GET['from'] . " 00:00:00";
  $to   = $_GET['to']   . " 23:59:59";
  $whereClause .= " AND FromDateAndTime BETWEEN '$from' AND '$to'";
}

$res = mysqli_query($conn, "SELECT * FROM activity_table WHERE $whereClause ORDER BY FromDateAndTime DESC");

?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

  <div class="d-flex justify-content-between align-items-center mb-3">
  <div class="d-flex gap-2">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#activityModal">Enter Activity</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">Create User</button>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminEnDisModal">Enable/Disable User</button>
  </div>
  <a href="adminLogout.php" class="btn btn-danger">Logout</a>
</div>

  <!-- 🔹 Enable/Disable User Modal Section -->
  <!-- <div class="modal fade" id="adminEnDisModal" tabindex="-1" aria-labelledby="adminEnDisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="adminEnDisable.php" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">Enable/Disable User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3 d-flex align-items-center">
              <label for="userID" class="form-label me-3 mb-0">Select User</label>
              <form method="POST" action="">
                <select name="selectedUser" id="userID" class="form-select w-auto" required>
                  <option value="">--Select User--</option>
                  
                </select>
              </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Create User</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div> -->


  <!-- 🔹 Create User Modal Section -->
  <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="adminCreateUser.php" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <!-- Taluk Dropdown -->
            <div class="mb-3">
              <label>Taluk</label>
              <select name="talukID" class="form-select" required>
                <option value="">Select Taluk</option>
                <?php
                if (!empty($districtID)) {
                  $taluks = mysqli_query($conn, "SELECT talukID, taluk_name FROM Taluks WHERE districtID = $districtID");
                  while ($t = mysqli_fetch_assoc($taluks)) {
                    $selected = ($t['talukID'] == $selectedTaluk) ? 'selected' : '';
                    echo "<option value='{$t['talukID']}' $selected>{$t['taluk_name']}</option>";
                  }
                }
                ?>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label>Enter usename</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Enter password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Create User</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>


  <!-- 🔹 Activity Modal -->
  <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form method="POST" action="submitActivity.php" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="activityModalLabel">Enter New Activity</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>From Location</label>
            <input type="text" name="fromLocation" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>From Date & Time</label>
            <input type="datetime-local" name="FromDateAndTime" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>To Location</label>
            <input type="text" name="toLoc" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>To Date & Time</label>
            <input type="datetime-local" name="toDateAndTime" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Activity Done</label>
            <textarea name="activityDone" class="form-control" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label>Activity Image (optional)</label>
            <input type="file" name="activityImage" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit Activity</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>


  <!-- 🔹 Activity Table Section -->
  <div class="card">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
      <span>Your Activities</span>
      <form action="adminExportDoc.php" method="GET" class="mb-0">
        <input type="hidden" name="from" value="<?php echo $_GET['from'] ?? ''; ?>">
        <input type="hidden" name="to" value="<?php echo $_GET['to'] ?? ''; ?>">
        <button type="submit" class="btn btn-outline-light btn-sm">📄 Export to PDF</button>
      </form>
    </div>

    <div class="card-body">
      <form method="GET" class="row g-3 mb-3">
        <div class="col-md-3">
          <label>From Date</label>
          <input type="date" name="from" class="form-control" value="<?php echo $_GET['from'] ?? ''; ?>">
        </div>
        <div class="col-md-3">
          <label>To Date</label>
          <input type="date" name="to" class="form-control" value="<?php echo $_GET['to'] ?? ''; ?>">
        </div>
        <div class="col-md-3 align-self-end">
          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="adminDashboard.php" class="btn btn-secondary">Reset</a>
        </div>
      </form>

      <table id="activityTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Sl No</th>
            <th>From Date & Time</th>
            <th>From Location</th>
            <th>To Location</th>
            <th>To Date & Time</th>
            <th>Activity Done</th>
            <th>Image</th>
            <th>Owner of Activity</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sn = 1;
          mysqli_data_seek($res, 0);
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            echo "<td>{$sn}</td>";
            echo "<td>{$row['FromDateAndTime']}</td>";
            echo "<td>{$row['fromLocation']}</td>";
            echo "<td>{$row['toLoc']}</td>";
            echo "<td>{$row['toDateAndTime']}</td>";
            echo "<td>{$row['activityDone']}</td>";
            echo "<td>";
            if (!empty($row['activityImage'])) {
              echo "<img src='uploads/{$row['activityImage']}' width='100' height='100' style='object-fit: cover;' />";
            } else {
              echo "No Image";
            }
            echo "</td>";
            $q = "SELECT userName FROM user_table WHERE userID = {$row['userID']}";
            $user = mysqli_query($conn, $q);
            $username = mysqli_fetch_assoc($user)['userName'];
            echo "<td>
             {$username}
            </td>";
            echo "</tr>";
            $sn++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 🔹 Edit Modals -->
<?php
mysqli_data_seek($res, 0);
while ($row = mysqli_fetch_assoc($res)) {
?>
<div class="modal fade" id="editModal<?php echo $row['activityID']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="submitActivity.php" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Activity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="activityID" value="<?php echo $row['activityID']; ?>">
        <div class="mb-3">
          <label>From Location</label>
          <input type="text" name="fromLocation" class="form-control" value="<?php echo htmlspecialchars($row['fromLocation']); ?>" required>
        </div>
        <div class="mb-3">
          <label>From Date & Time</label>
          <input type="datetime-local" name="FromDateAndTime" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['FromDateAndTime'])); ?>" required>
        </div>
        <div class="mb-3">
          <label>To Location</label>
          <input type="text" name="toLoc" class="form-control" value="<?php echo htmlspecialchars($row['toLoc']); ?>" required>
        </div>
        <div class="mb-3">
          <label>To Date & Time</label>
          <input type="datetime-local" name="toDateAndTime" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($row['toDateAndTime'])); ?>" required>
        </div>
        <div class="mb-3">
          <label>Activity Done</label>
          <textarea name="activityDone" class="form-control" required><?php echo htmlspecialchars($row['activityDone']); ?></textarea>
        </div>
        <div class="mb-3">
          <label>Change Image (optional)</label>
          <input type="file" name="activityImage" class="form-control">
          <?php if (!empty($row['activityImage'])): ?>
            <p>Current: <a href="uploads/<?php echo $row['activityImage']; ?>" target="_blank">View</a></p>
          <?php endif; ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<?php } ?>

<!-- 🔹 Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#activityTable').DataTable({
      pageLength: 5,
      lengthChange: false,
      ordering: true,
      responsive: true,
      language: {
        search: "🔍 Search:",
        emptyTable: "No activities found"
      },
      columnDefs: [
        { targets: -1, orderable: false }
      ]
    });
  });
</script>

<?php include 'includes/footer.php'; ?>
