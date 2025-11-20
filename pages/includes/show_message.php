<?php 
if($_SESSION['error']) {
    $error = $_SESSION['error'];
}

if(!empty($error)): ?>
    <div class="error">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if(!empty($message)): ?>
    <div class="message">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; 
unset($_SESSION['error'])
?>