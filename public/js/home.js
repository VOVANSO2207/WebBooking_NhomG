let currentSlide = 0;
const totalSlides = document.querySelectorAll('.slide').length;

// Initialize the slider
function initSlider() {
    showSlide(currentSlide);
}

// Show specific slide
function showSlide(n) {
    const slides = document.querySelector('.slider-track');
    const dots = document.querySelectorAll('.dot');
    
    if (n >= totalSlides) {
        currentSlide = 0;
    } else if (n < 0) {
        currentSlide = totalSlides - 1;
    } else {
        currentSlide = n;
    }
    
    slides.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    // Update active dot
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentSlide].classList.add('active');
}

// Move to next/previous slide
function moveSlide(direction) {
    showSlide(currentSlide + direction);
}

// Go to specific slide (for dots)
function goToSlide(n) {
    showSlide(n);
}

// Auto-advance slides every 5 seconds
let slideInterval = setInterval(() => moveSlide(1), 5000);

// Pause auto-advance when interacting with slider
const sliderContainer = document.querySelector('.slider-container');
if (sliderContainer) {
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
    });
    
    sliderContainer.addEventListener('mouseleave', () => {
        slideInterval = setInterval(() => moveSlide(1), 5000);
    });
}

// Initialize slider when DOM is loaded
document.addEventListener('DOMContentLoaded', initSlider);


// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Get elements
  const sidebarToggler = document.getElementById('sidebarToggler');
  const sidebarMenu = document.getElementById('sidebarMenu');
  const sidebarClose = document.getElementById('sidebarClose');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  
  // Open sidebar function
  function openSidebar() {
      sidebarMenu.classList.add('show');
      sidebarOverlay.style.display = 'block';
      document.body.style.overflow = 'hidden'; // Prevent background scrolling
  }
  
  // Close sidebar function
  function closeSidebar() {
      sidebarMenu.classList.remove('show');
      sidebarOverlay.style.display = 'none';
      document.body.style.overflow = ''; // Restore scrolling
  }
  
  // Event listeners
  sidebarToggler.addEventListener('click', openSidebar);
  sidebarClose.addEventListener('click', closeSidebar);
  sidebarOverlay.addEventListener('click', closeSidebar);
  
  // Close sidebar when pressing Escape key
  document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && sidebarMenu.classList.contains('show')) {
          closeSidebar();
      }
  });
  
  // Handle links inside sidebar
  const sidebarLinks = sidebarMenu.querySelectorAll('a:not([onclick])');
  sidebarLinks.forEach(link => {
      link.addEventListener('click', function() {
          // For mobile: close sidebar after clicking a link
          if (window.innerWidth < 992) {
              closeSidebar();
          }
      });
  });
});
