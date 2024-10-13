<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Finance Tracker</title>
</head>
<body>
    <h1>Add Expense</h1>
    <form action="add_expense.php" method="POST">
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" required>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" required>

        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>

        <input type="submit" value="Add Expense">
    </form>

    <h2>Expenses</h2>
    <ul id="expense-list">
        <!-- This is where you can dynamically show expenses later -->
    </ul>
</body>
</html>
