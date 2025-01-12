chrome.runtime.onMessage.addListener(function (message, sender, sendResponse) {
    if (message.action === "uploadProduct") {
        var product = message.product;

        try {
            // Simulate filling out the Facebook Marketplace form
            var titleField = document.querySelector('[name="title"]');
            var priceField = document.querySelector('[name="price"]');
            var descriptionField = document.querySelector('[name="description"]');

            if (titleField) titleField.value = product.title;
            if (priceField) priceField.value = product.price;
            if (descriptionField) descriptionField.value = product.description;

            // Submit the form (optional: uncomment if needed)
            // var submitButton = document.querySelector('[type="submit"]');
            // if (submitButton) submitButton.click();

            sendResponse({ status: "Product uploaded" });
        } catch (error) {
            console.error("Error uploading product:", error);
            sendResponse({ status: "Failed to upload product" });
        }
    }
});
