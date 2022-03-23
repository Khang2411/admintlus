
// check fetch
if (('fetch' in window)) {
    console.log('Fetch API run');
}
// validate boostrap
(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

document.getElementById("select_promotion_code").addEventListener('change', function (event) {
    const percent = event.target.options[event.target.selectedIndex].getAttribute('data-percent');
    console.log(percent);
    if (percent) {
        // nhập 18.000.000 thì vô js tinh toán sẽ bỏ . thành 18000000
        const price = document.getElementById('price').value.replace(/[. ,]/g, '');
        const promotional_price = price - (price * (percent / 100));
        document.getElementById("promotionprice").value = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(promotional_price).replace('₫', '').trim();
    } // trim() số thì dùng trim để xóa khoảng trắng
    else {
        document.getElementById("promotionprice").value = "";
    }

})
// Tính khuyến mãi. Trường hợp chọn mã km xong quay lại nhập  giá
document.getElementById("price").addEventListener('input', function () {
    const price = document.getElementById('price').value.replace(/[. ,]/g, '');
    if (price > 0) {
        let e = document.getElementById("select_promotion_code");
        let percent = e.options[e.selectedIndex].getAttribute('data-percent');
        if (percent) {
            const promotional_price = price - (price * (percent / 100));
            console.log(promotional_price);
            document.getElementById("promotionprice").value = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(promotional_price).trim();
        } // trim() số thì dùng trim để xóa khoảng trắng
        else {
            document.getElementById("promotionprice").value = "";
        }
        // console.log(percent);
    } else {
        document.getElementById("promotionprice").value = "";
    }
});

