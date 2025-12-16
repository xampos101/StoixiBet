/**
 * Neural Network Animation
 * Creates interconnected nodes network effect
 */

let networkCanvas, networkCtx;
let nodes = [];
let animationFrameId;

function initNetwork() {
    networkCanvas = document.getElementById('network-canvas');
    if (!networkCanvas) return;
    
    networkCtx = networkCanvas.getContext('2d');
    
    // Set canvas size
    resizeNetwork();
    
    // Create nodes
    createNodes();
    
    // Start animation
    animateNetwork();
    
    // Handle resize
    window.addEventListener('resize', resizeNetwork);
}

function resizeNetwork() {
    if (!networkCanvas) return;
    
    const container = networkCanvas.parentElement;
    networkCanvas.width = container.clientWidth;
    networkCanvas.height = container.clientHeight;
    
    // Recreate nodes on resize
    createNodes();
}

function createNodes() {
    nodes = [];
    const nodeCount = Math.min(30, Math.floor((networkCanvas.width * networkCanvas.height) / 20000));
    
    for (let i = 0; i < nodeCount; i++) {
        nodes.push({
            x: Math.random() * networkCanvas.width,
            y: Math.random() * networkCanvas.height,
            radius: Math.random() * 3 + 2,
            vx: (Math.random() - 0.5) * 0.3,
            vy: (Math.random() - 0.5) * 0.3,
            pulsePhase: Math.random() * Math.PI * 2
        });
    }
}

function animateNetwork() {
    if (!networkCanvas || !networkCtx) return;
    
    // Clear canvas
    networkCtx.clearRect(0, 0, networkCanvas.width, networkCanvas.height);
    
    const time = Date.now() * 0.001;
    
    // Update and draw nodes
    nodes.forEach((node, index) => {
        // Update position
        node.x += node.vx;
        node.y += node.vy;
        
        // Bounce off edges
        if (node.x < 0 || node.x > networkCanvas.width) node.vx *= -1;
        if (node.y < 0 || node.y > networkCanvas.height) node.vy *= -1;
        
        // Keep in bounds
        node.x = Math.max(0, Math.min(networkCanvas.width, node.x));
        node.y = Math.max(0, Math.min(networkCanvas.height, node.y));
        
        // Pulsing effect
        const pulseRadius = node.radius + Math.sin(time * 2 + node.pulsePhase) * 1;
        
        // Draw node
        networkCtx.beginPath();
        networkCtx.arc(node.x, node.y, pulseRadius, 0, Math.PI * 2);
        const gradient = networkCtx.createRadialGradient(node.x, node.y, 0, node.x, node.y, pulseRadius);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.8)');
        gradient.addColorStop(0.5, 'rgba(6, 182, 212, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
        networkCtx.fillStyle = gradient;
        networkCtx.fill();
        
        // Draw connections
        nodes.slice(index + 1).forEach(otherNode => {
            const dx = node.x - otherNode.x;
            const dy = node.y - otherNode.y;
            const distance = Math.sqrt(dx * dx + dy * dy);
            
            if (distance < 200) {
                const opacity = (1 - distance / 200) * 0.3;
                networkCtx.beginPath();
                networkCtx.moveTo(node.x, node.y);
                networkCtx.lineTo(otherNode.x, otherNode.y);
                networkCtx.strokeStyle = `rgba(59, 130, 246, ${opacity})`;
                networkCtx.lineWidth = 1;
                networkCtx.stroke();
            }
        });
    });
    
    animationFrameId = requestAnimationFrame(animateNetwork);
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNetwork);
} else {
    initNetwork();
}


