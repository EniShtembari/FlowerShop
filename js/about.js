//  info window
const learnMoreBtn = document.getElementById('learn-more');
const infoWindow = document.getElementById('info-window');
const closeWindow = document.getElementById('close-window');

// shfaqja e dritares
learnMoreBtn.addEventListener('click', function (event) {
    event.preventDefault();
    infoWindow.style.display = 'block';
});

// mbyllja e dritares
closeWindow.addEventListener('click', function () {
    infoWindow.style.display = 'none'; // Hide the small window
});




document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".process-step");

    const showSteps = () => {
        steps.forEach((step, index) => {
            const rect = step.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                setTimeout(() => {
                    step.classList.add("show");
                }, index * 200); // Delay based on the index
            }
        });
    };

    window.addEventListener("scroll", showSteps);
    showSteps(); // Run once to check initial visibility
});
