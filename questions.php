<?php
$query = "SELECT * FROM questions";

// Category filter
if (isset($_GET["c-id"])) {
    $cid   = intval($_GET["c-id"]);
    $stmt  = $conn->prepare("SELECT * FROM questions WHERE category_id = ?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

// User filter
} elseif (isset($_GET["u-id"])) {
    $uid  = intval($_GET["u-id"]);
    $stmt = $conn->prepare("SELECT * FROM questions WHERE user_id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

// Latest
} elseif (isset($_GET["latest"])) {
    $result = $conn->query("SELECT * FROM questions ORDER BY id DESC");

// Search
} elseif (isset($_GET["search"]) && $_GET["search"] !== '') {
    $search = "%" . $conn->real_escape_string($_GET["search"]) . "%";
    $stmt   = $conn->prepare("SELECT * FROM questions WHERE title LIKE ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    $result = $conn->query("SELECT * FROM questions");
}

if ($result && $result->num_rows > 0) {
    foreach ($result as $row) {
        $title = htmlspecialchars($row['title']);
        $id    = intval($row['id']);

        echo "<div class='row question-list'>
            <h4 class='my-question'>
                <a href='?q-id=$id'>$title</a>";

        // Show delete only if logged in AND owner
        if (isset($_SESSION['user']) && $_SESSION['user']['user_id'] == $row['user_id']) {
            echo " <a href='./server/requests.php?delete=$id' class='btn btn-sm btn-danger ms-2'
                      onclick=\"return confirm('Delete this question?')\">Delete</a>";
        }

        echo "</h4></div>";
    }
} else {
    echo "<p class='text-muted'>No questions found.</p>";
}
?>
