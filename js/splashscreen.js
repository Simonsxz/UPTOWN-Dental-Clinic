let intro = document.querySelector('.intro');
let logoSpan = document.querySelectorAll('.logo');

window.addEventListener('DOMContentLoaded', () => {
    // Trigger the appearance of each logo character with a delay
    setTimeout(() => {
        logoSpan.forEach((span, idx) => {
            setTimeout(() => {
                span.classList.add('active');
            }, (idx + 1) * 400); // Delay each character's animation
        });
    }, 500); // Delayed start for smoother animation

    // Remove the 'active' class and start the fade-out sequence
    setTimeout(() => {
        logoSpan.forEach((span, idx) => {
            setTimeout(() => {
                span.classList.remove('active');
                span.classList.add('fade');
            }, (idx + 1) * 100); // Slightly faster removal to sync with fade-out
        });
    }, 3000); // Matches the fade-out start time in CSS

    // Hold the intro for 5 seconds before starting the fade-out
    setTimeout(() => {
        intro.style.transition = 'opacity 2s ease-in-out'; // Smooth fade-out transition
        intro.style.opacity = '0'; // Begin fading out
    }, 8000); // 3s fadeIn + 5s hold

    // Redirect to the next page after the fade-out
    setTimeout(() => {
        window.location.href = "../php/dashboard.php";
    }, 6000); // 3s fadeIn + 5s hold + 2s fadeOut
});
