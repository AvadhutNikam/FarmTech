$(document).ready(function () {

    // ========================
    // Admin Login Handler
    // ========================
    $(".login-btn").on("click", function (e) {
        e.preventDefault(); // stop form reload

        console.log("✅ Login button clicked"); // DEBUG

        var formData = $("#admin-login-form").serialize() + "&action=login"; // add action
        console.log("Form Data:", formData); // DEBUG

        $.ajax({
            url: "classes/Admin.php",   // relative path to backend
            method: "POST",
            data: formData,
            success: function (response) {
                console.log("Login response (raw):", response); // DEBUG

                try {
                    var resp = JSON.parse(response.trim());

                    if (resp.status == 202) {
                        console.log("✅ Login successful, redirecting...");
                        window.location.href = "dashboard.php";
                    } else {
                        console.warn("❌ Login failed:", resp.message);
                        $(".message").html("<div class='alert alert-danger'>" + resp.message + "</div>");
                    }
                } catch (err) {
                    console.error("⚠️ JSON parse error:", err, response);
                    $(".message").html("<div class='alert alert-danger'>Unexpected response: " + response + "</div>");
                }
            },
            error: function (xhr, status, err) {
                console.error("🚨 AJAX Error:", status, err);
                $(".message").html("<div class='alert alert-danger'>Request failed. Check console.</div>");
            }
        });
    });


    // ========================
    // Fetch Admins
    // ========================
    function getAdmins() {
        $.ajax({
            url: "classes/Admin.php",
            method: "POST",
            data: { GET_ADMIN: 1 },
            success: function (response) {
                console.log("Admin list response:", response);

                var resp;
                try {
                    resp = JSON.parse(response);
                } catch (e) {
                    $("#admin_list").html("<tr><td colspan='5'>Invalid response</td></tr>");
                    return;
                }

                if (resp.status == 202) {
                    var adminHTML = "";

                    $.each(resp.message, function (index, value) {
                        adminHTML += "<tr>" +
                            "<td>#</td>" +
                            "<td>" + value.name + "</td>" +
                            "<td>" + value.email + "</td>" +
                            "<td>" + value.is_active + "</td>" +
                           "<td><a href='#' class='btn btn-sm btn-danger delete-admin-btn' data-id='" + value.id + "'><i class='fas fa-trash-alt'></i></a></td>" +
                            "</tr>";
                    });

                    $("#admin_list").html(adminHTML);
                } else {
                    $("#admin_list").html("<tr><td colspan='5'>" + resp.message + "</td></tr>");
                }
            }
        });
    }
    // ========================
// Handle Admin Delete
// ========================
$(document).on("click", ".delete-admin-btn", function(e) {
    e.preventDefault(); // Stop the link from acting like a normal link

    const adminId = $(this).data("id"); // Get the admin ID from the button
    const tableRow = $(this).closest("tr"); // Find the table row to remove it later

    // Ask for confirmation before deleting
    if (confirm("Are you sure you want to delete this admin?")) {
        $.ajax({
            url: "classes/Admin.php",
            method: "POST",
            data: {
                action: "delete_admin",
                id: adminId
            },
            success: function(response) {
                try {
                    var resp = JSON.parse(response);
                    if (resp.status == 202) {
                        // If successful, make the table row fade out and disappear
                        tableRow.fadeOut(500, function() {
                            $(this).remove();
                        });
                        alert("Admin deleted successfully.");
                    } else {
                        // Show an error message if it failed
                        alert("Error: " + resp.message);
                    }
                } catch (err) {
                    console.error("Delete error:", response);
                    alert("An unexpected error occurred during deletion.");
                }
            }
        });
    }
});

    // call initially
    getAdmins();

});
