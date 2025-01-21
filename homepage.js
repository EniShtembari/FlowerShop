document.addEventListener('DOMContentLoaded', function () {

    //For fix header=============================================//
    const header = document.querySelector('.header');
    let lastScrollY=window.scrollY;

    window.addEventListener('scroll', function () {
        const currentScrollY= window.scrollY;
        if(currentScrollY===0){
            header.classList,remove('header-fix');
        }
        else if(currentScrollY<lastScrollY){
            header.classList.add('header-fix');
        }
        else {
            header.classList.remove('header-fix');
        }
        lastScrollY=currentScrollY;
    })
});

const contactBtn1 = document.getElementById('contactBtn1');
const notification1 = document.getElementById('notification1');

contactBtn1.addEventListener('click', () => {
    notification.style.display = 'block';
    setTimeout(() => {
        notification.style.display = 'none';
    }, 10000);
});

const contactBtn = document.getElementById('contactBtn');
const notification = document.getElementById('notification');

contactBtn.addEventListener('click', () => {
    notification.style.display = 'block';
    setTimeout(() => {
        notification.style.display = 'none';
    }, 10000);
});
