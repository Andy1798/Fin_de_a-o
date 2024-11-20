const swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    grabCursor: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    effect: 'slide',
    speed: 1000,
});



const productContainers = [...document.querySelectorAll('.product-container')];
const nxtBtn = [...document.querySelectorAll('.nxt-btn')];
const preBtn = [...document.querySelectorAll('.pre-btn')];

productContainers.forEach((item, i) => {
    let containerDimensions = item.getBoundingClientRect();
    let containerWidth = containerDimensions.width;

    nxtBtn[i].addEventListener('click', () => {
        item.scrollLeft += containerWidth;
    })

    preBtn[i].addEventListener('click', () => {
        item.scrollLeft -= containerWidth;
    })
});


const featuredSwiper = new Swiper('.featured-products-section .swiper-container', {
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    slidesPerView: 1,
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
    }
});



document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.productos-slider');
    const btnAnterior = document.querySelector('.btn-anterior');
    const btnSiguiente = document.querySelector('.btn-siguiente');
    let scrollPosition = 0;
    const wrapperWidth = document.querySelector('.productos-wrapper').offsetWidth;

    function updateProductWidth() {
        const productWidth = document.querySelector('.producto').offsetWidth + 20;
        const maxScroll = slider.scrollWidth - wrapperWidth;
        return { productWidth, maxScroll };
    }


    btnSiguiente.addEventListener('click', function () {
        const { productWidth, maxScroll } = updateProductWidth();
        if (Math.abs(scrollPosition) + wrapperWidth < slider.scrollWidth) {
            scrollPosition -= productWidth;

            if (Math.abs(scrollPosition) + wrapperWidth > slider.scrollWidth) {
                scrollPosition = -(slider.scrollWidth - wrapperWidth);
            }
            slider.style.transform = `translateX(${scrollPosition}px)`;
        }
    });


    btnAnterior.addEventListener('click', function () {
        const { productWidth } = updateProductWidth();

        if (scrollPosition < 0) {
            scrollPosition += productWidth;
            if (scrollPosition > 0) scrollPosition = 0;
            slider.style.transform = `translateX(${scrollPosition}px)`;
        }
    });


    window.addEventListener('resize', function () {
        scrollPosition = 0;
        slider.style.transform = `translateX(${scrollPosition}px)`;
    });
});




const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
}, {
    threshold: 0.1
});

document.querySelectorAll('.fade-in').forEach(element => {
    observer.observe(element);
});


document.querySelectorAll('.scroll-button').forEach(button => {
    button.addEventListener('click', () => {
        const targetId = button.getAttribute('data-target');
        const targetSection = document.getElementById(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({ behavior: 'smooth' });
        }
    });
});




document.addEventListener("DOMContentLoaded", () => {

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            } else {
                entry.target.classList.remove('active');
            }
        });
    }, { threshold: 0.1 });

    
    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });

   

    const scrollButton = document.querySelector('.scroll-button');
    const targetPosition = 690; 

    scrollButton.addEventListener('click', () => {
        window.scrollTo({
            top: targetPosition, 
            behavior: 'smooth'   
        });
    });


    const productSectionObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {

                const products = document.querySelectorAll('.fade-in-producto');
                products.forEach((product, index) => {
                    setTimeout(() => {
                        product.classList.add('active');
                    }, index * 200);
                });

                productSectionObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });


    const productSection = document.getElementById('productos-destacados');
    if (productSection) {
        productSectionObserver.observe(productSection);
    }
});






document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.productos-slider');
    const products = document.querySelectorAll('.producto');
    const prevButton = document.querySelector('.btn-anterior');
    const nextButton = document.querySelector('.btn-siguiente');

    let currentIndex = 0;
    let productWidth;
    let visibleProducts;
    let maxIndex;

    function updateSliderDimensions() {

        productWidth = products[0].offsetWidth + 20;
        visibleProducts = Math.floor(document.querySelector('.productos-wrapper').offsetWidth / productWidth);
        maxIndex = products.length - visibleProducts;


        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        updateSliderPosition();
    }

    function updateSliderPosition() {
        track.style.transition = 'transform 0.5s ease';
        track.style.transform = `translateX(-${productWidth * currentIndex}px)`;
    }

    function bounceEffect(direction) {
        const bounceDistance = 30;
        track.style.transition = 'transform 0.2s ease';

        if (direction === 'left') {
            track.style.transform = `translateX(-${productWidth * currentIndex + bounceDistance}px)`;
        } else {
            track.style.transform = `translateX(-${productWidth * currentIndex - bounceDistance}px)`;
        }

        setTimeout(() => {
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(-${productWidth * currentIndex}px)`;
        }, 200);
    }

    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        } else {
            bounceEffect('left');
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSliderPosition();
        } else if (currentIndex === maxIndex) {
            bounceEffect('right');
        }
    });

    updateSliderDimensions();


    window.addEventListener('resize', updateSliderDimensions);
});




document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.brands-track');
    const brandLogos = document.querySelectorAll('.brand-logo');
    const prevButton = document.querySelector('.prev');
    const nextButton = document.querySelector('.next');

    let currentIndex = 0;
    const logoWidth = brandLogos[0].offsetWidth + 20;
    const visibleLogos = Math.floor(document.querySelector('.brands-slider').offsetWidth / logoWidth);
    const maxIndex = brandLogos.length - visibleLogos;

    function updateSliderPosition() {
        track.style.transition = 'transform 0.5s ease';
        track.style.transform = `translateX(-${logoWidth * currentIndex}px)`;
    }


    function bounceEffect(direction) {
        const bounceDistance = 30;
        track.style.transition = 'transform 0.2s ease';


        if (direction === 'left') {
            track.style.transform = `translateX(-${logoWidth * currentIndex + bounceDistance}px)`;
        } else {
            track.style.transform = `translateX(-${logoWidth * currentIndex - bounceDistance}px)`;
        }


        setTimeout(() => {
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(-${logoWidth * currentIndex}px)`;
        }, 200);
    }

    // Evento para mover a la izquierda
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        } else {
            bounceEffect('left');
        }
    });


    nextButton.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSliderPosition();
        } else if (currentIndex === maxIndex) {
            bounceEffect('right');
        }
    });
});






window.onscroll = function () {
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        scrollToTopBtn.classList.add("show");
    } else {
        scrollToTopBtn.classList.remove("show");
    }
};


document.getElementById("scrollToTopBtn").onclick = function () {
    const carButton = document.getElementById("scrollToTopBtn");
    carButton.style.animation = "driveUp 1.5s ease forwards";
    window.scrollTo({ top: 0, behavior: "smooth" });


    setTimeout(() => {
        carButton.style.animation = "";
    }, 1500);
};


document.addEventListener('DOMContentLoaded', () => {
    const brandsTrack = document.querySelector('.brands-track');
    const logos = brandsTrack.innerHTML; 
    brandsTrack.innerHTML += logos; 
});
