// Script xử lý chức năng cho modal hình ảnh khách sạn
document.addEventListener('DOMContentLoaded', function() {
  // Khởi tạo Swiper
  const swiperEl = document.querySelector('.mySwiper');
  if (swiperEl) {
      Object.assign(swiperEl, {
          on: {
              slideChange: function(swiper) {
                  // Cập nhật số trang hiện tại
                  document.querySelector('.current-slide').textContent = swiper.realIndex + 1;
                  
                  // Cập nhật thông tin hình ảnh đang hiển thị
                  updateImageInfo(swiper.realIndex);
              }
          }
      });
      swiperEl.initialize();
      
      // Hiển thị tổng số hình ảnh
      document.querySelector('.total-slides').textContent = swiperEl.swiper.slides.length;
  }
  
  // Xử lý sự kiện click vào hình ảnh thumbnail
  const thumbnails = document.querySelectorAll('.thumbnail-image');
  thumbnails.forEach(thumbnail => {
      thumbnail.addEventListener('click', function() {
          const index = parseInt(this.dataset.index);
          if (swiperEl && swiperEl.swiper) {
              swiperEl.swiper.slideTo(index + 1); // +1 vì Swiper bắt đầu từ 0 và có loop
          }
      });
  });
  
  // Xử lý lọc hình ảnh theo danh mục
  const filterButtons = document.querySelectorAll('[data-filter]');
  filterButtons.forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault();
          
          // Loại bỏ trạng thái active cho tất cả các nút
          filterButtons.forEach(btn => btn.classList.remove('active'));
          
          // Thêm trạng thái active cho nút được click
          this.classList.add('active');
          
          const filter = this.dataset.filter;
          const thumbnailItems = document.querySelectorAll('.thumbnail-item');
          
          thumbnailItems.forEach(item => {
              if (filter === 'all' || item.dataset.category === filter) {
                  item.style.display = 'block';
              } else {
                  item.style.display = 'none';
              }
          });
      });
  });
  
  // Xử lý nút xem toàn màn hình
  const fullscreenBtn = document.getElementById('fullscreenBtn');
  if (fullscreenBtn) {
      fullscreenBtn.addEventListener('click', function() {
          const currentSlide = swiperEl.swiper.slides[swiperEl.swiper.activeIndex];
          const image = currentSlide.querySelector('img');
          
          if (image) {
              if (!document.fullscreenElement) {
                  if (image.requestFullscreen) {
                      image.requestFullscreen();
                  } else if (image.webkitRequestFullscreen) {
                      image.webkitRequestFullscreen();
                  } else if (image.msRequestFullscreen) {
                      image.msRequestFullscreen();
                  }
                  this.innerHTML = '<i class="fas fa-compress"></i>';
              } else {
                  if (document.exitFullscreen) {
                      document.exitFullscreen();
                  } else if (document.webkitExitFullscreen) {
                      document.webkitExitFullscreen();
                  } else if (document.msExitFullscreen) {
                      document.msExitFullscreen();
                  }
                  this.innerHTML = '<i class="fas fa-expand"></i>';
              }
          }
      });
  }
  
  // Xử lý sự kiện thay đổi khi thoát chế độ toàn màn hình
  document.addEventListener('fullscreenchange', updateFullscreenButtonIcon);
  document.addEventListener('webkitfullscreenchange', updateFullscreenButtonIcon);
  document.addEventListener('mozfullscreenchange', updateFullscreenButtonIcon);
  document.addEventListener('MSFullscreenChange', updateFullscreenButtonIcon);
  
  function updateFullscreenButtonIcon() {
      if (fullscreenBtn) {
          if (!document.fullscreenElement) {
              fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
          } else {
              fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
          }
      }
  }
  
  // Xử lý nút chia sẻ
  const shareBtn = document.getElementById('shareBtn');
  const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
  
  if (shareBtn) {
      shareBtn.addEventListener('click', function() {
          // Lấy URL của hình ảnh hiện tại
          const currentSlide = swiperEl.swiper.slides[swiperEl.swiper.activeIndex];
          const image = currentSlide.querySelector('img');
          const imageUrl = image ? image.src : window.location.href;
          
          // Cập nhật URL trong modal chia sẻ
          document.getElementById('shareLink').value = imageUrl;
          
          // Cập nhật các liên kết chia sẻ
          const shareButtons = document.querySelectorAll('.share-btn');
          shareButtons.forEach(btn => {
              const platform = btn.dataset.platform;
              switch (platform) {
                  case 'facebook':
                      btn.href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(imageUrl)}`;
                      break;
                  case 'twitter':
                      btn.href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(imageUrl)}`;
                      break;
                  case 'whatsapp':
                      btn.href = `https://api.whatsapp.com/send?text=${encodeURIComponent(imageUrl)}`;
                      break;
                  case 'email':
                      btn.href = `mailto:?subject=Xem hình ảnh khách sạn này&body=${encodeURIComponent(imageUrl)}`;
                      break;
              }
          });
          
          // Hiển thị modal chia sẻ
          shareModal.show();
      });
  }
  
  // Xử lý sao chép đường dẫn
  const copyLinkBtn = document.querySelector('.copy-link-btn');
  if (copyLinkBtn) {
      copyLinkBtn.addEventListener('click', function() {
          const shareLinkInput = document.getElementById('shareLink');
          shareLinkInput.select();
          document.execCommand('copy');
          
          // Cập nhật trạng thái nút
          this.innerHTML = '<i class="fas fa-check"></i>';
          setTimeout(() => {
              this.innerHTML = '<i class="fas fa-copy"></i>';
          }, 2000);
      });
  }
  
  // Xử lý nút yêu thích
  const favoriteBtn = document.getElementById('favoriteBtn');
  if (favoriteBtn) {
      favoriteBtn.addEventListener('click', function() {
          const icon = this.querySelector('i');
          if (icon.classList.contains('far')) {
              icon.classList.remove('far');
              icon.classList.add('fas');
              icon.closest('button').classList.add('btn-danger');
              icon.closest('button').classList.remove('btn-light');
              
              // Logic lưu vào yêu thích - có thể sử dụng localStorage hoặc gửi API
              saveFavorite();
          } else {
              icon.classList.remove('fas');
              icon.classList.add('far');
              icon.closest('button').classList.remove('btn-danger');
              icon.closest('button').classList.add('btn-light');
              
              // Logic xóa khỏi yêu thích
              removeFavorite();
          }
      });
  }
  
  // Hàm cập nhật thông tin hình ảnh đang hiển thị
  function updateImageInfo(index) {
      // Logic cập nhật thông tin hình ảnh - có thể được mở rộng dựa trên dữ liệu của bạn
      console.log('Hiển thị hình ảnh thứ: ', index + 1);
  }
  
  // Hàm lưu vào yêu thích
  function saveFavorite() {
      // Lấy thông tin hình ảnh hiện tại
      const currentIndex = swiperEl.swiper.realIndex;
      const currentSlide = swiperEl.swiper.slides[swiperEl.swiper.activeIndex];
      const image = currentSlide.querySelector('img');
      const imageUrl = image ? image.src : '';
      
      // Lưu vào localStorage
      let favorites = JSON.parse(localStorage.getItem('favoriteImages') || '[]');
      favorites.push({
          url: imageUrl,
          date: new Date().toISOString(),
          id: Date.now() // ID duy nhất
      });
      localStorage.setItem('favoriteImages', JSON.stringify(favorites));
      
      // Hiển thị thông báo
      showToast('Đã thêm vào danh sách yêu thích', 'success');
  }
  
  // Hàm xóa khỏi yêu thích
  function removeFavorite() {
      const currentSlide = swiperEl.swiper.slides[swiperEl.swiper.activeIndex];
      const image = currentSlide.querySelector('img');
      const imageUrl = image ? image.src : '';
      
      // Xóa khỏi localStorage
      let favorites = JSON.parse(localStorage.getItem('favoriteImages') || '[]');
      favorites = favorites.filter(item => item.url !== imageUrl);
      localStorage.setItem('favoriteImages', JSON.stringify(favorites));
      
      // Hiển thị thông báo
      showToast('Đã xóa khỏi danh sách yêu thích', 'info');
  }
  
  // Hàm hiển thị thông báo
  function showToast(message, type = 'info') {
      // Tạo phần tử toast
      const toastContainer = document.createElement('div');
      toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
      toastContainer.style.zIndex = '9999';
      
      const toastElement = document.createElement('div');
      toastElement.className = `toast align-items-center text-white bg-${type} border-0`;
      toastElement.setAttribute('role', 'alert');
      toastElement.setAttribute('aria-live', 'assertive');
      toastElement.setAttribute('aria-atomic', 'true');
      
      toastElement.innerHTML = `
          <div class="d-flex">
              <div class="toast-body">
                  ${message}
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      `;
      
      toastContainer.appendChild(toastElement);
      document.body.appendChild(toastContainer);
      
      // Hiển thị toast
      const toast = new bootstrap.Toast(toastElement, {
          animation: true,
          autohide: true,
          delay: 3000
      });
      
      toast.show();
      
      // Xóa phần tử sau khi ẩn
      toastElement.addEventListener('hidden.bs.toast', function() {
          document.body.removeChild(toastContainer);
      });
  }
  
  // Xử lý chuyển đổi kiểu hiển thị (lưới/danh sách)
  const viewButtons = document.querySelectorAll('[data-view]');
  viewButtons.forEach(button => {
      button.addEventListener('click', function() {
          // Loại bỏ trạng thái active
          viewButtons.forEach(btn => btn.classList.remove('active'));
          
          // Thêm trạng thái active
          this.classList.add('active');
          
          const view = this.dataset.view;
          const gallery = document.getElementById('imageGallery');
          
          if (view === 'list') {
              gallery.classList.remove('row');
              gallery.classList.add('list-view');
              
              // Cập nhật class cho các thumbnail item
              const thumbnailItems = document.querySelectorAll('.thumbnail-item');
              thumbnailItems.forEach(item => {
                  item.classList.remove('col-6', 'col-md-3', 'col-lg-2');
                  item.classList.add('list-item', 'mb-2');
                  
                  // Cập nhật giao diện card
                  const card = item.querySelector('.card');
                  if (card) {
                      card.classList.add('flex-row');
                      
                      const img = card.querySelector('img');
                      if (img) {
                          img.classList.add('list-thumbnail');
                      }
                  }
              });
          } else {
              gallery.classList.add('row');
              gallery.classList.remove('list-view');
              
              // Cập nhật class cho các thumbnail item
              const thumbnailItems = document.querySelectorAll('.thumbnail-item');
              thumbnailItems.forEach(item => {
                  item.classList.add('col-6', 'col-md-3', 'col-lg-2');
                  item.classList.remove('list-item', 'mb-2');
                  
                  // Cập nhật giao diện card
                  const card = item.querySelector('.card');
                  if (card) {
                      card.classList.remove('flex-row');
                      
                      const img = card.querySelector('img');
                      if (img) {
                          img.classList.remove('list-thumbnail');
                      }
                  }
              });
          }
      });
  });
});