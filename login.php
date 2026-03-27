<div class="container">
    <h1 class="text-center">Login</h1>
    <form action="./server/requests.php" method="post">

        <div class="col-6 offset-sm-3 mb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
        </div>

        <div class="col-6 offset-sm-3 mb-2">
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </div>

        <div class="col-6 offset-sm-3">
            <p>Don't have an account? <a href="?signup=true">Sign up</a></p>
        </div>

    </form>
</div>
