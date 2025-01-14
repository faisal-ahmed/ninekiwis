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
                        '<td><button id="upload-to-fb_' + product.product_id + '" value="' + product.product_id + '" style="cursor: pointer;" class="fb_upload_button btn-gradient-primary btn-block my-1">Upload to FB</button></td>' +
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

    $(document).on('click', '.fb_upload_button', function() {
        product_id = $(this).val();
        startMarketPlaceSyncing(product_id);
    });

    function startMarketPlaceSyncing(product_id) {
        statusMessage.text("Fetching product details for Facebook Marketplace Uploading...");

        // Fetch product details from the back-end
        $.ajax({
            url: "http://localhost/ninekiwis/index.php/Api/getProductByID?id=" + product_id,
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response && response.length > 0) {
                    statusMessage.text("Product's loading is successful. Now uploading to FB marketplace");

                    // Send other information for product
                    var product = {
                        id: response[0].product_id,
                        name: response[0].product_name,
                        description: response[0].description,
                        category: response[0].category_title,
                        price: response[0].price,
                        availability: response[0].stock > 0 ? "in stock" : "out of stock",
                        image_url: response[0].image,
                        condition: "New",
                        url: "https://ninekiwis.de/"
                    };

                    chrome.runtime.sendMessage({
                        action: "uploadProductToMarketplace",
                        product: product
                    });
                } else {
                    statusMessage.text("No products found.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching products:", error);
                statusMessage.text("Failed to fetch products.");
            }
        });
    }
});
