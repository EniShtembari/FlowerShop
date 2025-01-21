
const contactBtn = document.getElementById('contactBtn');
const notification = document.getElementById('notification');

contactBtn.addEventListener('click', () => {
    notification.style.display = 'block';
    setTimeout(() => {
        notification.style.display = 'none';
    }, 10000);
});







