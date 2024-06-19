const friendChats = {
    friend1: [],
    friend2: [],
    friend3: [],
    friend4: [],
    friend5: [],
    friend6: [],
    friend7: [],
    friend8: [],
    friend9: [],
    friend10: [],
    // Add more friends here
};

function showChat(friendName) {
    document.getElementById('chat-friend-name').innerText = friendName;
    const chatMessages = document.getElementById('messages');
    chatMessages.innerHTML = '';
    friendChats[friendName].forEach(message => {
        addMessage(message.message, message.type, message.sender);
    });
    const friendList = document.getElementById('friend-list');
    friendList.classList.remove('shrink'); // Expand friend list
    // Reset unread messages count to zero when a friend is clicked
    document.getElementById('unread-' + friendName).innerText = '0';

    // Display the recent message below the friend's name
    const recentMessage = friendChats[friendName][friendChats[friendName].length - 1];
    document.querySelector('.friend-info[data-friend="${friendName}"]').innerHTML += '<br><span>${recentMessage.message}</span>';
}

function addMessage(message, type, sender) {
    const chatMessages = document.getElementById('messages');
    const messageElement = document.createElement('div');
    messageElement.classList.add('message', type);
    const messageContent = document.createElement('div');
    messageContent.classList.add('message-content');
    messageContent.innerText = message;
    messageElement.appendChild(messageContent);
    if (sender) {
        const messageSender = document.createElement('div');
        messageSender.classList.add('message-sender');
        messageSender.innerText = sender;
        messageSender.innerHTML += <span class="message-time">${getCurrentTime()}</span>;
        messageElement.appendChild(messageSender);
    }
    chatMessages.appendChild(messageElement);
    scrollToBottom(chatMessages);
}

function scrollToBottom(element) {
    element.scrollTop = element.scrollHeight;
}

function getCurrentTime() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
}

function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    const friendName = document.getElementById('chat-friend-name').innerText;
    if (message !== '') {
        friendChats[friendName].push({ message: message, type: 'sent' });
        addMessage(message, 'sent');
        messageInput.value = '';
        scrollToBottom(document.getElementById('messages'));
        // Increment unread messages count for the current friend
        const unreadCount = parseInt(document.getElementById('unread-' + friendName).innerText);
        document.getElementById('unread-' + friendName).innerText = (unreadCount + 1).toString();
        // Simulate receiving a response after 1 second
        
    }
}

function receiveMessage(friendName, message, sender) {
    friendChats[friendName].push({ message: message, type: 'received', sender: sender });
    addMessage(message, 'received', sender);
    const friendList = document.getElementById('friend-list');
    friendList.classList.add('shrink'); // Shrink friend list
    // Increment unread messages count for the current friend
    const unreadCount = parseInt(document.getElementById('unread-' + friendName).innerText);
    document.getElementById('unread-' + friendName).innerText = (unreadCount + 1).toString();
}
