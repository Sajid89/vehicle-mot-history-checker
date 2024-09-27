<?php include 'views/header.php'; ?>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="display-4">MOT history checker</h1>
        <p class="lead">Check the MOT status and history of any car in the UK using <br> carwow’s free MOT check*</p>

        <!-- Search Form -->
        <div class="search-bar mt-4">
            <label class="text-dark" for="registration">Your vehicle registration</label>
            <form action="results.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control search-field" id="registration" name="registration" placeholder="Registration Number" required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Check MOT History</button>
                    </div>
                </div>
            </form>
            <p class="info-text">*MOT history is only available for tests done in England, Scotland or Wales since 2005, or for tests done in Northern Ireland since 2017. A vehicle’s MOT test results will be available as soon as the MOT centre has recorded the test.</p>
        </div>
    </div>
</div>

<?php include 'views/footer.php'; ?>
