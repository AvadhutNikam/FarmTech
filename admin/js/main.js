$(document).ready(function(){

    // ================= Register ==================
    $(".register-btn").on("click", function(e){
        e.preventDefault();
        
        $.ajax({
            url : '../admin/classes/Credentials.php',
            method : "POST",
            data : $("#admin-register-form").serialize(),
            success : function(response){
                console.log("Register response:", response);
                try {
                    var resp = $.parseJSON(response);
                    if (resp.status == 202) {
                        $(".message").html('<span class="text-success">' + resp.message + '. Redirecting...</span>');
                        setTimeout(function(){
                            window.location.href = "login.php";
                        }, 1500);
                    } else if (resp.status == 303) {
                        $(".message").html('<span class="text-danger">' + resp.message + '</span>');
                    }
                } catch (e) {
                    console.warn("Non-JSON response for register:", response);
                }
            },
            error: function(xhr, status, error){
                console.log("AJAX Error (Register):", error);
            }
        });
    });

    // ================= Login ==================
    $(".login-btn").on("click", function(e){
        e.preventDefault();

        $.ajax({
            url : '../admin/classes/Credentials.php',
            method : "POST",
            data : $("#admin-login-form").serialize(),
            success : function(response){
                console.log("Login response:", response);
                try {
                    var resp = $.parseJSON(response);
                    if (resp.status == 202) {
                        // <<< THIS IS THE CORRECTED LINE
                        window.location.href = "index.php"; 
                    } else if (resp.status == 303) {
                        $(".message").html('<span class="text-danger">' + resp.message + '</span>');
                    }
                } catch (e) {
                    console.warn("Non-JSON response for login:", response);
                }
            },
            error: function(xhr, status, error){
                console.log("AJAX Error (Login):", error);
            }
        });
    });

});