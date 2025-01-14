function uploadProductToFacebook(product, accessToken, catalogId, callback) {
    var data = {
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

    $.ajax({
        url: "https://graph.facebook.com/v12.0/" + catalogId + "/batch",
        type: "POST",
        headers: {
            "Authorization": "Bearer " + accessToken,
            "Content-Type": "application/json"
        },
        data: JSON.stringify(data),
        success: function (response) {
            callback(response);
        },
        error: function (xhr, status, error) {
            console.error("Error uploading product:", xhr.responseText);
            callback(null);
        }
    });
}
