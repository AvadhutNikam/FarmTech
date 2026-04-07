$(document).ready(() => {
    getCustomers();

    function getCustomers() {
      $.ajax({
        url: "classes/Customers.php", 
        method: "POST",
        data: { GET_CUSTOMERS: 1 },
        success: (response) => {
          try {
            var resp = $.parseJSON(response);
            if (resp.status == 202) {
              var customerHTML = "";
              if (resp.message.length === 0) {
                $("#customer_list").html("<tr><td colspan='5' class='text-center'>No customers found.</td></tr>");
                return;
              }
              $.each(resp.message, (index, value) => {
                customerHTML +=
                  "<tr>" +
                  "<td>" + (index + 1) + "</td>" +
                  "<td>" + value.first_name + " " + value.last_name + "</td>" +
                  "<td>" + value.email + "</td>" +
                  "<td>" + value.mobile + "</td>" +
                  "<td>" + value.address1 + "</td>" +
                  "</tr>";
              });
              $("#customer_list").html(customerHTML);
            } else {
              $("#customer_list").html("<tr><td colspan='5'>" + resp.message + "</td></tr>");
            }
          } catch (e) {
            console.error("Parsing Error:", e, response);
            $("#customer_list").html("<tr><td colspan='5'>Error processing server response.</td></tr>");
          }
        },
        error: (xhr, status, error) => {
            console.error("AJAX Error:", status, error);
            console.error("Response:", xhr.responseText);
            $("#customer_list").html("<tr><td colspan='5'>Could not reach the server.</td></tr>");
        }
      });
    }
});