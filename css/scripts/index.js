
    window.addEventListener('scroll', function () {
        const header = document.querySelector('header');
        const scrollPosition = window.scrollY;
        const fadePoint = 300; // Adjust this value to control when the fade starts

        // Calculate opacity based on scroll position
        const opacity = Math.max(1 - scrollPosition / 350, 0);
        header.style.opacity = opacity;
    });
    let counter = 1;
    const totalSlides = 10;

    function showSlide(index) {
        document.getElementById('radio' + index).checked = true;
    }

    function nextSlide() {
        counter++;
        if (counter > totalSlides) {
            counter = 1;
        }
        showSlide(counter);
    }

    function prevSlide() {
        counter--;
        if (counter < 1) {
            counter = totalSlides;
        }
        showSlide(counter);
    }

    setInterval(function () {
        nextSlide();
    }, 7000);