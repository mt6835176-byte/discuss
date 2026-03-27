<div class="container">
    <h1 class="heading">Question</h1>
    <div class="row">
        <div class="col-8">
            <?php
            $stmt = $conn->prepare("SELECT * FROM questions WHERE id = ?");
            $stmt->bind_param("i", $qid);
            $stmt->execute();
            $result = $stmt->get_result();
            $row    = $result->fetch_assoc();

            if (!$row) {
                echo "<p class='text-danger'>Question not found.</p>";
            } else {
                $cid = intval($row['category_id']);
                echo "<h4 class='margin-bottom-15 question-title'>Question: " . htmlspecialchars($row['title']) . "</h4>
                      <p class='margin-bottom-15'>" . htmlspecialchars($row['description']) . "</p>";

                include("answers.php");
            }
            ?>

            <?php if (isset($_SESSION['user'])): ?>
            <form action="./server/requests.php" method="post" class="mt-3">
                <input type="hidden" name="question_id" value="<?php echo $qid; ?>">
                <textarea name="answer" class="form-control margin-bottom-15" rows="3"
                          placeholder="Your answer..." required></textarea>
                <button type="submit" name="answer" class="btn btn-primary">Write your answer</button>
            </form>
            <?php else: ?>
            <p class="mt-3"><a href="?login=true">Login</a> to write an answer.</p>
            <?php endif; ?>
        </div>

        <div class="col-4">
            <?php if (isset($cid)): ?>
            <?php
            $catStmt = $conn->prepare("SELECT name FROM category WHERE id = ?");
            $catStmt->bind_param("i", $cid);
            $catStmt->execute();
            $catResult = $catStmt->get_result();
            $catRow    = $catResult->fetch_assoc();

            if ($catRow) {
                echo "<h5>" . htmlspecialchars(ucfirst($catRow['name'])) . "</h5>";
            }

            $relStmt = $conn->prepare("SELECT * FROM questions WHERE category_id = ? AND id != ?");
            $relStmt->bind_param("ii", $cid, $qid);
            $relStmt->execute();
            $relResult = $relStmt->get_result();

            foreach ($relResult as $relRow) {
                $rid   = intval($relRow['id']);
                $rtitle = htmlspecialchars($relRow['title']);
                echo "<div class='question-list'>
                    <h4><a href='?q-id=$rid'>$rtitle</a></h4>
                </div>";
            }
            ?>
            <?php endif; ?>
        </div>
    </div>
</div>
