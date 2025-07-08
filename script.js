// Loading Screen
window.addEventListener('load', function () {
    const loader = document.getElementById('loader');
    setTimeout(() => {
        loader.classList.add('hidden');
    }, 200);
});

// Navbar Scroll Effect
const navbar = document.getElementById('navbar');
let lastScrollY = window.scrollY;

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile Menu Toggle
const mobileToggle = document.getElementById('mobileToggle');
const navMenu = document.getElementById('navMenu');

if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
        const icon = mobileToggle.querySelector('i');
        if (navMenu.classList.contains('active')) {
            icon.classList.replace('fa-bars', 'fa-times');
        } else {
            icon.classList.replace('fa-times', 'fa-bars');
        }
    });
}

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if (navMenu) {
            navMenu.classList.remove('active');
        }
        if (mobileToggle) {
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        }
    });
});

// Smooth Scrolling (only for anchor links within the same page)
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const offsetTop = target.offsetTop - 80;
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        }
    });
});

// Scroll Reveal Animation
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, observerOptions);

document.querySelectorAll('.scroll-reveal').forEach(el => {
    observer.observe(el);
});

// Contact Form
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = this.querySelector('.form-submit');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trimitere în curs...';
            submitBtn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                alert('Vă mulțumim pentru mesaj! Vă vom răspunde în cel mai scurt timp.');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        }
    });
}

// Gallery interaction
document.querySelectorAll('.gallery-view-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        // Here you can add modal functionality to view full-size images
        const galleryItem = this.closest('.gallery-item');
        if (galleryItem) {
            const titleElement = galleryItem.querySelector('.gallery-item-title');
            if (titleElement) {
                const title = titleElement.textContent;
                alert(`Funcționalitate viitoare: Vizualizarea "${title}" pe ecran complet`);
            }
        }
    });
});

// Gallery item click
document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', function () {
        const titleElement = this.querySelector('.gallery-item-title');
        if (titleElement) {
            const title = titleElement.textContent;
            console.log(`Element galerie apăsat: ${title}`);
        }
    });
});

// Card hover effects
document.querySelectorAll('.about-card, .program-card, .contact-card').forEach(card => {
    card.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-8px)';
    });

    card.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
    });
});

// Hero Stats Animation (only for index page)
function animateStats() {
    const heroDetailNumbers = document.querySelectorAll('.hero-detail-number');
    if (heroDetailNumbers.length > 0) {
        const stats = [{
                element: heroDetailNumbers[0],
                target: 120,
                suffix: ''
            },
            {
                element: heroDetailNumbers[1],
                target: 2,
                suffix: 'h'
            }
        ];

        stats.forEach(stat => {
            if (stat.element) {
                let current = 0;
                const increment = stat.target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= stat.target) {
                        stat.element.textContent = stat.target + stat.suffix;
                        clearInterval(timer);
                    } else {
                        stat.element.textContent = Math.floor(current) + stat.suffix;
                    }
                }, 40);
            }
        });
    }

    // Alternative stats for hero-stat-number if they exist
    const heroStatNumbers = document.querySelectorAll('.hero-stat-number');
    if (heroStatNumbers.length > 0) {
        const alternativeStats = [{
                element: heroStatNumbers[0],
                target: 250,
                suffix: '+'
            },
            {
                element: heroStatNumbers[1],
                target: 15,
                suffix: ''
            },
            {
                element: heroStatNumbers[2],
                target: 50,
                suffix: '+'
            }
        ];

        alternativeStats.forEach(stat => {
            if (stat.element) {
                let current = 0;
                const increment = stat.target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= stat.target) {
                        stat.element.textContent = stat.target + stat.suffix;
                        clearInterval(timer);
                    } else {
                        stat.element.textContent = Math.floor(current) + stat.suffix;
                    }
                }, 40);
            }
        });
    }
}

// Trigger stats animation when hero is visible
const heroObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            setTimeout(animateStats, 800);
            heroObserver.unobserve(entry.target);
        }
    });
});

const heroSection = document.getElementById('home');
if (heroSection) {
    heroObserver.observe(heroSection);
}

// Parallax Effect for Hero (only on pages with hero section)
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero && scrolled < window.innerHeight) {
        hero.style.transform = `translateY(${scrolled * 0.3}px)`;
    }
});

// Add interactive glow to buttons
document.querySelectorAll('.btn, .nav-cta, .program-join-btn').forEach(btn => {
    btn.classList.add('interactive-glow');
});

// Keyboard Navigation
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && navMenu && navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
        if (mobileToggle) {
            const icon = mobileToggle.querySelector('i');
            if (icon) {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        }
    }
});

// Performance optimization for scroll events
let ticking = false;

function updateOnScroll() {
    // Navbar scroll effect
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }

    // Parallax effect
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero && scrolled < window.innerHeight) {
        hero.style.transform = `translateY(${scrolled * 0.3}px)`;
    }

    ticking = false;
}

window.addEventListener('scroll', () => {
    if (!ticking) {
        requestAnimationFrame(updateOnScroll);
        ticking = true;
    }
});

// WhatsApp button interaction
document.querySelectorAll('.whatsapp-btn-large').forEach(btn => {
    btn.addEventListener('click', function (e) {
        // Add a small animation when clicked
        this.style.transform = 'scale(0.95)';
        setTimeout(() => {
            this.style.transform = '';
        }, 150);
    });
});



// Event item interactions
document.querySelectorAll('.event-item').forEach(item => {
    item.addEventListener('click', function () {
        const eventTitle = this.querySelector('.event-title');
        if (eventTitle) {
            const title = eventTitle.textContent;
            console.log(`Eveniment apăsat: ${title}`);
            // You can add more functionality here, like opening a modal
        }
    });
});

// Social links interactions
document.querySelectorAll('.social-link').forEach(link => {
    link.addEventListener('click', function (e) {
        if (this.getAttribute('href') === '#') {
            e.preventDefault();
            alert('Link către rețelele sociale de configurat');
        }
    });
});

// Footer map interaction
const footerMap = document.querySelector('.footer-map iframe');
if (footerMap) {
    footerMap.addEventListener('load', function () {
        console.log('Harta încărcată cu succes');
    });
}

// Add loading state to navigation links
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
        // Don't add loading for anchor links
        if (!this.getAttribute('href').startsWith('#')) {
            const originalText = this.textContent;
            this.style.opacity = '0.7';

            // Reset after a short delay (in case navigation is instant)
            setTimeout(() => {
                this.style.opacity = '1';
            }, 1000);
        }
    });
});

// Initialize animations for elements that are already visible
document.addEventListener('DOMContentLoaded', function () {
    // Check which elements are already in viewport
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            el.classList.add('revealed');
        }
    });
});

// Console welcome message
console.log('🏛️ Biserica Penticostală Harul Geneva');
console.log('✨ Site modern dezvoltat cu dragoste pentru comunitatea noastră');
console.log('🙏 Să vă binecuvânteze Dumnezeu!');
console.log('📱 Dezvoltat cu: PHP, HTML5, CSS3, JavaScript');
console.log('🎨 Design: Modern și responsive');

// Error handling for missing elements
window.addEventListener('error', function (e) {
    console.warn('Eroare JavaScript interceptată:', e.message);
});

// Check if required elements exist
document.addEventListener('DOMContentLoaded', function () {
    const requiredElements = ['navbar', 'mobileToggle', 'navMenu'];
    requiredElements.forEach(id => {
        if (!document.getElementById(id)) {
            console.warn(`Element necesar lipsă: ${id}`);
        }
    });
});