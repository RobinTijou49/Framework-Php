<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat MCP') }}
        </h2>
    </x-slot>
<html>
<head>
    <title>Chat MCP</title>

    <style>
        body {
            font-family: Arial;
            background: #e5ddd5;
        }

        #chat-container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            height: 80vh;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        #messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }

        .message {
            max-width: 70%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 10px;
            word-wrap: break-word;
        }

        .user {
            background: #dcf8c6;
            margin-left: auto;
            text-align: right;
        }

        .bot {
            background: #f1f0f0;
            margin-right: auto;
        }

        #input-area {
            display: flex;
            border-top: 1px solid #ddd;
        }

        input {
            flex: 1;
            padding: 15px;
            border: none;
            outline: none;
        }

        button {
            padding: 15px;
            border: none;
            background: #075e54;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #0b7d6f;
        }

        .typing {
            font-style: italic;
            color: gray;
        }
    </style>
</head>

<body>

<div id="chat-container">
    <div id="messages"></div>

    <div id="input-area">
        <input type="text" id="input" placeholder="Pose ta question..." />
        <button onclick="sendMessage()">Envoyer</button>
    </div>
</div>

<script>
async function sendMessage() {
    const input = document.getElementById('input');
    const message = input.value.trim();

    if (!message) return;

    addMessage(message, 'user');
    input.value = '';

    // 🔽 loader
    const loaderId = addMessage("Le bot réfléchit...", "bot typing");

    try {
        const response = await fetch('/api/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        });

        const data = await response.json();

        // 🔥 supprimer loader
        removeMessage(loaderId);

        let text = '';

        // format réponse
        if (data.tool === "list_films") {
            text = data.result.map(f => `🎬 ${f.title}`).join("\n");
        }
        else if (data.tool === "get_locations_for_film") {
            if (data.result.length === 0) {
                text = "Aucune location trouvée.";
            } else {
                text = data.result.map(l => `📍 ${l.name ?? JSON.stringify(l)}`).join("\n");
            }
        }
        else {
            text = data.response;
        }

        addMessage(text, 'bot');

    } catch (error) {
        removeMessage(loaderId);
        addMessage("Erreur serveur 😢", "bot");
    }
}

// 💬 ajouter message
function addMessage(text, type) {
    const div = document.createElement('div');
    div.className = 'message ' + type;
    div.innerText = text;

    const id = Date.now();
    div.id = id;

    document.getElementById('messages').appendChild(div);

    scrollToBottom();

    return id;
}

// ❌ supprimer message (loader)
function removeMessage(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}

// 🔽 scroll auto
function scrollToBottom() {
    const container = document.getElementById('messages');
    container.scrollTop = container.scrollHeight;
}

// ⌨️ envoyer avec Enter
document.getElementById("input").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        sendMessage();
    }
});
</script>

</body>
</html>
</x-app-layout>
