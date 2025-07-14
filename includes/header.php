<!DOCTYPE html>
<html>
<head>
  <title>NREGA Activity Portal</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    footer {
      background-color: #343a40;
      color: white;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="https://nrega.nic.in/">NREGA Portal</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="myabout()">About</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  function myabout() {
    alert("This is a NREGA Activity Portal developed for Tracking Daily working of Narega Coordinators.");
  }
</script>
<!-- 🧱 Main content container starts -->
<main class="flex-fill container mt-5">
