<?php
include("../includes/config.php");
// Connect to the database (replace with your database credentials)
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and display customer details
$customer_id = $_GET['id'];
$sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
  <title><?php echo $customer['name']; ?>'s Details</title>
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
    <h1 class="display-4"><?php echo $customer['name']; ?>'s Details</h1>
    <p><strong>Name:</strong> <?php echo $customer['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
    <p><strong>Current Balance:</strong> $<?php echo $customer['current_balance']; ?></p>
    <a class="btn btn-primary" href="transfer_money.php?sender_id=<?php echo $customer['customer_id']; ?>">Transfer
      Money</a>
    <a class="btn btn-secondary" href="view_customers.php">Back to Customers</a>
  </div>
</body>

</html>