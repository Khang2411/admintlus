var exampleModal = document.getElementById('editModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button kích hoạt Modal
    var id = button.getAttribute('data-bs-id');    // Lấy thông tin  data-* attributes từ buton đó
    console.log(id);
    var data = {
        id: id,
    };
    // get token post fetch
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/khangbanmaytinh/admin/api/product/edit/show`, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN':token,
            'Content-Type': 'application/json',
        }
    })
        .then(res => res.json())
        .then(response => {
              console.log(response);
           document.getElementById('txtname').value=response.name;
           document.getElementById('txtprice').value=response.price;
           document.getElementById('select-category').value=response.category_id;
           document.getElementById('select-promotion-code').value=response.promotion_id;
           document.getElementById('promotion-price').value=new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.promotional_price).replace(/[₫ /\s/g]/g, ''); // thqy ₫ thành ''
           document.getElementById('preview-image-before-upload').innerHTML=`<img src="http://localhost:8080/khangbanmaytinh/${response.thumbnail}" width="70px"/>`;
           document.getElementById('txtpost').value=response.post;
        })
});

// Cập Nhật
document.getElementById('btn-sendmodal-edit').addEventListener('click', function () {
    let id = document.getElementById('txtid').value;
    let salary=document.getElementById('txtsalary').value;
    var data = {
        id: document.getElementById('txtid').value,
        name: document.getElementById("txtname").value,
        email: document.getElementById("txtemail").value,
        phone: document.getElementById("txtphone").value,
        salary: salary.replaceAll('.',''),
        role_id: document.getElementById("selectrole").value,
        note: document.getElementById("txtnote").value
    };
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch("/khangbanmaytinh/admin/api/user/edit", {
        method: 'PUT',
        body: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': token,
            'Content-Type': 'application/json',
        }
    })
        .then(res => res.json())
        .then(response => {
           let cells= document.getElementById('tr' + id).getElementsByTagName('td');
            cells[0].innerHTML=(response.name);
            cells[2].innerHTML=(response.phone);
            cells[3].innerHTML=('Admintrator');
            cells[4].innerHTML=new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.salary).replace(/[₫ /\s/g]/g, ''); // thqy ₫ thành ''(response.salary);
            alertSuccess();
        }).catch(error => alertFail());

});



