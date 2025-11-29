<?php
// get error from session
if($_SESSION['error']) {
    $error = $_SESSION['error'];
}

// display error
if(!empty($error)): ?>
    <div class="error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php // display message
if(!empty($message)): ?>
    <div class="message">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif;

// clear session error
unset($_SESSION['error'])
?>