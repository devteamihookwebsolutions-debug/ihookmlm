<script>
   function toggleTicketModal(modalId) {
        const targetEl = document.getElementById(modalId);
        if (!targetEl) return;

        const options = {
            backdrop: true,
            keyboard: true,
            focus: true
        };

        const modalInstance = new Modal(targetEl, options);
        modalInstance.show();

        // Fetch ticket data
        fetch(`/admin/ticketdata`)
            .then(response => response.json())
            .then(data => {
                const ticketBody = document.getElementById('tickets-body');
                ticketBody.innerHTML = ''; // Clear existing content

                data.forEach(ticket => {
                    const row = document.createElement('tr');
                    row.classList.add('bg-white', 'border-b', 'dark:bg-neutral-900', 'dark:border-neutral-700', 'border-neutral-200');
                    row.innerHTML = `
                        <th scope="row" class="px-6 py-4 font-medium text-black dark:text-white whitespace-nowrap dark:text-white">
                            ${ticket.members_username}
                        </th>
                        <td class="px-6 py-4 dark:text-neutral-100">${ticket.ticket_number}</td>
                        <td class="px-6 py-4 dark:text-neutral-100">${ticket.date}</td>
                        <td class="px-6 py-4 dark:text-neutral-100">
                            ${ticket.status == 2 ? 'PENDING' : ticket.status == 0 ? 'OPEN' : ticket.status == -1 ? 'NEW' : 'CLOSED'}
                        </td>`;
                    ticketBody.appendChild(row);
                });
            })
            .catch(error => console.log('Error fetching data:', error));
    }

    function closeTicketModal(modalId) {
        const targetEl = document.getElementById(modalId);
        if (!targetEl) return;

        const options = {
            backdrop: true,
            keyboard: true,
            focus: true
        };

        const modalInstance = new Modal(targetEl, options);
        modalInstance.hide();
    }

    document.querySelector('[data-drawer-target="drawer-chat-navigation"]').addEventListener('click', async function() {
        // console.log('Opening drawer...');
        const toggle = document.querySelector('[data-drawer-target="drawer-chat-navigation"]');
        if (!toggle) return;

        toggle.addEventListener('click', async function () {
        const drawer = document.getElementById("drawer-chat-navigation");
            if (!drawer) return;
            drawer.classList.remove("hidden");
            drawer.classList.remove("left-0");
        });

        try {
            const response = await fetch("/admin/groupchat", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            // console.log("Group Chat Data:", data);

            // Assuming you have an element inside the drawer to display messages
                const chatContainer = document.getElementById("chat-messages");
                if (chatContainer) {
                chatContainer.innerHTML = ""; // Clear existing messages

                data.chat.forEach(message => {
                    const messageElement = document.createElement("div");
                    messageElement.classList.add("flex", "mb-2");
                   // Format the date
                    const formattedDate = new Date(message.date).toLocaleString();

                    // Apply different styles for sent & received messages
                    if (message.members_id === "admin") {
                        messageElement.classList.add("justify-end");
                        messageElement.innerHTML = `
                             <div class="flex flex-col items-end">
                                <div class="bg-neutral-200 text-black text-xs p-2 rounded-lg max-w-xs">
                                    ${message.message}
                                </div>
                                <div class="text-black text-[10px] mt-1">${formattedDate}</div>
                            </div>
                        `;
                    } else {
                        messageElement.innerHTML = `<div class="flex flex-col items-start">
                                              <div class="font-semibold text-sm text-black">${message.members_username}</div>
                           
                            <div class="bg-neutral-300 text-black text-xs p-2 rounded-lg max-w-xs">
                                ${message.message}
                            </div>
                            <div class="text-black text-[10px] mt-1">${formattedDate}</div>
                            </div>
                        `;
                    }

                    chatContainer.appendChild(messageElement);
                });
            }
        } catch (error) {
            console.error("Error fetching group chat data:", error);
        }
        try {
            const response = await fetch("/admin/recentactivities", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const data = await response.json();
            // console.log("Group Chat Data:", data);

            // Assuming you have an element inside the drawer to display messages
            const chatContainer = document.getElementById("log-messages");
            if (chatContainer) {
                    chatContainer.innerHTML = ""; // Clear existing messages

                    data.forEach(message => {
                        const messageElement = document.createElement("div");
                        messageElement.classList.add("flex", "mb-2");
                        const formattedDate = new Date(message.date).toLocaleString();

                        messageElement.innerHTML = `<div class="flex items-center mb-2">
                        <div
                        class="flex-shrink-0 bg-neutral-20.0 text-blue-700 border border-neutral-800  focus:outline-none focus:ring-neutral-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 ">
                        <svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                            d="M10 5a2 2 0 0 0-2 2v3h2.4A7.48 7.48 0 0 0 8 15.5a7.48 7.48 0 0 0 2.4 5.5H5a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h1V7a4 4 0 1 1 8 0v1.15a7.446 7.446 0 0 0-1.943.685A.999.999 0 0 1 12 8.5V7a2 2 0 0 0-2-2Z"
                            clip-rule="evenodd"></path>
                            <path fill-rule="evenodd"
                            d="M10 15.5a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0Zm6.5-1.5a1 1 0 1 0-2 0v1.5a1 1 0 0 0 .293.707l1 1a1 1 0 0 0 1.414-1.414l-.707-.707V14Z"
                            clip-rule="evenodd"></path>
                        </svg>
                        </div>
                        <div class="ml-4">
                        <span class="text-sm font-medium text-black dark:text-white">
                            ${message.content}
                        </span>
                        <br>
                        <span class="text-xs text-black dark:text-white">
                            ${formattedDate}
                        </span>
                        </div>
                    </div>
                            `;

                        chatContainer.appendChild(messageElement);
                    });
            }
            
        } catch (error) {
            console.error("Error fetching group chat data:", error);
        }    
        
    })
    document.getElementById('closeDrawerButton').addEventListener('click', function() {
        const drawer = document.getElementById("drawer-chat-navigation");
        if (!drawer) return;

        drawer.classList.add("hidden");
    })
    function sendMessage() {
        const messageInput = document.getElementById("messageInput");
        const message = messageInput.value.trim(); // Remove leading/trailing spaces

        const sendButton = document.querySelector("button"); // Get the send button element

        if (!message) {
             // Validation: If message is empty
            Swal.fire({
                icon: 'error',
                title: 'Chat Message',
                text: 'Please type a message before sending.',
                confirmButtonText: 'Okay',
                customClass: {
                    title: 'text-xl font-semibold text-black', // Customize title style

                    confirmButton: 'bg-neutral-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-blue-300' // Apply Tailwind classes here
                },
                allowOutsideClick: false, // Prevents closing by clicking outside
                allowEscapeKey: false  // Prevents closing by pressing the escape key
            });

            return; // Exit the function if message is empty
        }

        // Disable the send button while the message is being sent
        sendButton.disabled = true;
        sendButton.classList.add("opacity-50"); // Optional: Add opacity for disabled button

        // Example: Sending message via a POST request
        fetch("/admin/savegroupchat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                sendmessage: message,
                date: new Date().toISOString() // Send the current timestamp
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log("Message sent:", data);

            // Reset input field and enable the send button again
            messageInput.value = "";
            sendButton.disabled = false;
            sendButton.classList.remove("opacity-50"); // Remove opacity

             // After message is sent, update the chat container dynamically
            appendMessageToChat(message);
        })
        .catch(error => {
            console.error("Error sending message:", error);
            alert("Something went wrong. Please try again.");
            sendButton.disabled = false;
            sendButton.classList.remove("opacity-50");
        });
    }
    function appendMessageToChat(message) {
        const chatContainer = document.getElementById("chat-messages"); // Assuming you have a container for the messages

        // Create a new message element
        const messageElement = document.createElement("div");
        messageElement.classList.add("flex", "mb-2");

        // Assuming the message is sent by the user/admin
        messageElement.classList.add("justify-end");
        messageElement.innerHTML = `
         <div class="flex flex-col items-end">
                                <div class="bg-neutral-200 text-black text-xs p-2 rounded-lg max-w-xs">
                                   ${message}
                                </div>
                                <div class="text-black text-[10px] mt-1">${new Date().toLocaleString()}</div>
                            </div>
        `;

        // Append the new message to the chat container
        chatContainer.appendChild(messageElement);
    }
    function toggleDropdownNotifications() {
        const dropdown = document.getElementById("dropdownNotification");
        if (!dropdown) return;

        dropdown.classList.toggle("hidden");

            fetch("/admin/getadminnewnotification", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(obj => {
                if (obj.newnotificationcount === 0) {
                    // document.getElementById('alert_dot').style.display = 'none';
                }
                document.getElementById('newnotification').innerHTML = obj.notification;
                // document.getElementById('cntforlatest').innerHTML = obj.newnotificationcount;
            })
            .catch(error => console.log('Error fetching notifications:', error));
    }

    function toggleSelectAll(checkbox) {
        const isChecked = checkbox.checked;
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = isChecked);
    }

    // Handle individual row checkbox change
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            const allCheckbox = document.getElementById('checkbox-all');
            if (!cb.checked) {
                allCheckbox.checked = false;
            } else {
                allCheckbox.checked = Array.from(rowCheckboxes).every(cb => cb.checked);
            }
        });
    });
   

    function handleFeatureSettings(featureName) {
        const isChecked = document.getElementById(featureName).checked;
        const code = isChecked ? '1' : '0'; // Set '1' for checked and '0' for unchecked

        // Perform the fetch call
        fetch(`/admin/updatefeature/update/${code}/${featureName}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json', // Optionally specify content type
            }
        })
        .then(response => response.json()) // Assuming the response is in JSON format
        .then(data => {
            console.log(data); // Handle the response
        })
        .catch(error => {
            console.error('Error:', error); // Handle any errors
        });
    }
    

    document.addEventListener('DOMContentLoaded', function () {

        var themeToggleLi = document.getElementById("theme-toggle-li");
        var themeToggleText = document.getElementById("theme-toggle-text");
        var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
        var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

        // Function to update UI based on theme
        function updateThemeUI(isDark) {
            if (isDark) {
                document.documentElement.classList.add("dark");
                themeToggleDarkIcon.classList.add("hidden");
                themeToggleLightIcon.classList.remove("hidden");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                themeToggleDarkIcon.classList.remove("hidden");
                themeToggleLightIcon.classList.add("hidden");
                localStorage.setItem("color-theme", "light");
            }
        }

        // Check localStorage or system preference
        var isDarkMode = localStorage.getItem("color-theme") === "dark" || 
        (!localStorage.getItem("color-theme") && window.matchMedia("(prefers-color-scheme: dark)").matches);

        updateThemeUI(isDarkMode); // Apply correct state on page load

        // Toggle theme when clicking anywhere on the <li>
        themeToggleLi.addEventListener("click", function () {
        var isCurrentlyDark = document.documentElement.classList.contains("dark");
        updateThemeUI(!isCurrentlyDark);
        });

        
        // Elements for changing language
        const languageButton = document.querySelector('button[data-dropdown-toggle="language-dropdown-menu"]');
        const languageFlag = document.getElementById('language-flag');
        const languageName = document.getElementById('language-name');

        // Function to change language dynamically
        window.changeLanguage = function (languageElement) {
            const lang = languageElement.getAttribute('data-lang'); // Language code
            const flagSVG = languageElement.getAttribute('data-svg'); // SVG string
            const langName = languageElement.getAttribute('data-name'); // Language name
            // Get existing localStorage data
            const existingData = JSON.parse(localStorage.getItem('icsData')) || {};
            const languageData = {
                ...existingData, // Preserve existing data (backendLanguage, etc.)
                backendLanguage: {
                    lang: lang,
                    flagSVG: flagSVG,
                    langName: langName
                }
            };

            // Store in localStorage
            localStorage.setItem('icsData', JSON.stringify(languageData));
            // console.log('Language changed to:', lang, langName);

            // **Immediately update UI before session call**
            if (languageFlag) languageFlag.innerHTML = flagSVG;

            // Send language preference to the server
            setLanguageInSession(lang, true);
        };

        });

        // Function to send language preference to the PHP session
        function setLanguageInSession(lang, shouldReload = false) {
            fetch('/admin/setlanguage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'lang=' + encodeURIComponent(lang)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Language set in session:', data);

                // **Ensure sessionStorage is updated before reload**
                sessionStorage.setItem('languageSet', lang);

                // Reload page only once
                if (shouldReload) {
                    setTimeout(() => location.reload(), 500); // Allow time for the session update
                }
            })
            .catch(error => {
                console.error('Error setting language in session:', error);
            });
        }

        // Apply stored language settings on page load
        window.onload = function () {

            
        const loader = document.getElementById("page-loader");
        if (loader) {
            loader.classList.add("opacity-0", "pointer-events-none");
            setTimeout(() => loader.remove(), 500); // Optional: fully remove after fade
        }
        
        const storedLanguageData = JSON.parse(localStorage.getItem('icsData'));

        if (storedLanguageData && storedLanguageData.backendLanguage) {
            const { backendLanguage } = storedLanguageData;

            if (backendLanguage && backendLanguage.flagSVG) {
                document.getElementById('language-flag').innerHTML = backendLanguage.flagSVG;
            } else {
                console.log('flagSVG is missing in backendLanguage');
            }

            // **Ensure session is set only once, and prevent double reload**
            if (sessionStorage.getItem('languageSet') !== backendLanguage.lang) {
                setLanguageInSession(backendLanguage.lang);
            }
        } else {
            // console.log('storedLanguageData or backendLanguage is undefined');
        }
    };

</script>
  
