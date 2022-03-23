// Bootbox alert
function alertSuccess() {
    swal("Thành công!", "", "success");
}
function alertFail() {
    swal("Thất bại!", "Hãy xem lại!", "error");
}
function alertLoading() {
    bootbox.dialog({
        title: "<span style='color: green;'>Đang gửi</span>",
        message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>',
        closeButton: false
    })
}

//  Modal lấy thông tin từ data-* button kích hoạt nó - Vì thông tin cần bảo mật nên load từ fetch lên
var exampleModal = document.getElementById('editModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button kích hoạt Modal
    var id = button.getAttribute('data-bs-id');    // Lấy thông tin  data-* attributes từ buton đó
    console.log(id);
    var data = {
        id: id,
    };
    // get token
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(`/khangbanmaytinh/admin/api/user/edit/show`, {
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
           document.getElementById('txtid').value=response.id;
           document.getElementById('txtname').value=response.name;
           document.getElementById('txtemail').value=response.email;
           document.getElementById('txtphone').value=response.phone;
           document.getElementById('txtsalary').value=new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.salary).replace(/[₫ /\s/g]/g, ''); // thqy ₫ thành ''
           document.getElementById('selectrole').value=response.role_id;
           document.getElementById('txtnote').value=response.note;
        })
});

// Cập Nhật
document.getElementById('btn_sendmodal_edit').addEventListener('click', function () {
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



