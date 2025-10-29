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
// Change banner 
document.addEventListener('DOMContentLoaded', function() {
    const changeBannerBtn = document.getElementById('changeBannerBtn');
    const bannerModal = document.getElementById('bannerModal');
    const closeModal = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBannerChange');
    const applyBtn = document.getElementById('applyBannerChange');
    const uploadOption = document.getElementById('uploadBannerOption');
    const fileInput = document.getElementById('bannerUpload');
    const bannerOptions = document.querySelectorAll('.banner-option');
    const headerElement = document.querySelector('.header-staynest-home');
    
    let selectedBannerUrl = document.querySelector('.banner-option.selected').dataset.url;
    let originalBannerUrl = headerElement.style.backgroundImage.match(/url\(['"]?(.*?)['"]?\)/)?.[1] || 
                           'https://images.unsplash.com/photo-1564501049412-61c2a3083791?q=80&w=2000';
    
    // Open modal
    changeBannerBtn.addEventListener('click', function() {
        bannerModal.classList.add('show');
    });
    
    // Close modal functions
    function closeModalFunc() {
        bannerModal.classList.remove('show');
    }
    
    closeModal.addEventListener('click', closeModalFunc);
    cancelBtn.addEventListener('click', closeModalFunc);
    
    // Select banner option
    bannerOptions.forEach(option => {
        option.addEventListener('click', function() {
            bannerOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            selectedBannerUrl = this.dataset.url;
        });
    });
    
    // Upload banner
    uploadOption.addEventListener('click', function() {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create a new banner option for the uploaded image
                const newOption = document.createElement('div');
                newOption.className = 'banner-option';
                newOption.dataset.url = e.target.result;
                newOption.innerHTML = `
                    <img src="${e.target.result}" alt="Uploaded Banner">
                    <div class="banner-option-name">Tải lên</div>
                `;
                
                // Insert before the upload option
                uploadOption.parentNode.insertBefore(newOption, uploadOption);
                
                // Add event listener to the new option
                newOption.addEventListener('click', function() {
                    bannerOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedBannerUrl = this.dataset.url;
                });
                
                // Select the new option
                bannerOptions.forEach(opt => opt.classList.remove('selected'));
                newOption.classList.add('selected');
                selectedBannerUrl = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Apply banner change
    applyBtn.addEventListener('click', function() {
        const newBgImage = `linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1)), url('${selectedBannerUrl}')`;
        headerElement.style.backgroundImage = newBgImage;
        
        // Save preference to localStorage
        localStorage.setItem('staynestBanner', selectedBannerUrl);
        
        // Close modal
        closeModalFunc();
    });
    
    // Load saved banner from localStorage on page load
    const savedBanner = localStorage.getItem('staynestBanner');
    if (savedBanner) {
        const newBgImage = `linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.1)), url('${savedBanner}')`;
        headerElement.style.backgroundImage = newBgImage;
        
        // Update selected banner in modal
        bannerOptions.forEach(option => {
            if (option.dataset.url === savedBanner) {
                option.classList.add('selected');
            } else {
                option.classList.remove('selected');
            }
        });
    }
});
// Scoll header 
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.top-header.header-staynest');
    
    function handleScroll() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
            
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (navbarToggler) {
                navbarToggler.setAttribute('aria-expanded', 'false');
            }
        } else {
            header.classList.remove('scrolled');
        }
    }
    
    window.addEventListener('scroll', handleScroll);
    handleScroll();
    
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only apply smooth scroll to anchor links
            if (href.startsWith('#') && href !== '#') {
                e.preventDefault();
                
                const targetElement = document.querySelector(href);
                if (targetElement) {
                    const headerHeight = header.getBoundingClientRect().height;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});
const monthNames = [
    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
];

const currentMonth = new Date().getMonth();

// Lấy tất cả các phần tử có class 'month' và thay đổi nội dung của chúng
const monthElements = document.querySelectorAll('.month');
monthElements.forEach((element) => {
    element.textContent = monthNames[currentMonth];
});