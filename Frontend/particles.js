/**
 * WebGL Particle System
 * Creates animated particle effects in the background
 */

let particleCanvas, particleCtx;
let particles = [];
let animationFrameId;

function initParticles() {
    particleCanvas = document.getElementById('particles-canvas');
    if (!particleCanvas) return;
    
    particleCtx = particleCanvas.getContext('2d');
    
    // Set canvas size
    resizeParticles();
    
    // Create particles
    createParticles();
    
    // Start animation
    animateParticles();
    
    // Handle resize
    window.addEventListener('resize', resizeParticles);
}

function resizeParticles() {
    if (!particleCanvas) return;
    
    const container = particleCanvas.parentElement;
    particleCanvas.width = container.clientWidth;
    particleCanvas.height = container.clientHeight;
}

function createParticles() {
    particles = [];
    const particleCount = Math.min(100, Math.floor((particleCanvas.width * particleCanvas.height) / 15000));
    
    for (let i = 0; i < particleCount; i++) {
        particles.push({
            x: Math.random() * particleCanvas.width,
            y: Math.random() * particleCanvas.height,
            radius: Math.random() * 2 + 1,
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: (Math.random() - 0.5) * 0.5,
            opacity: Math.random() * 0.5 + 0.2,
            color: Math.random() > 0.5 ? '#3b82f6' : '#06b6d4'
        });
    }
}

function animateParticles() {
    if (!particleCanvas || !particleCtx) return;
    
    // Clear canvas
    particleCtx.clearRect(0, 0, particleCanvas.width, particleCanvas.height);
    
    // Update and draw particles
    particles.forEach((particle, index) => {
        // Update position
        particle.x += particle.speedX;
        particle.y += particle.speedY;
        
        // Wrap around edges
        if (particle.x < 0) particle.x = particleCanvas.width;
        if (particle.x > particleCanvas.width) particle.x = 0;
        if (particle.y < 0) particle.y = particleCanvas.height;
        if (particle.y > particleCanvas.height) particle.y = 0;
        
        // Draw particle
        particleCtx.beginPath();
        particleCtx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
        particleCtx.fillStyle = particle.color;
        particleCtx.globalAlpha = particle.opacity;
        particleCtx.fill();
        
        // Draw connections to nearby particles
        particles.slice(index + 1).forEach(otherParticle => {
            const dx = particle.x - otherParticle.x;
            const dy = particle.y - otherParticle.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance < 150) {
                particleCtx.beginPath();
                particleCtx.moveTo(particle.x, particle.y);
                particleCtx.lineTo(otherParticle.x, otherParticle.y);
                particleCtx.strokeStyle = particle.color;
                particleCtx.globalAlpha = (1 - distance / 150) * 0.2;
                particleCtx.lineWidth = 1;
                particleCtx.stroke();
            }
        });
    });
    
    particleCtx.globalAlpha = 1;
    
    animationFrameId = requestAnimationFrame(animateParticles);
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initParticles);
} else {
    initParticles();
}


