let intro = document.querySelector('.intro');
let logoSpan = document.querySelectorAll('.logo');

window.addEventListener('DOMContentLoaded', () => {
    // Trigger the appearance of each logo character with a delay
    setTimeout(() => {
        logoSpan.forEach((span, idx) => {
            setTimeout(() => {
                span.classList.add('active');
            }, (idx + 1) * 400);
        });
    }, 500); // Delayed start for smoother animation

    // Remove the 'active' class and start the fade out sequence
    setTimeout(() => {
        logoSpan.forEach((span, idx) => {
            setTimeout(() => {
                span.classList.remove('active');
                span.classList.add('fade');
            }, (idx + 1) * 100); // Slightly faster removal to sync with fade out
        });
    }, 3000); // Matches the fade-out start time in CSS

    // Move the intro out of view
    setTimeout(() => {
        intro.style.transition = 'top 2s ease-in-out'; // Smooth transition
        intro.style.top = '-100vh';
    }, 5000); // Matches the timing in the fade-out animation
});
