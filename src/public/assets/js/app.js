const newsList = document.getElementById('newsList');
const newsForm = document.getElementById('newsForm');
const newsId = document.getElementById('newsId');
const newsTitle = document.getElementById('newsTitle');
const newsBody = document.getElementById('newsBody');
const formHeader = document.getElementById('formHeader');
const saveButton = document.getElementById('saveButton');
const cancelEdit = document.getElementById('cancelEdit');
const newsHeader = document.getElementById('newsHeader');
const messageContainer = document.getElementById('messageContainer');

const apiEndpoint = '/api/news';
let newsData = [];

const showMessage = (message, isSuccess = true) => {
    messageContainer.textContent = message;
    messageContainer.className = isSuccess ? 'message success' : 'message error';
    messageContainer.style.display = 'block';
    setTimeout(() => messageContainer.style.display = 'none', 4000);
};

const renderNewsList = items => {
    newsList.innerHTML = '';
    if (items.length === 0) {
        newsHeader.style.display = 'none';
        return;
    }
    newsHeader.style.display = 'block';
    items.forEach(item => {
        const li = document.createElement('li');
        li.classList.add('news-item');
        li.dataset.id = item.id;
        li.innerHTML = `
            <div class="news-content">
                <span class="news-title">${item.title}</span>
                <span class="news-body">${item.body}</span>
            </div>
            <div class="news-actions">
                <img src="assets/images/pencil.svg" alt="Edit" class="edit-icon" data-id="${item.id}">
                <img src="assets/images/close.svg" alt="Delete" class="delete-icon" data-id="${item.id}">
            </div>
        `;
        newsList.appendChild(li);
    });
};

const resetForm = () => {
    newsId.value = '';
    newsTitle.value = '';
    newsBody.value = '';
    formHeader.textContent = 'Create News';
    saveButton.textContent = 'Create';
    cancelEdit.style.display = 'none';
};

const fetchNews = async () => {
    try {
        const res = await fetch(apiEndpoint, {method: 'GET'});
        const data = await res.json();
        if (data.success) {
            newsData = data.data;
            renderNewsList(newsData);
        } else {
            showMessage(data.message, false);
        }
    } catch (error) {
        console.error('Fetch error:', error);
        showMessage('Could not connect to the server.', false);
    }
};

const editNews = id => {
    const newsItem = newsData.find(item => item.id == id);
    if (!newsItem) return showMessage('News item not found.', false);

    newsId.value = newsItem.id;
    newsTitle.value = newsItem.title;
    newsBody.value = newsItem.body;
    formHeader.textContent = 'Edit News';
    saveButton.textContent = 'Edit';
    cancelEdit.style.display = 'inline-block';
};

cancelEdit.addEventListener('click', resetForm);

const deleteNews = async id => {
    if (!confirm('Are you sure you want to delete this item?')) return;

    try {
        const res = await fetch(`${apiEndpoint}/${id}`, {method: 'DELETE'});
        const data = await res.json();
        if (data.success) {
            if (newsId.value == id) resetForm();
            fetchNews();
            showMessage(data.message, true);
        } else {
            showMessage(data.message, false);
        }
    } catch (error) {
        console.error('Delete error:', error);
        showMessage('Failed to delete the news item.', false);
    }
};

newsForm.addEventListener('submit', async e => {
    e.preventDefault();
    const id = newsId.value;
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${apiEndpoint}/${id}` : apiEndpoint;

    const payload = {
        title: newsTitle.value,
        body: newsBody.value
    };

    try {
        const res = await fetch(url, {
            method,
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (data.success) {
            resetForm();
            fetchNews();
            showMessage(data.message, true);
        } else {
            showMessage(data.message, false);
        }
    } catch (error) {
        console.error('Submit error:', error);
        showMessage('Failed to save the news item.', false);
    }
});

newsList.addEventListener('click', e => {
    const target = e.target.closest('.edit-icon, .delete-icon');
    if (!target) return;

    const id = target.dataset.id;
    if (target.classList.contains('edit-icon')) {
        editNews(id);
    } else if (target.classList.contains('delete-icon')) {
        deleteNews(id);
    }
});

// Initial fetch
fetchNews();
