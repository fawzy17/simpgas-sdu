function confirmSwalHandler({
  title,
  text,
  buttonText,
  url,
  redirectTo,
  method = "GET",
  data = {}
}) {
  Swal.fire({
    icon: "warning",
    title,
    text,
    showCancelButton: true,
    confirmButtonText: buttonText,
    confirmButtonColor: "#ca2b43",
  }).then((result) => {
    if (result.isConfirmed) {
      performAjaxRequest({ url, redirectTo, method, data });
    }
  });
}

function performAjaxRequest({ url, redirectTo, method, data = {} }) {
  $.ajax({
    url,
    method,
    data: data,
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        Swal.fire({
          text: response.message,
          icon: "success",
          showConfirmButton: false,
          timer: 1000,
        }).then(() => {
          window.location.href = redirectTo;
        });
      } else {
        Swal.fire("Error!", response.message, "error");
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
      Swal.fire("Error!", "An error occurred. Please try again.", "error");
    },
  });
}

const updateURLParameter = (url, param, paramVal) => {
  let newAdditionalURL = "";
  let tempArray = url.split("?");
  const baseURL = tempArray[0];
  const additionalURL = tempArray[1];
  let temp = "";
  if (additionalURL) {
    tempArray = additionalURL.split("&");
    for (let i = 0; i < tempArray.length; i++) {
      if (tempArray[i].split("=")[0] != param) {
        newAdditionalURL += temp + tempArray[i];
        temp = "&";
      }
    }
  }

  let rows_txt = temp + "" + param + "=" + paramVal;
  return baseURL + "?" + newAdditionalURL + rows_txt;
};
