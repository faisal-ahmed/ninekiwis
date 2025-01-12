function uploadProductToFacebook(product, accessToken, catalogId, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "https://graph.facebook.com/v12.0/" + catalogId + "/batch", true);
    xhr.setRequestHeader("Authorization", "Bearer " + accessToken);
    xhr.setRequestHeader("Content-Type", "application/json");

    var payload = {
        requests: [
            {
                method: "CREATE",
                data: {
                    retailer_id: product.id,
                    name: product.name,
                    description: product.description,
                    price: product.price + " EUR",
                    availability: "in stock",
                    image_url: product.image_url,
                    url: product.url
                }
            }
        ]
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                callback(JSON.parse(xhr.responseText));
            } else {
                console.error("Error uploading product:", xhr.responseText);
                callback(null);
            }
        }
    };

    xhr.send(JSON.stringify(payload));
}
