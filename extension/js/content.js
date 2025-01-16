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

const titleInputFieldSelectorOfFB = 'label[aria-label="Title"] input';
const priceInputFieldSelectorOfFB = 'label[aria-label="Price"] input';
const categoryFieldSelectorOfFB = 'label[aria-label="Category"]';
const categoryFieldOptionSelectorOfFB = 'div[role="button"]';
const conditionFieldSelectorOfFB = 'label[aria-label="Condition"]';
const conditionFieldOptionSelectorOfFB = 'div[role="option"]';
const phptoUploadFieldSelectorOfFB = 'input[type="file"][accept="image/*,image/heif,image/heic"]';
const publishButtonSelectorOfFB = 'div[aria-label="Publish"]:not([aria-disabled="true"])';
const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'heif', 'webp'];

/*
    Helper Function: uploadProductToMarketplace(product, callback)
    Description:
        Function to upload product to FB Marketplace
    Param:
        product: Product data
        callback: Callback function to follow
 */
function uploadProductToMarketplace(product, callback) {
    try {
        setInputField(titleInputFieldSelectorOfFB, product.name);
        setInputField(priceInputFieldSelectorOfFB, product.price);

        setSelectOption(categoryFieldSelectorOfFB, categoryFieldOptionSelectorOfFB, product.category);
        setSelectOption(conditionFieldSelectorOfFB, conditionFieldOptionSelectorOfFB, product.condition);

        addPhotos(phptoUploadFieldSelectorOfFB, product.image_file);

        productPublishToMarketplace(callback);
    } catch (error) {
        console.error("Error populating and submitting FB form:", error.message);
    }
}

/*
    Helper Function: productPublishToMarketplace(callback)
    Description:
        Function to click the FB Marketplace Create Listing form's Publish button and
        follow the callback
    Param:
        callback: callback function to follow
 */
function productPublishToMarketplace(callback) {
    const observer = new MutationObserver(function(mutationsList, observer) {
        const publishProduct = document.querySelector(publishButtonSelectorOfFB);

        if (publishProduct) {
            publishProduct.click();
            callback();
            observer.disconnect();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}

/*
    Helper Function: setInputField(qs, value)
    Description:
        Function to set an input field and trigger the form input event
    Param:
        qs: Query Selector
        value: Field Value
 */
function setInputField(qs, value){
    var productTitleElement = document.querySelector(qs);

    if (productTitleElement) {
        var nativeInputValueSetter = Object.getOwnPropertyDescriptor(
            window.HTMLInputElement.prototype,
            'value'
        ).set;

        nativeInputValueSetter.call(productTitleElement, value);

        // Call the input event
        var event = new Event('input', {bubbles: true});
        productTitleElement.dispatchEvent(event);
    } else {
        throw new Error("Input trigger not found!");
    }
}

/*
    Helper Function: setSelectOption(qsSelect, qsOption, optionTitle)
    Description:
        Function to set an dropdown field and trigger the form select change event
    Param:
        qsSelect: Select Button Selector
        qsOption: Option Button Selector
        optionTitle: Option Title
 */
function setSelectOption(qsSelect, qsOption, optionTitle) {
    var dropdownTrigger = document.querySelector(qsSelect);

    if (dropdownTrigger) {
        dropdownTrigger.click();

        // Find a stable parent container to observe
        var parentContainer = document.body;

        // Create a MutationObserver to watch for changes
        var observer = new MutationObserver(function (mutationsList, observer) {
            var options = document.querySelectorAll(qsOption + ' span[dir="auto"]');
            var found = false;

            options.forEach(function (option) {
                if (option.textContent.trim() === optionTitle) {
                    var parentButton = option.closest(qsOption);
                    if (parentButton) {
                        parentButton.click();
                        found = true;
                    }
                }
            });

            if (found) {
                observer.disconnect();
            }
        });

        observer.observe(parentContainer, { childList: true, subtree: true });
    } else {
        throw new Error("Dropdown trigger not found!");
    }
}

/*
    Helper Function: getFileExtensionAndMimeType(base64String)
    Description:
        Function to return the Mime Type and File Extension of base64 string based file
    Param:
        base64String: Base64 String of the image's blob data
 */
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

/*
    Helper Function: addPhotos(qs, base64String)
    Description:
        Function to upload the photo to FB Marketplace and trigger the form input event
    Param:
        qs: Query Selector
        base64String: Base64 String of the image's blob data
 */
function addPhotos(qs, base64String) {
    var fileInput = document.querySelector(qs);
    if (fileInput) {
        var fileInfo = getFileExtensionAndMimeType(base64String);
        var extension = fileInfo.extension;
        var mimeType = fileInfo.mimeType;

        if (allowedExtensions.includes(extension)) {
            // Decode Base64String of the image file
            var byteString = atob(base64String);
            var arrayBuffer = new Uint8Array(byteString.length);
            for (var i = 0; i < byteString.length; i++) {
                arrayBuffer[i] = byteString.charCodeAt(i);
            }

            var file = new File([arrayBuffer], 'image.' + extension, { type: mimeType });
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;

            // Trigger the change event of photo upload
            var event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        } else {
            throw new Error('File skipped (unsupported format): ' + extension);
        }
    } else {
        throw new Error('File input not found. Please ensure the file input is visible.');
    }
}