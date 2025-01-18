document.addEventListener('DOMContentLoaded', function () {
    //For Search =====================================//
    document.addEventListener('click', function (event) {
        if(event.target.closest('.nav-search')) {
            document.querySelector('.search-bar').classList.add('search-bar-active');
        }
        else  if(event.target.closest('.search-cancel')) {
            document.querySelector('.search-bar').classList.remove('search-bar-active');
        }

    });
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


const contactBtn = document.getElementById('contactBtn');
const notification = document.getElementById('notification');

contactBtn.addEventListener('click', () => {
    notification.style.display = 'block';
    setTimeout(() => {
        notification.style.display = 'none';
    }, 10000);
});


