function showAlert(type, message) {
    var alertDiv = $("#" + type);
    alertDiv.find(".message").html(message);
    alertDiv.addClass('show');
    alertDiv.show();
    if (alertDiv.length) {
        setTimeout(function () {
            alertDiv.removeClass("show");
            alertDiv.addClass("hidden");
        }, 5000);
    }
}

function hideAlert(type) {
    var alertElement = $("#" + type);
    if (alertElement.length) {
        setTimeout(function () {
            alertElement.addClass("hidden");
        }, 5000);
    }
}

function closeAlert(type) {
    var alertElement = $("#" + type);
    if (alertElement.length) {
        alertElement.hide();
    }
}