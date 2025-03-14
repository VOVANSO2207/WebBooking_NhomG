
const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
let priceGap = 1000;

priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

        if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";


            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});
rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    });
});

// const tabButtons = document.querySelectorAll('.tab_btn');
// const tabContents = document.querySelectorAll('.tab_item');

// tabButtons.forEach((btn) => {
//     btn.addEventListener('click', function () {
//         console.log('Tab button clicked');
//         tabButtons.forEach((btn) => btn.classList.remove('active'));
//         tabContents.forEach((content) => content.classList.remove('active'));

//         this.classList.add('active');
//         const targetTab = this.getAttribute('data-tab');
//         document.getElementById(targetTab).classList.add('active');
//     });
// });

// JavaScript để điều khiển overlay và sheet
document.addEventListener('DOMContentLoaded', function() {
    // Các element
    const filterToggle = document.getElementById('filter-toggle');
    const sortToggle = document.getElementById('sort-toggle');
    const filterOverlay = document.getElementById('filter-overlay');
    const sortSheet = document.getElementById('sort-sheet');
    const closeFilter = document.getElementById('close-filter');
    const closeSort = document.getElementById('close-sort');
    const overlayBackdrop = document.getElementById('overlay-backdrop');
    const applyFilter = document.getElementById('apply-filter');
    const applySort = document.getElementById('apply-sort');
    
    // Hàm mở filter overlay
    filterToggle.addEventListener('click', function() {
        filterOverlay.classList.add('active');
        overlayBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden'; // Ngăn scroll
    });
    
    // Hàm mở sort sheet
    sortToggle.addEventListener('click', function() {
        sortSheet.classList.add('active');
        overlayBackdrop.classList.add('active');
        document.body.style.overflow = 'hidden'; // Ngăn scroll
    });
    
    // Hàm đóng filter overlay
    closeFilter.addEventListener('click', function() {
        filterOverlay.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = ''; // Cho phép scroll
    });
    
    // Hàm đóng sort sheet
    closeSort.addEventListener('click', function() {
        sortSheet.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = ''; // Cho phép scroll
    });
    
    // Đóng khi click vào backdrop
    overlayBackdrop.addEventListener('click', function() {
        filterOverlay.classList.remove('active');
        sortSheet.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = ''; // Cho phép scroll
    });
    
    // Xử lý khi áp dụng bộ lọc
    applyFilter.addEventListener('click', function() {
        // Lấy tất cả checkbox đã chọn trong filter-overlay
        const checkedFilters = document.querySelectorAll('#filter-overlay input.check_filter:checked');
        
        // Chép các giá trị filter sang form chính
        checkedFilters.forEach(filter => {
            const filterType = filter.dataset.filter;
            const mainFilter = document.querySelector(`.filter input.check_filter[data-filter="${filterType}"]`);
            if (mainFilter) {
                mainFilter.checked = true;
            }
        });
        
        // Lấy giá trị price range
        const minPrice = document.querySelector('#filter-overlay .input-min').value;
        const maxPrice = document.querySelector('#filter-overlay .input-max').value;
        
        // Đóng overlay và áp dụng bộ lọc
        filterOverlay.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = '';
        
        // Gọi hàm lọc ở đây (giả sử bạn có một hàm applyFilters)
        // applyFilters();
    });
    
    // Xử lý khi áp dụng sắp xếp
    applySort.addEventListener('click', function() {
        // const selectedSort = document.querySelector('input[name="sort-option"]:checked');
        // console.log('selectedSort',selectedSort)
        // if (selectedSort) {
        //     const sortValue = selectedSort.value;
        //     console.log('sortValue',sortValue)
        //     // Chọn checkbox tương ứng trong tab control
        //     const mainSortCheckbox = document.querySelector(`#${sortValue}`);
        //     console.log('true',mainSortCheckbox)
        //     if (mainSortCheckbox) {
        //         mainSortCheckbox.checked = true;
        //     }
        // }
        
        // Đóng sheet và áp dụng sắp xếp
        sortSheet.classList.remove('active');
        overlayBackdrop.classList.remove('active');
        document.body.style.overflow = '';
        
        // Gọi hàm sắp xếp ở đây (giả sử bạn có một hàm applySorting)
        // applySorting();
    });
    
    // Đồng bộ các thay đổi giữa overlay và bộ lọc chính
    const rangeMinOverlay = document.querySelector('#filter-overlay .range-min');
    const rangeMaxOverlay = document.querySelector('#filter-overlay .range-max');
    const inputMinOverlay = document.querySelector('#filter-overlay .input-min');
    const inputMaxOverlay = document.querySelector('#filter-overlay .input-max');
    
    // Xử lý thay đổi price range trong overlay
    if(rangeMinOverlay && rangeMaxOverlay) {
        rangeMinOverlay.addEventListener('input', function() {
            inputMinOverlay.value = this.value;
            updateProgressOverlay();
        });
        
        rangeMaxOverlay.addEventListener('input', function() {
            inputMaxOverlay.value = this.value;
            updateProgressOverlay();
        });
        
        function updateProgressOverlay() {
            const progressEl = document.querySelector('#filter-overlay .progress');
            const minVal = parseInt(rangeMinOverlay.value);
            const maxVal = parseInt(rangeMaxOverlay.value);
            
            if(progressEl) {
                progressEl.style.left = (minVal / rangeMinOverlay.max) * 100 + '%';
                progressEl.style.right = 100 - (maxVal / rangeMaxOverlay.max) * 100 + '%';
            }
        }
    }
});
