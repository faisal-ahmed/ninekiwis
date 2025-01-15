$(document).ready(function () {
    var syncButton = $("#sync-products");
    var statusMessage = $("#status-message");

    syncButton.on("click", function () {
        statusMessage.text("Fetching products...");

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

    function populateTable(data) {
        try {
            var table = $("#data_table");
            var tbody = $("#productTableBody");

            tbody.html("");

            // Destroy the existing DataTable
            if ($.fn.DataTable.isDataTable("#data_table")) {
                table.DataTable().clear().destroy();
            }

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

        $.ajax({
            url: "http://localhost/ninekiwis/index.php/Api/getProductByID?id=" + product_id,
            method: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response && response.length > 0) {
                    statusMessage.text("Product's loading is successful. Now uploading to FB marketplace");

                    const imageUrl = response[0].image;

                    // Call createFileFromImageUrl with a callback
                    createFileFromImageUrl(imageUrl, function (error, base64String) {
                        if (error) {
                            console.error('Error creating Base64 string:', error);
                            statusMessage.text("Failed to load product image");
                        } else {
                            console.log('Base64 String received:', base64String);

                            const product = {
                                id: response[0].product_id,
                                name: response[0].product_name,
                                description: response[0].description,
                                category: response[0].category_title,
                                price: response[0].price,
                                availability: response[0].stock > 0 ? "in stock" : "out of stock",
                                image_url: imageUrl,
                                image_file: base64String,
                                condition: "New",
                                url: "https://ninekiwis.de/"
                            };

                            chrome.runtime.sendMessage({
                                action: "uploadProductToMarketplace",
                                product: product
                            });
                        }
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

    function createFileFromImageUrl(imageUrl, callback) {
        $.ajax({
            url: imageUrl,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: function (blob) {
                try {
                    const reader = new FileReader();
                    reader.onloadend = function () {
                        const base64String = reader.result.split(',')[1];
                        console.log('Base64 String:', base64String);
                        callback(null, base64String);
                    };
                    reader.onerror = function (error) {
                        console.error('Error reading blob as Base64:', error);
                        callback(error);
                    };
                    reader.readAsDataURL(blob);
                } catch (error) {
                    console.error('Error processing blob:', error);
                    callback(error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error fetching image:', textStatus, errorThrown);
                callback(new Error('Error fetching image: ' + textStatus));
            }
        });
    }

});
