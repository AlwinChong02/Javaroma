<div id="contentWrapper" class="contentcontact">
    <form id="contact" method="POST" onsubmit="return validateForm();">
        
        <label for="name">Name: </label><br>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
        <div id="nameError" class="error"><?= $errors['name'] ?? '' ?></div><br>

        <label for="email">Email Address: </label><br>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
        <div id="emailError" class="error"><?= $errors['email'] ?? '' ?></div><br>

        <label for="messages">Message: </label><br>
        <textarea id="messages" name="messages"><?= htmlspecialchars($messages) ?></textarea>
        <div id="messagesError" class="error"><?= $errors['messages'] ?? '' ?></div><br>

        <input type="submit" value="Send">
    </form>
</div>