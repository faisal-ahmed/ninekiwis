// N.B.: Always keep the console logs as this will run in extension console

chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.action === "uploadProductToMarketplace") {
        // Query the active tab in the current window
        chrome.tabs.query({ active: true, currentWindow: true }, function(tabs) {
            if (tabs && tabs.length > 0) {
                const activeTabId = tabs[0].id;

                // First check if the content script is already loaded, if not then force inject the script
                // Because sometime FB doesn't allow script to be injected.
                chrome.tabs.sendMessage(activeTabId, { action: "ping" }, function(response) {
                    if (chrome.runtime.lastError || !response) {
                        console.log("Content script not loaded, injecting now...");
                        chrome.scripting.executeScript({
                            target: { tabId: activeTabId },
                            files: ['js/content.js']
                        }, function() {
                            if (chrome.runtime.lastError) {
                                console.error("Script injection failed: " + chrome.runtime.lastError.message);
                            } else {
                                console.log('Content script injected successfully.');
                                sendMessageToContentScript(activeTabId, request.product);
                            }
                        });
                    } else {
                        console.log("Content script is already loaded.");
                        sendMessageToContentScript(activeTabId, request.product);
                    }
                });
            } else {
                console.error("No active tab found.");
            }
        });
    }
});

// This function sends message to the content script to uploadProductToMarketplace
function sendMessageToContentScript(tabId, product) {
    chrome.tabs.sendMessage(tabId, {
        action: "uploadProductToMarketplace",
        product: product
    }, function(response) {
        if (chrome.runtime.lastError) {
            console.error("Error sending message to content script: " + chrome.runtime.lastError.message);
        } else {
            console.log("Response from content script:", response);
        }
    });
}