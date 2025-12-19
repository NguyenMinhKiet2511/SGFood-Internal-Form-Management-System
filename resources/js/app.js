import 'bootstrap';
// import $ from 'jquery';
// window.$ = $;
// window.jQuery = $;

// import 'datatables.net-bs5';
// import 'datatables.net-buttons-bs5'; 
// import Pusher from 'pusher-js';
// import toastr from 'toastr';

// const userId = window.userId;

// Pusher.logToConsole = true;

// const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     encrypted: true,
// });

// const channel = pusher.subscribe('private-App.Models.User.' + userId);

// channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function (data) {
//     const { message, url, form_number } = data;

//     // Toastr notification
//     toastr.info(
//         `<strong>${form_number}</strong><br>${message}`,
//         'New Notification',
//         {
//             progressBar: true,
//             closeButton: true,
//             positionClass: 'toast-top-right',
//         }
//     );

//     // Update bell count
//     const countBadge = document.getElementById('notif-count');
//     let currentCount = parseInt(countBadge.innerText) || 0;
//     currentCount++;
//     countBadge.innerText = currentCount;
//     countBadge.style.display = 'inline-block';

//     // Highlight bell
//     const bellIcon = document.getElementById('notif-icon');
//     bellIcon.classList.add('text-warning');
//     setTimeout(() => bellIcon.classList.remove('text-warning'), 3000);

//     // Prepend new notification
//     const notifList = document.getElementById('notif-list');
//     const li = document.createElement('li');
//     li.className = 'px-2';
//     li.innerHTML = `
//         <a href="${url}" class="dropdown-item">
//             📄 <strong>${form_number}</strong> — ${message}
//         </a>
//     `;
//     notifList.prepend(li);
// });
