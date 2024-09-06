<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4 bg-blue-600 text-white">
                <h1 class="text-xl">Chatbot</h1>
            </div>
            <div class="p-4 h-64 overflow-y-auto" id="chat-window">
                <!-- Messages will appear here -->
            </div>
            <div class="p-4 bg-gray-200 flex">
                <input type="text" id="user-input" class="flex-grow p-2 border rounded" placeholder="Type a message...">
                <button id="send-btn" class="ml-2 p-2 bg-blue-600 text-white rounded">Send</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('send-btn').addEventListener('click', function () {
            sendMessage();
        });

        document.getElementById('user-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        function sendMessage() {
            const userInput = document.getElementById('user-input').value.trim();
            const chatWindow = document.getElementById('chat-window');

            if (userInput !== '') {
                // Display user's message
                chatWindow.innerHTML += `<div class="p-2 bg-gray-200 rounded mt-2 text-right">${userInput}</div>`;
                document.getElementById('user-input').value = '';
                document.getElementById('user-input').focus();
                chatWindow.scrollTop = chatWindow.scrollHeight;

                // Send user input to the server via fetch
                fetch('chatbot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message: userInput })
                })
                .then(response => response.json())
                .then(data => {
                    // Display bot's reply
                    chatWindow.innerHTML += `<div class="p-2 bg-blue-100 rounded mt-2">${data.reply}</div>`;
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                })
                .catch(error => {
                    console.error('Error:', error);
                    chatWindow.innerHTML += `<div class="p-2 bg-red-100 rounded mt-2">Oops! Something went wrong.</div>`;
                });
            }
        }
    </script>
</body>

</html>
<!--index.php code  -->
