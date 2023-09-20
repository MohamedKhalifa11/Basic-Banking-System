<?php
include("../includes/config.php");
// Connect to the database (replace with your database credentials)
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and display a list of all customers
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>View All Customers</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body style="background-color: #f4f9fd">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light px-5 mx-5" style="background-color: #f4f9fd">
    <a class="navbar-brand" href="../index.html">Basic Banking System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="../index.html">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="view_customers.php">Customers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transfer_money.php">Transfer</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="container mt-5">
    <h1 class="display-4">View All Customers</h1>
    <ul class="list-group">
      <?php while ($row = $result->fetch_assoc()) : ?>
      <li class="list-group-item"><a
          href="customer_details.php?id=<?php echo $row['customer_id']; ?>"><?php echo $row['name']; ?></a></li>
      <?php endwhile; ?>
    </ul>
    <a class="btn btn-secondary mt-3" href="../index.html">Back to Home</a>
  </div>
</body>

</html>