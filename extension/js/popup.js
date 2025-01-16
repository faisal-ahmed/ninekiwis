$(document).ready(function () {
    var syncButton = $("#sync-products");
    var statusMessage = $("#status-message");
    var baseAPIEndpoint = "http://localhost/ninekiwis/index.php/Api/";

    /*
         Helper Function: Sync Button Click Event
         Description:
            This function fetches the product's from the server and
            load it as html in the extension page
     */
    syncButton.on("click", function () {
        statusMessage.text("Fetching products...");
        $.ajax({
            url: baseAPIEndpoint + "getProducts",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.products && response.products.length > 0) {
                    statusMessage.text("Product's loading is successful.");
                    populateTable(response.products);
                } else {
                    statusMessage.text("No products found.");
                }
            },
            error: function (xhr, status, error) {
                statusMessage.text("Failed to fetch products.");
            }
        });
    });

    /*
         Helper Function: FB Upload Button Click Event
         Description:
             This function initiates the product upload to the FB marketplace
     */
    $(document).on('click', '.fb_upload_button', function() {
        product_id = $(this).val();
        startMarketPlaceSyncing(product_id);
    });

    /*
        Helper Function: populateTable(data)
        Description:
            This function adds the product's row in the html
        Param:
            data: Array of products
     */
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
            statusMessage.text("Error recreating DataTable: " + error.message);
        }
    }

    /*
         Helper Function: startMarketPlaceSyncing(product_id)
         Description:
             This function prepares the product and call the chrome API to push
             data to FB Marketplace.
         Param:
            product_id: Product's id which will be pushed to the FB Marketplace
     */
    function startMarketPlaceSyncing(product_id) {
        statusMessage.text("Fetching product details for Facebook Marketplace Uploading...");
        $.ajax({
            url: baseAPIEndpoint + "getProductByID?id=" + product_id,
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response && response.length > 0) {
                    statusMessage.text("Product loading is successful. Now uploading to FB marketplace");
                    const imageUrl = response[0].image;

                    // Call createBlogAsBase64FromImageUrl with a callback
                    createBlogAsBase64FromImageUrl(imageUrl, function (error, base64String) {
                        if (error) {
                            statusMessage.text("Failed to load product image. Error creating Base64 string: " + error);
                        } else {
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

                            // Call chrome API to call function of content.js
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
                statusMessage.text("Failed to fetch products.");
            }
        });
    }

    /*
     Helper Function: createBlogAsBase64FromImageUrl(imageUrl, callback)
     Description:
         This function fetches the blob content of the image and then
         creates the base64 string
     Param:
        imageUrl: image url to fetch the image and create base64 string
            Format: Any valid accessible web address
        callback: function to return the call
     */
    function createBlogAsBase64FromImageUrl(imageUrl, callback) {
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
                        callback(null, base64String);
                    };
                    reader.onerror = function (error) {
                        statusMessage.text('Error reading blob as Base64: ' + error);
                        callback(error);
                    };
                    reader.readAsDataURL(blob);
                } catch (error) {
                    statusMessage.text('Error processing blob: ' + error);
                    callback(error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                statusMessage.text('Error fetching image. Status: ' + textStatus + " | Error: " + errorThrown);
                callback(new Error('Error fetching image: ' + textStatus));
            }
        });
    }
});
