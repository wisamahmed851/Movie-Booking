function submitAjaxForm(formSelector, url, redirectUrl = null) {
    $(document).ready(function () {
        $(formSelector).on("submit", function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                success: function (response) {
                    if (response.status === "success") {
                        Toastify({
                            text: response.message,
                            backgroundColor: "green",
                            duration: 3000,
                        }).showToast();

                        if (redirectUrl) {
                            window.location.href = redirectUrl;
                        }
                    } else {
                        Toastify({
                            text: response.message,
                            backgroundColor: "red",
                            duration: 3000,
                        }).showToast();
                    }
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON?.errors;
                    var errorMessages = "";

                    if (errors) {
                        for (var field in errors) {
                            errorMessages += errors[field][0] + "\n";
                        }
                    } else if (xhr.responseJSON?.message) {
                        errorMessages = xhr.responseJSON.message;
                    } else {
                        errorMessages = "An unexpected error occurred.";
                    }

                    console.log(errorMessages);
                    Toastify({
                        text: errorMessages,
                        duration: 5000,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#ff5f6d",
                    }).showToast();
                },
            });
        });
    });
}
