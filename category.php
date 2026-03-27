<select class="form-control" name="category" id="category" required>
    <option value="">Select A Category</option>
    <?php
    $catQuery  = "SELECT * FROM category";
    $catResult = $conn->query($catQuery);
    foreach ($catResult as $row) {
        $name = htmlspecialchars(ucfirst($row['name']));
        $id   = intval($row['id']);
        echo "<option value=\"$id\">$name</option>";
    }
    ?>
</select>
