

function showPopUpMessage(type, title, message) {
    $("#" + type + '-popupTitle').html(title);
    $("#" + type + '-popupContent').html(message);
    $("#" + type).fadeIn(200);
}
function getAuthorizationTokenValue() {
    return Cookies.get('token');
}
$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) {
        return null;
    } else {
        return decodeURI(results[1]) || 0;
    }
}

/* function for sliding cards*/
function sideScrollCards(elementWrapper, cardCalss, direction, increment = 1, adjustMaxDistanceWidth = false) {
    var slideIndex = elementWrapper + 'Index';
    window[slideIndex] = (typeof window[slideIndex] != 'undefined') ? window[slideIndex] : 0;
    var cardCalssList = document.getElementsByClassName(cardCalss);
    var wrapperDiv = document.getElementById(elementWrapper);
    wrapperDiv.style.transition = 'transform 0.6s ease';
    var cardNos = cardCalssList.length;
    var cardWidth = cardCalssList[0].offsetWidth;
    var distanceToTransalte = 0;
    var wrapperWidth = wrapperDiv.offsetWidth;
    if (direction === 'prev') {
        window[slideIndex] = (window[slideIndex] > 0) ? window[slideIndex] - increment : 0;
    } else if (direction === 'next') {
        window[slideIndex] = (window[slideIndex] < cardNos) ? window[slideIndex] + increment : 0;
    }
    window[slideIndex] = (window[slideIndex] > (cardNos - 1)) ? 0 : window[slideIndex];
    distanceToTransalte = window[slideIndex] * cardWidth;
    var maxDistanceToTranslate = parseInt(wrapperWidth) + parseInt(cardWidth);
    if (adjustMaxDistanceWidth) {
        distanceToTransalte = (wrapperWidth < distanceToTransalte) ? maxDistanceToTranslate : distanceToTransalte;
        window[slideIndex] = (wrapperWidth < distanceToTransalte) ? 0 : window[slideIndex];
    }

    distanceToTransalte = (distanceToTransalte === 0) ? 0 : '-' + distanceToTransalte;
    wrapperDiv.style.transform = 'translateX(' + distanceToTransalte + 'px)';
}
function processAjaxReturnData(retrunDataJSON, func) {
    //{success :"", authorization : "", validation : "", error : ""}
    var returnData = JSON.parse(retrunDataJSON);
    var response = returnData.response;
    var ajaxReturnData = ('data' in returnData) ? returnData.data : '';
    var ajaxReturnMessage = ('message' in returnData) ? returnData.message : 'Some error occured';

    if (response == 200) {
        if (typeof func.success == "function") {
            func.success(ajaxReturnData);
        }
    } else if (response == 417) {
        if (typeof func.validation == "function") {
            func.validation();
        } else {
            showErrorMessage('Error!', 'Invalid Data');
        }
    } else if (response == 401) {
        if (typeof func.authorization == "function") {
            func.authorization();
        } else {
            $.post("/setBackURL", {
                url: window.location.href
            }).done(function (result) {
                $("#loginPopUp").fadeIn(500);
            });
        }
    } else {
        if (typeof func.error == "function") {
            func.error(returnData);
        } else {
            showErrorMessage('Error!', ajaxReturnMessage);
        }
    }

}
$(".navLink").on('click', function (e) {
    e.preventDefault();
    window.location.href = $(this).attr('href');
});
$(".popupCloseDiv").on('click', function (e) {
    e.preventDefault();
    $(this).closest(".popupContainer").fadeOut(400);
});
$(".autoHeightTextArea").on('input', function () {
    $(this).css('height', "");
    $(this).css('height', this.scrollHeight + 3 + "px");
});
$("[mobile-10]").on('blur', function (e) {
    e.preventDefault();
    var elem = $(this);
    elem.closest(".inputGroupDiv").find(".messageArea").text("");
    var value = $(this).val();
    if (value != "") {
        if (!value.match('[1-9]{1}[0-9]{9}')) {
            elem.closest(".inputGroupDiv").find(".messageArea").text("Please enter 10 digit mobile number");
            elem.val('');
            elem.focus();
            return false;
        }
    }

});
$("input[type='email']").on('blur', function (e) {
    e.preventDefault();
    var elem = $(this);
    elem.closest(".inputGroupDiv").find(".messageArea").text("");
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var value = elem.val();
    if (value != "") {
        if (reg.test(value) == false)
        {
            elem.closest(".inputGroupDiv").find(".messageArea").text("Invalid Email Address");
            elem.val('');
            elem.focus();
            return false;
        }
    }
});
function validate(formSelect = "") {
    $('.messageArea').html('');
    var bool = true;
    var sel = formSelect + " [required]";
    $(formSelect).find('[required]').each(function () {
        var elem = $(this);
        if (elem.val() == '') {
            var field = elem.attr("id");
            var txt = "Please enter " + field;
            elem.closest(".inputGroupDiv").find(".messageArea").text(txt);
            elem.focus();
            bool = false;
            return false;
        }
    });
    return bool;
}
// From https://developer.mozilla.org/en-US/docs/Web/API/HTMLCanvasElement/toBlob, needed for Safari:
if (!HTMLCanvasElement.prototype.toBlob) {
    Object.defineProperty(HTMLCanvasElement.prototype, 'toBlob', {
        value: function (callback, type, quality) {

            var binStr = atob(this.toDataURL(type, quality).split(',')[1]),
                    len = binStr.length,
                    arr = new Uint8Array(len);

            for (var i = 0; i < len; i++) {
                arr[i] = binStr.charCodeAt(i);
            }

            callback(new Blob([arr], {type: type || 'image/png'}));
        }
    });
}

window.URL = window.URL || window.webkitURL;

// Modified from https://stackoverflow.com/a/32490603, cc by-sa 3.0
// -2 = not jpeg, -1 = no data, 1..8 = orientations
function getExifOrientation(file, callback) {
    // Suggestion from http://code.flickr.net/2012/06/01/parsing-exif-client-side-using-javascript-2/:
    if (file.slice) {
        file = file.slice(0, 131072);
    } else if (file.webkitSlice) {
        file = file.webkitSlice(0, 131072);
    }

    var reader = new FileReader();
    reader.onload = function (e) {
        var view = new DataView(e.target.result);
        if (view.getUint16(0, false) != 0xFFD8) {
            callback(-2);
            return;
        }
        var length = view.byteLength, offset = 2;
        while (offset < length) {
            var marker = view.getUint16(offset, false);
            offset += 2;
            if (marker == 0xFFE1) {
                if (view.getUint32(offset += 2, false) != 0x45786966) {
                    callback(-1);
                    return;
                }
                var little = view.getUint16(offset += 6, false) == 0x4949;
                offset += view.getUint32(offset + 4, little);
                var tags = view.getUint16(offset, little);
                offset += 2;
                for (var i = 0; i < tags; i++)
                    if (view.getUint16(offset + (i * 12), little) == 0x0112) {
                        callback(view.getUint16(offset + (i * 12) + 8, little));
                        return;
                    }
            } else if ((marker & 0xFF00) != 0xFF00)
                break;
            else
                offset += view.getUint16(offset, false);
        }
        callback(-1);
    };
    reader.readAsArrayBuffer(file);
}

// Derived from https://stackoverflow.com/a/40867559, cc by-sa
function imgToCanvasWithOrientation(img, rawWidth, rawHeight, orientation) {
    var canvas = document.createElement('canvas');
    if (orientation > 4) {
        canvas.width = rawHeight;
        canvas.height = rawWidth;
    } else {
        canvas.width = rawWidth;
        canvas.height = rawHeight;
    }

    if (orientation > 1) {
        console.log("EXIF orientation = " + orientation + ", rotating picture");
    }

    var ctx = canvas.getContext('2d');
    switch (orientation) {
        case 2:
            ctx.transform(-1, 0, 0, 1, rawWidth, 0);
            break;
        case 3:
            ctx.transform(-1, 0, 0, -1, rawWidth, rawHeight);
            break;
        case 4:
            ctx.transform(1, 0, 0, -1, 0, rawHeight);
            break;
        case 5:
            ctx.transform(0, 1, 1, 0, 0, 0);
            break;
        case 6:
            ctx.transform(0, 1, -1, 0, rawHeight, 0);
            break;
        case 7:
            ctx.transform(0, -1, -1, 0, rawHeight, rawWidth);
            break;
        case 8:
            ctx.transform(0, -1, 1, 0, 0, rawWidth);
            break;
    }
    ctx.drawImage(img, 0, 0, rawWidth, rawHeight);
    return canvas;
}

function reduceFileSize(file, acceptFileSize, maxWidth, maxHeight, quality, callback) {
    if (file.size <= acceptFileSize) {
        callback(file);
        return;
    }
    var img = new Image();
    img.onerror = function () {
        URL.revokeObjectURL(this.src);
        callback(file);
    };
    img.onload = function () {
        URL.revokeObjectURL(this.src);
        getExifOrientation(file, function (orientation) {
            var w = img.width, h = img.height;
            var scale = (orientation > 4 ?
                    Math.min(maxHeight / w, maxWidth / h, 1) :
                    Math.min(maxWidth / w, maxHeight / h, 1));
            h = Math.round(h * scale);
            w = Math.round(w * scale);

            var canvas = imgToCanvasWithOrientation(img, w, h, orientation);
            canvas.toBlob(function (blob) {
                console.log("Resized image to " + w + "x" + h + ", " + (blob.size >> 10) + "kB");
                callback(blob);
            }, 'image/jpeg', quality);
        });
    };
    img.src = URL.createObjectURL(file);
}
