<div class="container">
    <h1 class="text-center">Sign Up</h1>
    <form method="post" action="./server/requests.php">

        <div class="col-6 offset-sm-3 mb-2">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Enter address" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
        </div>

        <div class="col-6 offset-sm-3">
            <p>Already have an account? <a href="?login=true">Login</a></p>
        </div>

    </form>
</div>
