console.log("Content script loaded");

chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {
    if (request.action === "ping") {
        sendResponse({ status: "Content script is loaded" });
    }

    if (request.action === "uploadProductToMarketplace") {
        uploadProductToMarketplace(request.product, function() {
            sendResponse({ status: "Product upload triggered" });
        });
    }
    return true; // This ensures the message channel remains open for asynchronous response
});

function uploadProductToMarketplace(product, callback) {
    populateForm(product);
    productPublishToMarketplace(callback);
}

function productPublishToMarketplace(callback) {
    const observer = new MutationObserver(function(mutationsList, observer) {
        const publishProduct = document.querySelector('div[aria-label="Publish"]:not([aria-disabled="true"])');

        if (publishProduct) {
            console.log("Publish button found and enabled. Clicking...");
            publishProduct.click();
            callback();
            observer.disconnect();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });

    console.log("Waiting for the Publish button to become available...");
}

function populateForm(product) {
    try {
        setInputField('label[aria-label="Title"] input', product.name);
        setInputField('label[aria-label="Price"] input', product.price);

        setSelectOption('label[aria-label="Category"]', 'div[role="button"]', product.category);
        setSelectOption('label[aria-label="Condition"]', 'div[role="option"]', product.condition);

        addPhotos(product.image_file);

        console.log("Product has been synced successfully!");
    } catch (error) {
        console.error("Error populating and submitting form:", error.message);
        console.log("Failed to sync the product. Please try again.");
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

        setTimeout(function () {
            var options = document.querySelectorAll(qsOption + ' span[dir="auto"]');
            var found = false;

            options.forEach(function (option) {
                if (option.textContent.trim() === optionTitle) {
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
        }, 500);
    } else {
        console.error('Dropdown trigger not found.');
    }
}

function getFileExtensionAndMimeType(base64String) {
    const mimeTypes = {
        'jpg': 'image/jpeg',
        'jpeg': 'image/jpeg',
        'png': 'image/png',
        'gif': 'image/gif',
        'tiff': 'image/tiff',
        'heif': 'image/heif',
        'webp': 'image/webp'
    };

    const signatures = [
        { signature: 'iVBORw0KGgo', extension: 'png', mimeType: mimeTypes['png'] },  // PNG
        { signature: '/9j/', extension: 'jpeg', mimeType: mimeTypes['jpeg'] },       // JPEG
        { signature: 'R0lGODlh', extension: 'gif', mimeType: mimeTypes['gif'] },     // GIF
        { signature: 'II', extension: 'tiff', mimeType: mimeTypes['tiff'] },         // TIFF
        { signature: 'HEIF', extension: 'heif', mimeType: mimeTypes['heif'] },       // HEIF
        { signature: 'UklGR', extension: 'webp', mimeType: mimeTypes['webp'] }        // WebP
    ];

    for (var i = 0; i < signatures.length; i++) {
        if (base64String.startsWith(signatures[i].signature)) {
            return { extension: signatures[i].extension, mimeType: signatures[i].mimeType };
        }
    }

    // Default to JPG if no match is found
    return { extension: 'jpg', mimeType: mimeTypes['jpg'] };
}

function addPhotos(base64String) {
    var fileInput = document.querySelector('input[type="file"][accept="image/*,image/heif,image/heic"]');
    if (fileInput) {
        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'heif', 'webp'];

        var fileInfo = getFileExtensionAndMimeType(base64String);
        var extension = fileInfo.extension;
        var mimeType = fileInfo.mimeType;

        var byteString = atob(base64String);
        var arrayBuffer = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            arrayBuffer[i] = byteString.charCodeAt(i);
        }

        var file = new File([arrayBuffer], 'image.' + extension, { type: mimeType });

        if (allowedExtensions.includes(extension)) {
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            var event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);

            console.log('Photos added successfully.');
        } else {
            console.warn('File skipped (unsupported format): ' + extension);
        }
    } else {
        console.error('File input not found. Please ensure the file input is visible.');
    }
}