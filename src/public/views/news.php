<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Management</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="icon" type="image/svg+xml" href="../assets/images/logo.svg">
</head>
<body>
<div class="main-container">
    <div class="logo-container">
        <img src="../assets/images/logo.svg" alt="cgrd logo" class="logo">
    </div>

    <div id="messageContainer" class="message" style="display:none;"></div>

    <div class="content-container">
        <div class="list-section">
            <h2 class="form-header" id="newsHeader">All News</h2>
            <ul id="newsList" class="news-list"></ul>
        </div>

        <div class="edit-section">
            <div class="edit-header">
                <h2 class="form-header" id="formHeader">Create News</h2>
                <img src="../assets/images/close.svg" alt="Cancel" class="delete-icon" id="cancelEdit"
                     style="display:none;">
            </div>
            <form id="newsForm">
                <input type="hidden" name="id" id="newsId">
                <input type="text" name="title" id="newsTitle" placeholder="Title" required>
                <textarea name="body" id="newsBody" placeholder="Content" required></textarea>
                <div class="button-group">
                    <button type="submit" class="btn-save" id="saveButton">Create</button>
                    <a href="/logout" class="btn-save">Logout</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../assets/js/app.js"></script>
</body>
</html>
