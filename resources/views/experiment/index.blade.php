<!DOCTYPE html>
<html>
<head>
  <title>ChatGPT Interaction</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js/styles/default.min.css"> --}}
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css">
</head>
<body class="bg-gray-200">
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">ChatGPT Interaction</h1>
    <div id="chat-container" class="bg-white p-4 rounded-lg shadow">
      <div id="chat-log" class="mb-4"></div>
      <div id="input-container" class="flex space-x-2">
        <select id="model-select" class="px-2 py-1 border border-gray-400 rounded">
        </select>
        <input type="text" id="user-message" class="flex-grow px-2 py-1 border border-gray-400 rounded" placeholder="Type a message..." autocomplete="off">
        <button id="send-button" class="px-4 py-2 bg-blue-500 text-white font-semibold rounded">Send</button>
      </div>
    </div>
  </div>

  <script>
    const apiKey = "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";
    let model;

    function populateModels() {
      $.ajax({
        url: "https://api.openai.com/v1/models",
        headers: {
          'Authorization': `Bearer ${apiKey}`
        },
        success: function(response) {
          const models = response.data;
          const modelSelect = document.getElementById("model-select");

          models.forEach(model => {
            const option = document.createElement("option");
            option.value = model.id;
            option.text = model.id;
            modelSelect.appendChild(option);
          });

          model = models[0].id; // Set default model to the first available model
        },
        error: function(error) {
          console.error(error);
          document.getElementById("chat-log").innerText = "An error occurred while fetching models.";
        }
      });
    }

    function sendMessage() {
      const userMessage = document.getElementById("user-message").value.trim();
      if (userMessage === "") return;

      appendMessage("User", userMessage);
      document.getElementById("user-message").value = "";

      const selectedModel = document.getElementById("model-select").value;
      model = selectedModel;

      const data = {
        model: model,
        messages: [{ role: "user", content: userMessage }],
        temperature: 0.5
      };

      $.ajax({
        url: "https://api.openai.com/v1/chat/completions",
        method: "POST",
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${apiKey}`
        },
        data: JSON.stringify(data),
        success: function(response) {
          const output = response.choices[0].message.content;
          showTypingEffect("ChatGPT", output);
        },
        error: function(error) {
          console.error(error);
          appendMessage("ChatGPT", "An error occurred.");
        }
      });
    }

    function appendMessage(sender, message) {
      const chatLog = document.getElementById("chat-log");
      const messageDiv = document.createElement("div");
      messageDiv.innerHTML = `<strong>${sender}:</strong> ${message}`;
      chatLog.appendChild(messageDiv);
      chatLog.scrollTop = chatLog.scrollHeight;
    }

    function appendCodeMessage(sender, code) {
      const chatLog = document.getElementById("chat-log");
      const messageDiv = document.createElement("div");
      const codeBlock = document.createElement("pre");
      const codeContent = document.createElement("code");
      codeContent.innerText = code;
      codeContent.classList.add("language-python"); // Set the code language for syntax highlighting
      codeBlock.appendChild(codeContent);
      messageDiv.innerHTML = `<strong>${sender}:</strong>`;
      messageDiv.appendChild(codeBlock);
      chatLog.appendChild(messageDiv);
      chatLog.scrollTop = chatLog.scrollHeight;
      hljs.highlightAll();
    }

    function showTypingEffect(sender, message) {
      const delay = 50; // Delay between each character (in milliseconds)
      const chatLog = document.getElementById("chat-log");
      const messageDiv = document.createElement("div");
      const typingIndicator = document.createElement("span");
      typingIndicator.innerHTML = "<em>Typing...</em>";

      messageDiv.innerHTML = `<strong>${sender}:</strong> `;
      messageDiv.appendChild(typingIndicator);
      chatLog.appendChild(messageDiv);
      chatLog.scrollTop = chatLog.scrollHeight;

      let index = 0;
      const timer = setInterval(() => {
        if (index >= message.length) {
          clearInterval(timer);
          typingIndicator.innerHTML = ""; // Remove typing indicator
        } else {
          const char = message.charAt(index);
          messageDiv.innerHTML += char;
          index++;
        }
      }, delay);
    }

    // On page load
    document.addEventListener("DOMContentLoaded", function() {
      populateModels();

      const sendButton = document.getElementById("send-button");
      sendButton.addEventListener("click", sendMessage);

      const userMessageInput = document.getElementById("user-message");
      userMessageInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
          sendMessage();
        }
      });
    });
  </script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
  <script>
    hljs.highlightAll();
  </script>
</body>
</html>