<?php

// Fetch members from the users table
$user_query = $conn->query("SELECT * FROM users");
$members = array();
if ($user_query->num_rows > 0) {
    while ($row = $user_query->fetch_assoc()) {
        $members[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
    }
}
// Define all deposit types in a single array
$deposit_types = array(
    1 => "Tithes",
    2 => "Offerings",
    3 => "Donations",
    4 => "Mission Funds",
    5 => "Building Fund",
    6 => "Youth Fund",
    7 => "Women's Ministry",
    8 => "Men's Fellowship",
    9 => "Bible Study Contributions",
    10 => "Special Projects",
    // Add more contributions as needed
);
$withdrawal_methods = array(
    1 => "Cash",
    2 => "Mpesa",
    3 => "Cheque",
    4 => "Account to Account Transfer",
    5 => "Equitel"
    // Add more contributions as needed
);
?>

