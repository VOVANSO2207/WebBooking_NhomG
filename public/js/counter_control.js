document.addEventListener("DOMContentLoaded", function () {
    const roomsInput = document.getElementById("rooms");
    const adultsInput = document.getElementById("adults");
    const childrenInput = document.getElementById("children");
    const roomSummary = document.getElementById("room-summary");
    const peopleSummary = document.getElementById("people-summary");
    const childrenSummary = document.getElementById("children-summary");

    // Cập nhật hiển thị số lượng
    function updateSummary() {
        roomSummary.innerHTML = `${roomsInput.value} phòng, `;
        peopleSummary.innerHTML = `${adultsInput.value} người lớn, `;
        childrenSummary.innerHTML = `${childrenInput.value} trẻ em`;
    }

    // Tính toán số người tối đa
    function maxPeople() {
        return roomsInput.value * 4; // Mỗi phòng tối đa 4 người
    }

    // Kiểm tra và điều chỉnh số lượng người lớn
    function checkAdults() {
        const totalPeople = parseInt(adultsInput.value) + parseInt(childrenInput.value);
        const max = maxPeople();
        if (totalPeople > max) {
            alert(`Tối đa ${max} người cho ${roomsInput.value} phòng.`);
            adultsInput.value = max - parseInt(childrenInput.value);
            updateButtons();
            updateSummary();
        }
    }

    // Kiểm tra và điều chỉnh số trẻ em
    function checkChildren() {
        const maxChildren = roomsInput.value * 4; // Tối đa 4 trẻ em cho mỗi phòng
        if (parseInt(childrenInput.value) > maxChildren) {
            alert(`Tối đa ${maxChildren} trẻ em cho ${roomsInput.value} phòng.`);
            childrenInput.value = maxChildren; // Điều chỉnh trẻ em nếu vượt quá
        }
    }

    // Tăng giảm số lượng
    document.querySelector(".increment-room").onclick = function () {
        roomsInput.value++;
        updateButtons();
        updateSummary();
    };

    document.querySelector(".decrement-room").onclick = function () {
        if (roomsInput.value > 1) {
            roomsInput.value--;
            updateButtons();
            updateSummary();
        }
    };

    document.querySelector(".increment-adult").onclick = function () {
        adultsInput.value++;
        checkAdults();
        updateButtons();
        updateSummary();
    };

    document.querySelector(".decrement-adult").onclick = function () {
        if (adultsInput.value > 1) {
            adultsInput.value--;
            updateButtons();
            updateSummary();
        }
    };

    document.querySelector(".increment-children").onclick = function () {
        const maxChildren = roomsInput.value * 4; // Tối đa 4 trẻ em cho mỗi phòng
        if (parseInt(childrenInput.value) < maxChildren) {
            childrenInput.value++;
        }
        checkChildren();
        updateButtons();
        updateSummary();
    };

    document.querySelector(".decrement-children").onclick = function () {
        if (childrenInput.value > 0) {
            childrenInput.value--;
        }
        updateButtons();
        updateSummary();
    };

    // Cập nhật trạng thái nút
    function updateButtons() {
        document.querySelector(".decrement-room").disabled = roomsInput.value <= 1;
        document.querySelector(".decrement-adult").disabled = adultsInput.value <= 1;
        document.querySelector(".decrement-children").disabled = childrenInput.value <= 0;
    }

    // Khởi tạo hiển thị ban đầu
    updateSummary();
    updateButtons();
});