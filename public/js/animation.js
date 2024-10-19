(function () {
    document.addEventListener("DOMContentLoaded", function () {
        const numPeople = document.querySelector('.num-people');
        const dropCounter = document.querySelector('.drop-counter');

        numPeople.addEventListener('click', function () {
            // Toggle giữa hiển thị và ẩn phần .drop-counter
            if (dropCounter.style.display === "none" || dropCounter.style.display === "") {
                dropCounter.style.display = "block";
            } else {
                dropCounter.style.display = "none";
            }
        });

        // Ẩn dropdown khi nhấn ra ngoài
        document.addEventListener('click', function (e) {
            if (!numPeople.contains(e.target) && !dropCounter.contains(e.target)) {
                dropCounter.style.display = "none";
            }
        });
    });
})();
