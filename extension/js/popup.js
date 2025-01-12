document.addEventListener("DOMContentLoaded", function () {
    var syncButton = document.getElementById("sync-products");
    var statusMessage = document.getElementById("status-message");

    syncButton.addEventListener("click", function () {
        statusMessage.textContent = "Syncing products...";
        fetchProductsFromLocalhost(function (products) {
            if (!products || products.length === 0) {
                statusMessage.textContent = "No products found to sync.";
                return;
            }

            chrome.tabs.query({ active: true, currentWindow: true }, function (tabs) {
                if (tabs.length > 0) {
                    for (var i = 0; i < products.length; i++) {
                        chrome.tabs.sendMessage(tabs[0].id, { action: "uploadProduct", product: products[i] }, function (response) {
                            if (response && response.status === "Product uploaded") {
                                statusMessage.textContent = "Products synced successfully!";
                            }
                        });
                    }
                }
            });
        });
    });

    function fetchProductsFromLocalhost(callback) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://localhost/api/products", true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var products = JSON.parse(xhr.responseText);
                    callback(products);
                } catch (e) {
                    console.error("Error parsing product data:", e);
                    callback([]);
                }
            }
        };
        xhr.send();
    }
});