let inactivityTime = 900000; // 15 minuta ne milisekonda: 900000
let timeoutId;

function resetTimer() {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        window.location.href = 'logout.php?timeout=1';
    }, inactivityTime);
}

document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);
document.addEventListener('scroll', resetTimer);
document.addEventListener('click', resetTimer);

resetTimer();