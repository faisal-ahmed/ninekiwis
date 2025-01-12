$(document).ready(function () {
    var syncButton = $("#sync-products");
    var statusMessage = $("#status-message");

    syncButton.on("click", function () {
        statusMessage.text("Fetching products...");

        // Fetch product details from the back-end
        $.ajax({
            url: "http://localhost/ninekiwis/index.php/Api/getProducts",
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response.products);
                if (response.products && response.products.length > 0) {
                    statusMessage.text("Product's loading is successful.");
                    populateTable(response.products);

                    // uploadProductsToFacebook(response.products);
                } else {
                    statusMessage.text("No products found.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching products:", error);
                statusMessage.text("Failed to fetch products.");
            }
        });
    });

    // Function to populate the table
    function populateTable(data) {
        try {
            var table = $("#data_table");
            var tbody = $("#productTableBody");

            // Clear existing rows
            tbody.html("");

            // Destroy the existing DataTable
            if ($.fn.DataTable.isDataTable("#data_table")) {
                table.DataTable().clear().destroy();
            }

            // Append new rows
            $.each(data, function (index, product) {
                var row =
                    '<tr>' +
                        '<td><button id="upload-to-fb" value="' + product.product_id + '" style="cursor: pointer;" class="btn-gradient-primary btn-block my-1">Upload to FB</button></td>' +
                        '<td><img src="' + product.image + '" alt="' + product.product_name + '" width="100"></td>' +
                        '<td>' + product.product_name + '</td>' +
                        '<td>' + product.description + '</td>' +
                        '<td>' + product.sku + '</td>' +
                        '<td>' + product.price + '</td>' +
                        '<td>' + product.stock + '</td>' +
                        '<td>' + product.category_title + '</td>' +
                        '<td>' + product.status + '</td>' +
                        '<td>' + product.created_at + '</td>' +
                    '</tr>';
                tbody.append(row);
            });

            // Reinitialize the DataTable
            table.DataTable({
                scrollX: true,
                responsive: false
            });
        } catch (error) {
            console.error("Error recreating DataTable:", error.message);
        }
    }

    function uploadProductsToFacebook(products) {
        $.each(products, function (index, product) {
            // Call the Facebook API for each product
            uploadProduct(product, function (response) {
                console.log("Product upload response:", response);
                statusMessage.text("Products uploaded successfully!");
            });
        });
    }

    function uploadProduct(product, callback) {
        // Make API call to Facebook Marketing API
        $.ajax({
            url: "https://graph.facebook.com/v12.0/{catalog_id}/batch",
            method: "POST",
            headers: {
                Authorization: "Bearer {your_access_token}",
                "Content-Type": "application/json"
            },
            data: JSON.stringify({
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
            }),
            success: function (response) {
                callback(response);
            },
            error: function (xhr, status, error) {
                console.error("Failed to upload product:", xhr.responseText);
            }
        });
    }
});
