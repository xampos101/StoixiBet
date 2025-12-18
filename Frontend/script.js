/**
 * Main JavaScript File
 * GSAP Animations, Custom Cursor, Loading Screen, and Interactions
 */

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, TextPlugin);

// ============================================
// LOADING SCREEN
// ============================================
function initLoadingScreen() {
    const loader = document.getElementById('loader');
    const progressBar = document.querySelector('.loader-progress-bar');
    const percentage = document.querySelector('.loader-percentage');
    const loaderCanvas = document.getElementById('loader-canvas');
    
    if (!loader) return;
    
    // Animate loader canvas particles
    if (loaderCanvas) {
        const ctx = loaderCanvas.getContext('2d');
        loaderCanvas.width = window.innerWidth;
        loaderCanvas.height = window.innerHeight;
        
        const particles = [];
        for (let i = 0; i < 50; i++) {
            particles.push({
                x: Math.random() * loaderCanvas.width,
                y: Math.random() * loaderCanvas.height,
                radius: Math.random() * 2 + 1,
                speed: Math.random() * 2 + 1,
                color: Math.random() > 0.5 ? '#3b82f6' : '#06b6d4'
            });
        }
        
        function animateLoader() {
            ctx.clearRect(0, 0, loaderCanvas.width, loaderCanvas.height);
            particles.forEach(particle => {
                particle.y -= particle.speed;
                if (particle.y < 0) particle.y = loaderCanvas.height;
                
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                ctx.fillStyle = particle.color;
                ctx.globalAlpha = 0.6;
                ctx.fill();
            });
            ctx.globalAlpha = 1;
            requestAnimationFrame(animateLoader);
        }
        animateLoader();
    }
    
    // Simulate loading progress
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress > 100) progress = 100;
        
        if (progressBar) progressBar.style.width = progress + '%';
        if (percentage) percentage.textContent = Math.floor(progress) + '%';
        
        if (progress >= 100) {
            clearInterval(interval);
            setTimeout(() => {
                gsap.to(loader, {
                    opacity: 0,
                    duration: 0.5,
                    ease: 'power2.out',
                    onComplete: () => {
                        loader.classList.add('hidden');
                        initMainAnimations();
                    }
                });
            }, 300);
        }
    }, 100);
}

// ============================================
// CUSTOM CURSOR
// ============================================
function initCustomCursor() {
    const cursor = document.getElementById('cursor');
    const cursorDot = document.querySelector('.cursor-dot');
    const cursorOutline = document.querySelector('.cursor-outline');
    const cursorTrail = document.querySelector('.cursor-trail');
    
    if (!cursor) return;
    
    // Hide cursor on mobile devices
    if (window.innerWidth < 768) {
        cursor.style.display = 'none';
        if (cursorTrail) cursorTrail.style.display = 'none';
        document.body.style.cursor = 'auto'; // Show default cursor on mobile
        return;
    }
    
    // Show cursor on desktop
    cursor.style.display = 'block';
    cursor.style.opacity = '1';
    cursor.style.visibility = 'visible';
    
    // Hide default cursor only when custom cursor is ready
    document.body.style.cursor = 'none';
    
    // Initialize cursor position at center of screen
    let mouseX = window.innerWidth / 2;
    let mouseY = window.innerHeight / 2;
    let cursorX = mouseX;
    let cursorY = mouseY;
    let trailX = 0, trailY = 0;
    const trailParticles = [];
    
    // Set initial position immediately
    cursor.style.left = cursorX + 'px';
    cursor.style.top = cursorY + 'px';
    
    // Mouse move handler
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        
        // Create trail particles
        if (trailParticles.length < 10) {
            trailParticles.push({
                x: e.clientX,
                y: e.clientY,
                life: 1
            });
        }
    });
    
    // Hover detection
    const hoverElements = document.querySelectorAll('a, button, .card, .btn-primary, .btn-outline');
    hoverElements.forEach(el => {
        el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
        el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
    });
    
    // Smooth cursor animation
    function animateCursor() {
        // Smooth cursor movement
        cursorX += (mouseX - cursorX) * 0.1;
        cursorY += (mouseY - cursorY) * 0.1;
        
        cursor.style.left = cursorX + 'px';
        cursor.style.top = cursorY + 'px';
        
        // Update trail particles
        trailParticles.forEach((particle, index) => {
            particle.life -= 0.05;
            if (particle.life <= 0) {
                trailParticles.splice(index, 1);
            }
        });
        
        requestAnimationFrame(animateCursor);
    }
    animateCursor();
}

// ============================================
// STATIC SCROLL - Snap to Sections
// ============================================
function initStaticScroll() {
    // Auto-scroll με smooth behavior από hero section στα cards
    // Το cards-grid έχει grid-auto-rows για να χωράνε όλα τα 11 cards
    
    let isScrolling = false;
    window.addEventListener('wheel', (e) => {
        if (isScrolling) return;
        
        const heroSection = document.querySelector('.hero-section');
        const cardsSection = document.querySelector('.cards-section');
        
        if (!heroSection || !cardsSection) return;
        
        const heroBottom = heroSection.getBoundingClientRect().bottom;
        const cardsTop = cardsSection.getBoundingClientRect().top;
        
        // If scrolling down from hero and not yet at cards
        if (e.deltaY > 0 && heroBottom > 100 && cardsTop > window.innerHeight / 2) {
            isScrolling = true;
            e.preventDefault();
            cardsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => { isScrolling = false; }, 1000);
        }
        // If scrolling up from cards and not yet at hero
        else if (e.deltaY < 0 && cardsTop < window.innerHeight / 2 && heroBottom < window.innerHeight) {
            isScrolling = true;
            e.preventDefault();
            heroSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            setTimeout(() => { isScrolling = false; }, 1000);
        }
    }, { passive: false });
}

// ============================================
// SCROLL PROGRESS INDICATOR
// ============================================
function initScrollProgress() {
    const progressBar = document.querySelector('.scroll-progress-bar');
    if (!progressBar) return;
    
    ScrollTrigger.create({
        start: 'top top',
        end: 'bottom bottom',
        onUpdate: (self) => {
            const progress = self.progress;
            progressBar.style.width = (progress * 100) + '%';
        }
    });
}

// ============================================
// MAIN ANIMATIONS
// ============================================
function initMainAnimations() {
    // Hero Title Animation - Rise from ground
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        gsap.from(heroTitle, {
            opacity: 0,
            y: 100,
            scale: 0.8,
            duration: 1.5,
            ease: 'power4.out',
            delay: 0.3
        });
    }
    
    // Hero Team Section Animation
    const heroTeamSection = document.querySelector('.hero-team-section');
    if (heroTeamSection) {
        gsap.from(heroTeamSection, {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: 'power3.out',
            delay: 0.8
        });
    }
    
    // Hero About Text Animation
    const heroAboutSection = document.querySelector('.hero-about-section');
    if (heroAboutSection) {
        gsap.from(heroAboutSection, {
            opacity: 0,
            x: 30,
            duration: 0.8,
            ease: 'power3.out',
            delay: 1.2
        });
    }
    
    // Hero University Logo Animation
    const heroUniLogo = document.querySelector('.hero-university-logo');
    if (heroUniLogo) {
        gsap.from(heroUniLogo, {
            scale: 0,
            rotation: -180,
            opacity: 0,
            duration: 1,
            ease: 'back.out(1.7)',
            delay: 1
        });
    }
    
    // Hero Team Members Animation
    const heroTeamMembers = document.querySelectorAll('.hero-team-member');
    heroTeamMembers.forEach((member, index) => {
        gsap.from(member, {
            opacity: 0,
            x: -30,
            duration: 0.6,
            delay: 1.2 + (index * 0.1),
            ease: 'power3.out'
        });
    });
    
    // Hero Buttons Animation
    const heroButtons = document.querySelectorAll('.hero-buttons a');
    heroButtons.forEach((btn, index) => {
        gsap.from(btn, {
            opacity: 0,
            y: 30,
            scale: 0.9,
            duration: 0.8,
            delay: 0.5 + (index * 0.1),
            ease: 'back.out(1.7)'
        });
    });
    
    // Section Title Split Animation
    const titleWords = document.querySelectorAll('.title-word');
    if (titleWords.length > 0) {
        gsap.from(titleWords, {
            opacity: 0,
            y: 50,
            rotationX: -90,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: '.section-header',
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });
    }
    
    // Section Divider Animation
    const dividerLine = document.querySelector('.divider-line');
    if (dividerLine) {
        gsap.to(dividerLine, {
            scaleX: 1,
            duration: 1,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: '.section-divider',
                start: 'top 80%',
                toggleActions: 'play none none none'
            }
        });
    }
    
    // Cards Animation with 3D Effect
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        // Initial state
        gsap.set(card, {
            opacity: 0,
            y: 60,
            rotationX: -15,
            transformPerspective: 1000,
            transformStyle: 'preserve-3d'
        });
        
        // Reveal animation
        gsap.to(card, {
            opacity: 1,
            y: 0,
            rotationX: 0,
            duration: 0.8,
            delay: index * 0.1,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: card,
                start: 'top 85%',
                toggleActions: 'play none none none'
            }
        });
        
        // Combined 3D Tilt and Magnetic Effect
        let isHovering = false;
        
        card.addEventListener('mouseenter', () => {
            isHovering = true;
        });
        
        card.addEventListener('mousemove', (e) => {
            if (!isHovering) return;
            
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 15;
            const rotateY = (centerX - x) / 15;
            const moveX = (x - centerX) * 0.1;
            const moveY = (y - centerY) * 0.1;
            
            gsap.to(card, {
                rotationX: rotateX,
                rotationY: rotateY,
                x: moveX,
                y: moveY,
                z: 20,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
        
        card.addEventListener('mouseleave', () => {
            isHovering = false;
            gsap.to(card, {
                rotationX: 0,
                rotationY: 0,
                x: 0,
                y: 0,
                z: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        });
        
        // Particle burst on click
        card.addEventListener('click', function(e) {
            createParticleBurst(e.clientX, e.clientY);
        });
    });
    
    // Particle burst function
    function createParticleBurst(x, y) {
        for (let i = 0; i < 10; i++) {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.width = '4px';
            particle.style.height = '4px';
            particle.style.borderRadius = '50%';
            particle.style.background = Math.random() > 0.5 ? '#3b82f6' : '#06b6d4';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '9999';
            document.body.appendChild(particle);
            
            const angle = (Math.PI * 2 * i) / 10;
            const velocity = 50 + Math.random() * 50;
            
            gsap.to(particle, {
                x: Math.cos(angle) * velocity,
                y: Math.sin(angle) * velocity,
                opacity: 0,
                scale: 0,
                duration: 0.8,
                ease: 'power2.out',
                onComplete: () => particle.remove()
            });
        }
    }
    
    // Parallax Background Elements
    const heroBackground = document.querySelector('.hero-background');
    if (heroBackground) {
        gsap.to('.hero-gradient-top', {
            y: -100,
            ease: 'none',
            scrollTrigger: {
                trigger: '.hero-section',
                start: 'top top',
                end: 'bottom top',
                scrub: true
            }
        });
        
        gsap.to('.hero-gradient-bottom', {
            y: 100,
            ease: 'none',
            scrollTrigger: {
                trigger: '.hero-section',
                start: 'top top',
                end: 'bottom top',
                scrub: true
            }
        });
        
    }
    
    // Header Animation on Scroll
    const header = document.querySelector('.header');
    if (header) {
        ScrollTrigger.create({
            start: 'top -50',
            end: 99999,
            onEnter: () => header.classList.add('header-scrolled'),
            onLeaveBack: () => header.classList.remove('header-scrolled')
        });
    }
    
    // Logo Animation
    const logoContent = document.querySelector('.logo-content');
    if (logoContent) {
        gsap.from(logoContent, {
            rotationY: 180,
            opacity: 0,
            duration: 1,
            ease: 'power3.out',
            delay: 0.3
        });
        
        // Continuous subtle rotation
        gsap.to(logoContent, {
            rotation: 360,
            duration: 20,
            repeat: -1,
            ease: 'none'
        });
    }
    
    // Footer Animation
    const footer = document.querySelector('.footer');
    if (footer) {
        gsap.from('.footer-logo', {
            scale: 0,
            rotation: -180,
            duration: 0.8,
            ease: 'back.out(1.7)',
            scrollTrigger: {
                trigger: footer,
                start: 'top 90%',
                toggleActions: 'play none none none'
            }
        });
        
        gsap.from('.team-card', {
            opacity: 0,
            x: -30,
            duration: 0.6,
            stagger: 0.1,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: footer,
                start: 'top 90%',
                toggleActions: 'play none none none'
            }
        });
    }
    
    // About Section Animation
    const aboutText = document.querySelector('.about-text');
    if (aboutText) {
        gsap.from(aboutText, {
            opacity: 0,
            y: 30,
            duration: 0.8,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: aboutText,
                start: 'top 85%',
                toggleActions: 'play none none none'
            }
        });
    }
}

// ============================================
// BUTTON INTERACTIONS
// ============================================
function initButtonInteractions() {
    const buttons = document.querySelectorAll('.btn-primary, .btn-outline, .card-button');
    
    buttons.forEach(button => {
        // Ripple effect
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
        
        // Hover scale effect
        button.addEventListener('mouseenter', function() {
            gsap.to(this, {
                scale: 1.05,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
        
        button.addEventListener('mouseleave', function() {
            gsap.to(this, {
                scale: 1,
                duration: 0.3,
                ease: 'power2.out'
            });
        });
    });
}

// ============================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ============================================
function initSmoothAnchorScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    if (lenis) {
                        lenis.scrollTo(target, { offset: -80 });
                    } else {
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
            }
        });
    });
}

// ============================================
// INITIALIZE EVERYTHING
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    initLoadingScreen();
    initCustomCursor();
    initStaticScroll();
    initScrollProgress();
    initButtonInteractions();
    initSmoothAnchorScroll();
    initGithubPreview();
    
    // Refresh ScrollTrigger on window resize
    window.addEventListener('resize', () => {
        ScrollTrigger.refresh();
        });
    });

// ============================================
// GITHUB PREVIEW ON HOVER
// ============================================
function initGithubPreview() {
    const githubWrappers = document.querySelectorAll('.hero-github-link-wrapper');
    const loadedProfiles = new Set();
    
    githubWrappers.forEach(wrapper => {
        const preview = wrapper.querySelector('.github-preview');
        if (!preview) return;
        
        const username = preview.getAttribute('data-github');
        if (!username) return;
        
        let hoverTimeout;
        let isHovering = false;
        let profileData = null;
        
        // Load GitHub profile data
        async function loadProfile() {
            if (loadedProfiles.has(username)) return;
            
            const loadingEl = preview.querySelector('.github-preview-loading');
            if (loadingEl) loadingEl.classList.add('active');
            
            try {
                const response = await fetch(`https://api.github.com/users/${username}`);
                if (response.ok) {
                    profileData = await response.json();
                    updatePreview(profileData);
                    loadedProfiles.add(username);
                }
            } catch (error) {
                console.error('Error loading GitHub profile:', error);
            } finally {
                if (loadingEl) loadingEl.classList.remove('active');
            }
        }
        
        function updatePreview(data) {
            // Update bio
            const bioEl = preview.querySelector('.github-preview-bio');
            if (bioEl) {
                if (data.bio) {
                    bioEl.textContent = data.bio;
                    bioEl.style.display = 'block';
                } else {
                    bioEl.style.display = 'none';
                }
            }
            
            // Update stats (followers · following format like GitHub)
            const stats = preview.querySelectorAll('.github-stat-value');
            if (stats.length >= 2) {
                stats[0].textContent = data.followers || '0';
                stats[1].textContent = data.following || '0';
            }
        }
        
        wrapper.addEventListener('mouseenter', () => {
            isHovering = true;
            preview.style.opacity = '1';
            preview.style.visibility = 'visible';
            preview.style.transform = 'translateX(-50%) translateY(0) scale(1)';
            preview.style.pointerEvents = 'auto';
            
            // Load profile data if not already loaded
            if (!profileData && !loadedProfiles.has(username)) {
                loadProfile();
            }
        });
        
        wrapper.addEventListener('mouseleave', () => {
            isHovering = false;
            clearTimeout(hoverTimeout);
            // Don't hide immediately if hovering over preview
            setTimeout(() => {
                if (!isHovering) {
                    preview.style.opacity = '0';
                    preview.style.visibility = 'hidden';
                    preview.style.transform = 'translateX(-50%) translateY(-10px) scale(0.95)';
                    preview.style.pointerEvents = 'none';
                }
            }, 100);
        });
        
        // Keep preview visible when hovering over it
        preview.addEventListener('mouseenter', () => {
            isHovering = true;
            preview.style.opacity = '1';
            preview.style.visibility = 'visible';
            preview.style.pointerEvents = 'auto';
        });
        
        preview.addEventListener('mouseleave', () => {
            isHovering = false;
            preview.style.opacity = '0';
            preview.style.visibility = 'hidden';
            preview.style.transform = 'translateX(-50%) translateY(-10px) scale(0.95)';
            preview.style.pointerEvents = 'none';
        });
    });
}
