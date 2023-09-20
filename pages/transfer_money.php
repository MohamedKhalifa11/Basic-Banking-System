<?php
include("../includes/config.php");
// Connect to the database (replace with your database credentials)
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = "";

// Retrieve and display a list of all customers for the transfer
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transfer Money</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
  <div class="container">
    <h1 class="mt-5">Transfer Money</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
      <div class="form-group">
        <label for="sender_id">Select Sender:</label>
        <select name="sender_id" id="sender_id" class="form-control">
          <?php while ($row = $result->fetch_assoc()) : ?>
          <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="receiver_id">Select Receiver:</label>
        <select name="receiver_id" id="receiver_id" class="form-control">
          <?php mysqli_data_seek($result, 0); ?>
          <?php while ($row = $result->fetch_assoc()) : ?>
          <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['name']; ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="amount">Enter Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary">Transfer</button>
    </form>

    <?php
        // Process money transfer when the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sender_id = $_POST['sender_id'];
            $receiver_id = $_POST['receiver_id'];
            $amount = $_POST['amount'];

            // Check if the sender and receiver are the same customer
            if ($sender_id == $receiver_id) {
                $error_message = "Cannot transfer money to the same customer.";
            } elseif ($amount <= 0) { // Validate if amount is less than or equal to zero
                $error_message = "Amount must be greater than zero.";
            } else {
                // Check if the sender has sufficient balance
                $sql_check_balance = "SELECT current_balance FROM customers WHERE customer_id = $sender_id";
                $balance_result = $conn->query($sql_check_balance);

                if ($balance_result->num_rows > 0) {
                    $sender_balance = $balance_result->fetch_assoc()['current_balance'];

                    if ($sender_balance >= $amount) {
                        // Deduct the amount from the sender's balance
                        $sql_deduct = "UPDATE customers SET current_balance = current_balance - $amount WHERE customer_id = $sender_id";

                        if ($conn->query($sql_deduct) === TRUE) {
                            // Successfully deducted from sender's balance

                            // Add the amount to the receiver's balance
                            $sql_add = "UPDATE customers SET current_balance = current_balance + $amount WHERE customer_id = $receiver_id";

                            if ($conn->query($sql_add) === TRUE) {
                                // Successfully added to receiver's balance

                                // Record the transaction in the "transfers" table
                                $sql_insert_transaction = "INSERT INTO transfers (sender_id, receiver_id, amount) VALUES ($sender_id, $receiver_id, $amount)";

                                if ($conn->query($sql_insert_transaction) === TRUE) {
                                    echo "<p class='alert alert-success mt-3'>Transfer successful!</p>";
                                } else {
                                    $error_message = "Error recording transaction: " . $conn->error;
                                }
                            } else {
                                $error_message = "Error updating receiver's balance: " . $conn->error;
                            }
                        } else {
                            $error_message = "Error updating sender's balance: " . $conn->error;
                        }
                    } else {
                        $error_message = "Insufficient balance in sender's account.";
                    }
                } else {
                    $error_message = "Error fetching sender's balance.";
                }
            }

            if (!empty($error_message)) {
                echo "<p class='alert alert-danger mt-3'>Error: $error_message</p>";
            }
        }
        ?>

    <a href="view_customers.php" class="btn btn-secondary mt-3">Back to Customers</a>
  </div>

</body>

</html>