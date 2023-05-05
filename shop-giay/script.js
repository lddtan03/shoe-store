
  //// sự kiện left menu +   -
  var toggleButtons = document.querySelectorAll(".toggle");
  toggleButtons.forEach(function(button) {
    button.addEventListener("click", function() {
      
      var filterOptions = button.parentElement.nextElementSibling;
   
      if (filterOptions.style.display === "none") {
        filterOptions.style.display = "block";
        button.textContent = "-";
      } else {
        filterOptions.style.display = "none";
        button.textContent = "+";
      }
    });
  });


   
   // Thêm sự kiện "click" cho toàn bộ trang web để đóng cửa sổ khi người dùng bấm ra ngoài

   function showPopup() {
    document.getElementById("myPopup").style.display = "block";
    document.querySelector('.popup-overlay').style.display = "block";
  }

  function hidePopup() {
    document.getElementById("myPopup").style.display = "none";
    document.querySelector('.popup-overlay').style.display = "none";
  }

    