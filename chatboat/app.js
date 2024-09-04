document.getElementById('send-btn').addEventListener('click', function() {
    const userInput = document.getElementById('user-input').value;
    if (userInput) {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.innerHTML += `<div class="p-2 bg-gray-200 rounded mt-2">${userInput}</div>`;
        document.getElementById('user-input').value = '';
        
        // Send user input to server via fetch
        fetch('chatbot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message: userInput })
        })
        .then(response => response.json())
        .then(data => {
            chatWindow.innerHTML += `<div class="p-2 bg-blue-100 rounded mt-2">${data.reply}</div>`;
            chatWindow.scrollTop = chatWindow.scrollHeight;
        });
    }
});
