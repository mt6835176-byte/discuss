<div class="container">
    <div class="offset-sm-1">
        <h5>Answers:</h5>
        <?php
        $stmt = $conn->prepare("SELECT * FROM answers WHERE question_id = ?");
        $stmt->bind_param("i", $qid);
        $stmt->execute();
        $answerResult = $stmt->get_result();

        if ($answerResult->num_rows > 0) {
            foreach ($answerResult as $row) {
                $answer = htmlspecialchars($row['answer']);
                echo "<div class='row'>
                    <p class='answer-wrapper'>$answer</p>
                </div>";
            }
        } else {
            echo "<p class='text-muted'>No answers yet. Be the first to answer!</p>";
        }
        ?>
    </div>
</div>
