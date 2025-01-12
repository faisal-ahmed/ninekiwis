var isAutoSyncEnabled = false;

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
