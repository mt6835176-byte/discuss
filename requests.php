<?php
session_start();
include("../common/db.php");

// ── SIGNUP ──────────────────────────────────────────────────────────────────
if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address  = trim($_POST['address']);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $address);

    if ($stmt->execute()) {
        $_SESSION["user"] = [
            "username" => $username,
            "email"    => $email,
            "user_id"  => $conn->insert_id
        ];
        header("location: /discuss");
        exit();
    } else {
        echo "User could not be registered. Please try again.";
    }

// ── LOGIN ────────────────────────────────────────────────────────────────────
} elseif (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION["user"] = [
                "username" => $row['username'],
                "email"    => $email,
                "user_id"  => $row['id']
            ];
            header("location: /discuss");
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

// ── LOGOUT ───────────────────────────────────────────────────────────────────
} elseif (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("location: /discuss");
    exit();

// ── ASK A QUESTION ───────────────────────────────────────────────────────────
} elseif (isset($_POST["ask"])) {
    if (!isset($_SESSION['user'])) {
        header("location: /discuss?login=true");
        exit();
    }

    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category_id = intval($_POST['category']);
    $user_id     = $_SESSION['user']['user_id'];

    $stmt = $conn->prepare("INSERT INTO questions (title, description, category_id, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $title, $description, $category_id, $user_id);

    if ($stmt->execute()) {
        header("location: /discuss");
        exit();
    } else {
        echo "Question could not be posted. Please try again.";
    }

// ── SUBMIT ANSWER ────────────────────────────────────────────────────────────
} elseif (isset($_POST["answer"])) {
    if (!isset($_SESSION['user'])) {
        header("location: /discuss?login=true");
        exit();
    }

    $answer      = trim($_POST['answer']);
    $question_id = intval($_POST['question_id']);
    $user_id     = $_SESSION['user']['user_id'];

    $stmt = $conn->prepare("INSERT INTO answers (answer, question_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $answer, $question_id, $user_id);

    if ($stmt->execute()) {
        header("location: /discuss?q-id=$question_id");
        exit();
    } else {
        echo "Answer could not be submitted. Please try again.";
    }

// ── DELETE QUESTION ──────────────────────────────────────────────────────────
} elseif (isset($_GET["delete"])) {
    if (!isset($_SESSION['user'])) {
        header("location: /discuss?login=true");
        exit();
    }

    $qid     = intval($_GET["delete"]);
    $user_id = $_SESSION['user']['user_id'];

    // Only allow the owner to delete
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $qid, $user_id);

    if ($stmt->execute()) {
        header("location: /discuss");
        exit();
    } else {
        echo "Question could not be deleted.";
    }
}
?>
