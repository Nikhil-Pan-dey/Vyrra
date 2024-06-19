// Sample notifications data
let notifications = [
    { type: 'Like', details: 'Nikhil pandey liked your post "10 Tips for Web Development".' },
    { type: 'Follow', details: 'Subham Das started following you.' },
    { type: 'Group Invitation', details: 'You\'ve been invited to join the "Web Developers" group.' },
    { type: 'Event', details: 'Event: spring spee - Date: April 5, 2024 - Location: Conference Room 101' },
    { type: 'Event', details: 'Event: Web Development Workshop - Date: April 10, 2024 - Location: Conference Room 101' },
    { type: 'Follow Request', details: 'Subham Das wants to follow you.' },
    { type: 'Event', details: 'Event: spring spee - Date: April 5, 2024 - Location: Conference Room 101' },
    { type: 'Like', details: 'Nikhil pandey liked your post "10 Tips for Web Development".' },
];

// Function to display notifications on the sidebar
function displayNotifications() {
    const sidebar = document.getElementById('sidebar');

    // Clear existing notifications
    sidebar.innerHTML = '<h1>notification-bar</h1>';

    // Add new notifications
    notifications.forEach((notification, index) => {
        const notificationElement = document.createElement('div');
        notificationElement.classList.add('notification');
        notificationElement.innerHTML = `
            <div class="type">${notification.type}</div>
            <div class="details">${notification.details}</div>
            ${notification.type === 'Follow Request' ? 
                `<div class="action-buttons">
                    <button class="accept-btn" onclick="acceptFollowRequest(${index})">Accept</button>
                    <button class="reject-btn" onclick="rejectFollowRequest(${index})">Reject</button>
                </div>` : ''}
        `;
        notificationElement.addEventListener('click', () => removeNotification(index));
        sidebar.appendChild(notificationElement);
    });
}

// Display notifications when the page loads
displayNotifications();

// Function to remove a notification
function removeNotification(index) {
    notifications.splice(index, 1);
    displayNotifications();
}

// Function to clear all notifications
function clearNotifications() {
    notifications = [];
    displayNotifications();
}

// Function to accept a follow request
function acceptFollowRequest(index) {
    // Perform actions here (e.g., add the follower to your followers list)
    // Set accepted flag for the follow request notification
    notifications[index].accepted = true;
    // Add a notification that you are now friends
    notifications.push({ type: 'You are now friends', details: '' });
    // Display notifications
    displayNotifications();
    // Redirect to profile page after 3 seconds
    setTimeout(() => {
        window.location.href = '#'; // Redirect to profile page
    }, 3000);
}

// Function to reject a follow request
function rejectFollowRequest(index) {
    // Perform additional actions here (e.g., notify the user that their follow request was rejected)
    notifications.splice(index, 1);
    displayNotifications();
}