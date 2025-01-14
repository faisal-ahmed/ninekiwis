console.log("Content script loaded");

chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.action === "ping") {
        sendResponse({ status: "Content script is loaded" });
    }

    if (request.action === "uploadProductToMarketplace") {
        uploadProductToMarketplace(request.product);
        sendResponse({ status: "Product upload triggered" });
    }
});

function uploadProductToMarketplace(product) {
    populateAndSubmitForm(product);
    /* const waitForMarketplaceForm = setInterval(function () {
        const form = $('form[data-testid="marketplace_form"]'); // Replace with the correct form selector
        if (form.length > 0) {
            clearInterval(waitForMarketplaceForm);
            populateAndSubmitForm(product);
        }
    }, 1000); */
}

function populateAndSubmitForm(product) {
    try {
        setInputField('label[aria-label="Title"] input', product.name);
        setInputField('label[aria-label="Price"] input', product.price);

        setSelectOption('label[aria-label="Category"]', 'div[role="button"]', product.category);
        setSelectOption('label[aria-label="Condition"]', 'div[role="option"]', product.condition);

        addPhotos(product.image_url);

        // Submit the form
        // tryPublish();

        alert("Product has been synced successfully!");
    } catch (error) {
        console.error("Error populating and submitting form:", error.message);
        alert("Failed to sync the product. Please try again.");
    }
}

function setInputField(qs, value){
    var productTitleElement = document.querySelector(qs);

    if (productTitleElement) {
        var nativeInputValueSetter = Object.getOwnPropertyDescriptor(
            window.HTMLInputElement.prototype,
            'value'
        ).set;

        nativeInputValueSetter.call(productTitleElement, value);

        var event = new Event('input', {bubbles: true});
        productTitleElement.dispatchEvent(event);
    }
}

function setSelectOption(qsSelect, qsOption, optionTitle) {
    var dropdownTrigger = document.querySelector(qsSelect);

    if (dropdownTrigger) {
        dropdownTrigger.click();

        // Wait for the dropdown options to render
        setTimeout(function () {
            // Locate all dropdown options
            var options = document.querySelectorAll(qsOption + ' span[dir="auto"]');
            var found = false;

            options.forEach(function (option) {
                if (option.textContent.trim() === optionTitle) {
                    // Navigate to the parent button to simulate a click
                    //var parentButton = option.closest('div[role="button"]');
                    var parentButton = option.closest(qsOption);
                    if (parentButton) {
                        parentButton.click();
                        console.log('Dropdown Option "' + optionTitle + '" selected successfully.');
                        found = true;
                    }
                }
            });

            if (!found) {
                console.error('Dropdown Option "' + optionTitle + '" not found.');
            }
        }, 500); // Adjust the delay if necessary
    } else {
        console.error('Dropdown trigger not found.');
    }
}

function addPhotos(image_url) {
    var fileInput = document.querySelector('input[type="file"][accept*="image/"]');
    if (fileInput) {
        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'heif', 'webp'];
        var dataTransfer = new DataTransfer();
        var fileExtension = image_url.split('.').pop().toLowerCase();
        var file = new File([image_url], image_url.split('/').pop(), { type: 'image/' + fileExtension });

        if (allowedExtensions.includes(fileExtension)) {
            dataTransfer.items.add(file);
        } else {
            console.warn('File skipped (unsupported format): ' + image_url);
        }

        fileInput.files = dataTransfer.files;
        var event = new Event('change', { bubbles: true });
        fileInput.dispatchEvent(event);

        console.log('Photos added successfully.');
    } else {
        console.error('File input not found. Please ensure the file input is visible.');
    }
}

// Need to work on this
function tryPublish() {
    var publishProduct = document.querySelector('div[aria-label="Publish"]');
    if (publishProduct) {
        publishProduct.click();
    } else {
        setTimeout(tryPublish, 1000); // Retry after 1 second if not found
    }
}