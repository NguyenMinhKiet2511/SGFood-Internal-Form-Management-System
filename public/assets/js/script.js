// $(document).ready(function(){
//     $("#create-btn").click(function(){
//         $("#create-modal").modal("toggle")    
//     });

//     $("#create-form").validate({
//         rules:{
//                 name: {
//                 required: true,
//                 minlength: 3,
//                 maxlength: 255
//                 },
//                 email: {
//                     required: true,
//                     email: true
            
//                 },
//                 password: {
//                     required: true
//                 },
//                 role: {
//                     required: true,
//                     // kiểm tra giá trị phải nằm trong danh sách hợp lệ
//                     pattern: /^(user|admin)$/
//                 },
//                 department: {
//                     required: true,
//                     pattern: /^(IT|HR|Finance|Sale|Logistic|Production)$/
//                 }
//                 },
//                 messages: {
//                 name: {
//                     required: "Please enter a name",
//                     maxlength: "Name must be less than 255 characters"
//                 },
//                 email: {
//                     required: "Please enter an email",
//                     email: "Invalid email format"
//                 },
//                 password: {
//                     required: "Please enter a password"
//                 },
//                 role: {
//                     required: "Please select a role",
//                     pattern: "Role must be either 'user' or 'admin'"
//                 },
//                 department: {
//                     required: "Please select a department",
//                     pattern: "Department must be valid"
//                 }
//         },
//         submitHandler: function(form){
//             $("#response").empty();
//             const formData = $(form).serializeArray();

//             $.ajax({
//                 url : "admin",
//                 type : "Post",
//                 data : formData,
//                 beforeSend: function() {
//                     console.log('Loading...');
//                 },
//                 success: function(response) {
//                     $("#create-form")[0].reset();
//                     $("#create-modal")[0].modal("toggle");

//                     if(response.status =="success"){
//                         $("#response").html(
//                             `<div class='alert alert-success alert-dismissible'>\

//                             ${reponse.message}
//                             <button type ='button' class='btn-close' data-dismiss = 'alert'></button></div>`
//                         );
//                         $("#create-table").append(
//                             `<tr>
//                                 <td>${response.user.id }</td>
//                                 <td>${response.user.name }</td>
//                                 <td>${response.user.email }</td>
//                                 <td>${response.user.role }</td >
//                                 <td>${response.user.department }</td>
//                                 <td>${ user.created_at.format('d/m/Y H:i') }</td>
//                                 <td>
//                                 <a href="#" id="edit-btn" class="btn btn-sm btn-warning"><i class="bi bi-pen"></i></a>
//                                 {{-- <form action="{{ route('admin.delete.user', $user->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');"> --}}
//                                 <form action="#" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
//                                     @csrf
//                                     @method('DELETE')
//                                     <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
//                                 </form>
//                                 </td>
//                             </tr>`
//                         )
//                     }
//                     else if(response.status =="failed"){
//                         $("#response").html(
//                             `<div class='alert alert-danger alert-dismissible'>\

//                             ${reponse.message}
//                             <button type ='button' class='btn-close' data-dismiss = 'alert'></button></div>`
//                         );
//                     }

//                 },
//                 error: function(){
//                     $("#response").html(
//                         `<div class='alert alert-success alert-dismissible'>\
//                         ${reponse.message}
//                         <button type ='button' class='btn-close' data-dismiss = 'alert'></button></div>`
//                     );
//                 }
//             });
//         }
//     });
//     $("#user-table").dataTable();
// });



// Capitalize first letter
function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Format datetime to DD/MM/YYYY HH:mm
function formatDate(datetime) {
  const date = new Date(datetime);
  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const year = date.getFullYear();
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  return `${day}/${month}/${year} ${hours}:${minutes}`;
}

// Edit user
function editUser(userId, modal) {
  const name = modal.find('.name-input').val();
  const email = modal.find('.email-input').val();
  const department = modal.find('.department-input').val();
  const role = modal.find('.role-input').val();

  $.ajax({
    url: '/admin/update-user/' + userId,
    type: 'POST',
    data: { name, email, department, role },
    success: function () {
      $('#user-row-' + userId).find('.user-name').text(name);
      $('#user-row-' + userId).find('.user-email').text(email);
      $('#user-row-' + userId).find('.user-department').text(department);
      $('#user-row-' + userId).find('.user-role').text(capitalize(role));
      modal.modal('hide');
    },
    error: function (xhr) {
      console.error(xhr.responseText);
      alert('Lỗi khi chỉnh sửa user.');
    }
  });
}

// Create new user
function createUser(modal) {
  const name = modal.find('.create-name').val();
  const email = modal.find('.create-email').val();
  const password = modal.find('.create-password').val();
  const role = modal.find('.create-role').val();
  const department = modal.find('.create-department').val();

  $.ajax({
    url: '/admin/create-user',
    method: 'POST',
    data: { name, email, password, role, department },
    success: function (user) {
      const userTable = $('#user_table').DataTable();

      const newRow = [
        user.id,
        `<span class="user-name">${user.name}</span>`,
        `<span class="user-email">${user.email}</span>`,
        `<span class="user-role">${capitalize(user.role)}</span>`,
        `<span class="user-department">${user.department}</span>`,
        `${formatDate(user.created_at)}`,
        `<button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal${user.id}">
           <i class="bi bi-pen"></i>
         </button>
         <form method="POST" action="/admin/delete-user/${user.id}" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
           <input type="hidden" name="_method" value="DELETE">
           <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
         </form>`
      ];

      const rowNode = userTable.row.add(newRow).draw(false).node();
      $(rowNode).attr('id', 'user-row-' + user.id).addClass('table-success');

      setTimeout(() => {
        $(rowNode).removeClass('table-success');
      }, 3000);

      modal.modal('hide');
      modal.find('input').val('');
    },
    error: function (xhr) {
      alert('Lỗi khi tạo user: ' + xhr.responseText);
    }
  });
}

$(document).ready(function () {
  // CSRF token setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Save edited user
  $('.btn-save-user').click(function () {
    const userId = $(this).data('user-id');
    const modal = $(this).closest('.modal');
    editUser(userId, modal);
  });

  // Create new user
  $('.btn-create-user').click(function () {
    const modal = $('#createUserModal');
    createUser(modal);
  });

  // Initialize DataTables
  $('#user_table').DataTable({ responsive: true });
  $('#assigned_table').DataTable({ responsive: true });
  $('#form_table').DataTable();
});
