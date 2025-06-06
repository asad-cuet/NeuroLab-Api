(function () {

  /* ========= drag & drop ======== */
  const dropzoneSource = document.querySelector(".source");
  const dropzone = document.querySelector(".target");
  const dropzones = [...document.querySelectorAll(".dropzone")];
  const draggables = [...document.querySelectorAll(".draggable")];

  function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll(".draggable:not(.is-dragging)")];
    return draggableElements.reduce((closest, child) => {
      const box = child.getBoundingClientRect();
      const offset = y - box.top - box.height / 2;

      if (offset < 0 && offset > closest.offset) {
        return {
          offset,
          element: child
        };
      } else {
        return closest;
      }
    }, {
      offset: Number.NEGATIVE_INFINITY
    }).element;
  }
  draggables.forEach((draggable) => {
    draggable.addEventListener("dragstart", (e) => {
      draggable.classList.add("is-dragging");
    });
    draggable.addEventListener("dragend", (e) => {
      draggable.classList.remove("is-dragging");
    });
  });

  dropzones.forEach((zone) => {
    zone.addEventListener("dragover", (e) => {
      e.preventDefault();
      const afterElement = getDragAfterElement(zone, e.clientY);
      const draggable = document.querySelector(".is-dragging");
      if (afterElement === null) {
        zone.appendChild(draggable);
      } else {
        zone.insertBefore(draggable, afterElement);
      }
    });
  });


  /* ========= modal slider. ======== */


  /* ========= sidebar toggle ======== */
  const sidebarNavWrapper = document.querySelector(".sidebar");
  const mainWrapper = document.querySelector(".main-wrapper");
  const menuToggleButton = document.querySelector("#menu-toggle");
  const menuToggleButtonIcon = document.querySelector("#menu-toggle span");
  const overlay = document.querySelector(".overlay");

  menuToggleButton.addEventListener("click", () => {
    sidebarNavWrapper.classList.toggle("active");
    overlay.classList.add("active");
    mainWrapper.classList.toggle("active");

    if (document.body.clientWidth > 1200) {
      if (menuToggleButtonIcon.classList.contains("open-menu")) {
        menuToggleButtonIcon.classList.remove("open-menu");
        menuToggleButtonIcon.classList.add("close-menu");
      } else {
        menuToggleButtonIcon.classList.remove("close-menu");
        menuToggleButtonIcon.classList.add("open-menu");
      }
    } else {
      if (menuToggleButtonIcon.classList.contains("open-menu")) {
        menuToggleButtonIcon.classList.remove("open-menu");
        menuToggleButtonIcon.classList.add("close-menu");
      }
    }
  }

  );

  document.addEventListener("click", function (event) {
    if (event.target.matches(".overlay") || event.target.matches(".sidebar__close") || event.target.matches(".sidebar__close i")) {
      sidebarNavWrapper.classList.remove("active");
      overlay.classList.remove("active");
      mainWrapper.classList.remove("active");
    }
  }

  );

}

)();


//testimonial slider 

var swiper = new Swiper(".testimonial__slider-bottom", {
  loop: true,
  spaceBetween: 10,
  slidesPerView: 4,
  freeMode: true,
  watchSlidesProgress: true,
  direction: "vertical",

}

);

var swiper2 = new Swiper(".testimonial__slider-top", {

  loop: true,
  spaceBetween: 10,
  autoplay: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  }

  ,
  thumbs: {
    swiper: swiper,
  }

  ,
}

);






$("#menu-nav").metisMenu();

// Select all active menu items
const activeMenuItems = document.querySelectorAll(".sidebar__body .mm-active");

// Check if there are active menu items
if (activeMenuItems.length > 0) {
  // Get the first active menu item
  const firstActiveMenuItem = activeMenuItems[0];

  // Scroll the first active menu item into view with smooth scrolling
  firstActiveMenuItem.scrollIntoView({ behavior: "smooth", block: "start" });
}






// use an IIFE to avoid polluting the global scope
(function () {
  "use strict";

  /*---------------------------------------------------------------------
      Fieldset
  -----------------------------------------------------------------------*/

  let currentTab = 0;

  const setActiveTab = (n) => {
    if (n == 0) {
      document.getElementById("account").classList.add("active");
      document.getElementById("account").classList.remove("done");
      document.getElementById("personal").classList.remove("done");
      document.getElementById("personal").classList.remove("active");
    }
    if (n == 1) {
      document.getElementById("account").classList.add("done");
      document.getElementById("personal").classList.add("active");
      document.getElementById("personal").classList.remove("done");
      document.getElementById("payment").classList.remove("active");
      document.getElementById("payment").classList.remove("done");
      document.getElementById("confirm").classList.remove("done");
      document.getElementById("confirm").classList.remove("active");
    }
    if (n == 2) {
      document.getElementById("account").classList.add("done");
      document.getElementById("personal").classList.add("done");
      document.getElementById("payment").classList.add("active");
      document.getElementById("payment").classList.remove("done");
      document.getElementById("confirm").classList.remove("done");
      document.getElementById("confirm").classList.remove("active");
    }
    if (n == 3) {
      document.getElementById("account").classList.add("done");
      document.getElementById("personal").classList.add("done");
      document.getElementById("payment").classList.add("done");
      document.getElementById("confirm").classList.add("active");
      document.getElementById("confirm").classList.remove("done");
    }
  }

  const showTab = (n) => {
    const x = document.getElementsByTagName("fieldset");
    x[n].style.display = "block";
    setActiveTab(n);
  }

  const nextBtnFunction = (n) => {
    const x = document.getElementsByTagName("fieldset");
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    showTab(currentTab);
  }

  const nextbtn = document.querySelectorAll('.next');
  Array.from(nextbtn, (nbtn) => {
    nbtn.addEventListener('click', () => {
      nextBtnFunction(1);
    });
  });

  // previous button
  const prebtn = document.querySelectorAll('.previous');
  Array.from(prebtn, (pbtn) => {
    pbtn.addEventListener('click', () => {
      nextBtnFunction(-1);
    });
  });



  // Profile image 
  const imgInp = document.getElementById('imgInp');
  if (imgInp) {
    imgInp.onchange = evt => {
      const [file] = imgInp.files
      if (file) {
        document.getElementById('imagePreview').style.backgroundImage = 'url(' + URL.createObjectURL(file) + ')';
      }
    };
  }



})();


// Function to initialize Flatpickr if the element is found
const initFlatpickr = (selector, options = {}) => {
  const elements = document.querySelectorAll(selector);
  if (elements.length) {
    elements.forEach(element => flatpickr(element, options));
  }
};

// Initialize Flatpickr for each specific case only if elements are found
initFlatpickr('.flatpickr');
initFlatpickr('.flatpickr-datetime', {
  enableTime: true,
});
initFlatpickr('.flatpickr-range', {
  mode: 'range',
});
initFlatpickr('.flatpickr-multi', {
  mode: 'multiple',
});



const durationFilter = document.querySelector('.duration-filter');
if (durationFilter) {
  const datePicker = flatpickr("#datepicker", {
    mode: "range",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "F j, Y",
    onClose: function (selectedDates) {
      if (selectedDates.length === 2) {
        document.getElementById('predefined-ranges').value = "custom";
      }
    }
  });

  const predefinedRanges = document.getElementById('predefined-ranges');
  predefinedRanges.addEventListener('change', function (e) {
    const option = e.target.value;
    const today = new Date();
    let startDate, endDate;

    switch (option) {
      case "today":
        startDate = endDate = today;
        break;
      case "yesterday":
        startDate = endDate = new Date(today.setDate(today.getDate() - 1));
        break;
      case "last7days":
        startDate = new Date(today.setDate(today.getDate() - 7));
        endDate = today;
        break;
      case "last15days":
        startDate = new Date(today.setDate(today.getDate() - 15));
        endDate = today;
        break;
      case "last30days":
        startDate = new Date(today.setDate(today.getDate() - 30));
        endDate = today;
        break;
      case "thisMonth":
        startDate = new Date(today.getFullYear(), today.getMonth(), 1);
        endDate = today;
        break;
      case "thisYear":
        startDate = new Date(today.getFullYear(), 0, 1);
        endDate = today;
        break;
      default:
        datePicker.clear();  // Clear Flatpickr for "Custom" selection
        return;
    }

    // Set the selected date range in Flatpickr
    datePicker.setDate([startDate, endDate]);
  });
}



// const datePicker = flatpickr("#datepicker", {
//   mode: "range",
//   dateFormat: "Y-m-d",
//   altInput: true,
//   altFormat: "F j, Y",
//   onClose: function (selectedDates) {
//     if (selectedDates.length === 2) {
//       document.getElementById('predefined-ranges').value = "custom";
//     }
//   }
// });


// document.getElementById('predefined-ranges').addEventListener('change', function (e) {
//   const option = e.target.value;
//   const today = new Date();
//   let startDate, endDate;

//   switch (option) {
//     case "today":
//       startDate = endDate = today;
//       break;
//     case "yesterday":
//       startDate = endDate = new Date(today.setDate(today.getDate() - 1));
//       break;
//     case "last7days":
//       startDate = new Date().setDate(today.getDate() - 7);
//       endDate = today;
//       break;
//     case "last15days":
//       startDate = new Date().setDate(today.getDate() - 15);
//       endDate = today;
//       break;
//     case "last30days":
//       startDate = new Date().setDate(today.getDate() - 30);
//       endDate = today;
//       break;
//     case "thisMonth":
//       startDate = new Date(today.getFullYear(), today.getMonth(), 1);
//       endDate = today;
//       break;
//     case "thisYear":
//       startDate = new Date(today.getFullYear(), 0, 1);
//       endDate = today;
//       break;
//     default:
//       datePicker.clear();  // Clear Flatpickr for "Custom" selection
//       return;
//   }

//   // Set the selected date range in Flatpickr
//   datePicker.setDate([startDate, endDate]);
// });







document.addEventListener("DOMContentLoaded", function () {
  const tagInputs = document.querySelectorAll('input[name="tags"]');

  tagInputs.forEach(function (input) {
    const tagify = new Tagify(input);
  });
});

window.addEventListener('scroll', function () {
  var mainWrapper = document.querySelector('.main-wrapper');
  var scrollPosition = window.scrollY;

  if (scrollPosition > 30) {
    mainWrapper.classList.add('overlay-shade');
  } else {
    mainWrapper.classList.remove('overlay-shade');
  }
});

//CK Editor
if (document.querySelector('#ck-editor')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor 1
if (document.querySelector('#ck-editor-1')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-1'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor
if (document.querySelector('#ck-editor-2')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-2'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor
if (document.querySelector('#ck-editor-3')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-3'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor
if (document.querySelector('#ck-editor-4')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-4'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor
if (document.querySelector('#ck-editor-5')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-5'))
    .catch(error => {
      console.error(error);
    });
}
//CK Editor
if (document.querySelector('#ck-editor-6')) {
  ClassicEditor
    .create(document.querySelector('#ck-editor-6'))
    .catch(error => {
      console.error(error);
    });
}

// const ckEditorElements = document.querySelectorAll('.ck-editor');
// ckEditorElements.forEach((element) => {
//   ClassicEditor
//     .create(element)
//     .catch(error => {
//       console.error(error);
//     });
// });



if (document.querySelector('#myTable')) {
  const dataTable = new simpleDatatables.DataTable("#myTable", {
    searchable: true,
    fixedHeight: true,
    perPage: 5,
    fixedHeader: true,
  })

  let currentPage = 1;
  dataTable.on('datatable.page', function (page) {
    currentPage = page;
  });


  function deleteRow(rowIndex) {
    dataTable.rows().remove(rowIndex);

    dataTable.update();

    dataTable.page(currentPage);
  }
}


if (document.querySelector('#myTable1')) {
  const dataTable = new simpleDatatables.DataTable("#myTable1", {
    searchable: false,
    fixedHeight: true,
    paging: false,     // Disable pagination
    perPageSelect: false, // Disable page size select
    fixedHeader: true
  })
}
if (document.querySelector('#myTable2')) {
  const dataTable = new simpleDatatables.DataTable("#myTable2", {
    searchable: false,
    fixedHeight: true,
    paging: false,     // Disable pagination
    perPageSelect: false, // Disable page size select
    fixedHeader: true
  })
}

const datatableTop = document.querySelector('.datatable-top');

if (datatableTop) {
  // Check if there are no child elements and no text content
  if (datatableTop.children.length === 0 && !datatableTop.textContent.trim()) {
    datatableTop.style.display = 'none';
  }
}




// multi select 
document.querySelectorAll('.multi-select').forEach((el) => {
  let settings = {
    plugins: ['remove_button'],  // Add the remove button plugin
    create: false,               // Allow creating new items
    persist: false,             // Don't persist new items in the dropdown
    maxItems: null,             // Allow multiple selections
    delimiter: ','
  };
  new TomSelect(el, settings);
});

// multi select 
document.querySelectorAll('.multi-select-create').forEach((el) => {
  let settings = {
    plugins: ['remove_button'],  // Add the remove button plugin
    create: true,               // Allow creating new items
    persist: false,             // Don't persist new items in the dropdown
    maxItems: null,             // Allow multiple selections
    delimiter: ','
  };
  new TomSelect(el, settings);
});




// Initialize TomSelect if any .search-select elements exist
document.querySelectorAll('.search-select').forEach(element =>
  new TomSelect(element, {
    create: false,
    sortField: 'text'
  })
);





// ================================= Others js ============================ //

function SwalNotification(title, text, icon) {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,  // 'warning', 'error', 'success', 'info', 'question'
    confirmButtonText: 'OK'
  });
}


function SwalFlash(result, title, text, icon = 'success') {
  Swal.fire({
    toast: result,
    position: 'bottom-left',
    icon: icon, /// 'warning', 'error', 'success', 'info', 'question'
    title: title,
    text: text,
    showConfirmButton: false, // Hide the confirmation button
    timer: 3000 // Auto-close after 3 seconds
  });
}



function imagePreview(element, preview_id) {
  const [file] = element.files
  if (file) {
    document.getElementById(preview_id).style.backgroundImage = 'url(' + URL.createObjectURL(file) + ')';
  }
}

function filterPerPage(selectElement) {
  var perPage = selectElement.value;
  var url = new URL(window.location.href);
  url.searchParams.set('per_page', perPage);
  window.location.href = url.href;
}

function searchOnEnter(event, inputElement) {
  if (event.key === 'Enter') {
    event.preventDefault();
    var search = inputElement.value;
    var url = new URL(window.location.href);
    url.searchParams.set('search', search);
    window.location.href = url.href;
  }
}

function toggleSwitchStatus(el, table) {
  var column_id = el.value;
  var column_name = el.name;
  var column_val = 0;
  if (el.checked) {
    var column_val = 1;
  }

  var full_url = getBaseUrl() + '/admin/toggle/switch/status'

  $.post(full_url, {
    _token: getCsrfToken(),
    table: table,
    column: column_name,
    id: column_id,
    value: column_val
  }, function (data) {
    if (data == 1) {
      SwalFlash(true, "Success", "Updated!!", "success");
    } else {
      SwalFlash(false, "Erorr", "Failed!!", "error");
    }
  });
}

function getBaseUrl() {
  var protocol = window.location.protocol; // "http:" or "https:"
  var host = window.location.host; // "example.com" or "localhost:8000"
  return protocol + "//" + host;
}

function getCsrfToken() {
  return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}

document.addEventListener("DOMContentLoaded", function () {

});


//============================
//--- multistep form
//=============================

const formElement = document.getElementById("multistepForm");

if (formElement) {

  var currentTab = 0;
  showTab(currentTab);

  function showTab(n) {
    var x = document.getElementsByClassName("step");
    x[n].style.display = "block";
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next";
    }

    fixStepIndicator(n)
  }

  function nextPrev(n) {

    var x = document.getElementsByClassName("step");

    if (n == 1 && !validateForm()) return false;
    x[currentTab].style.display = "none";
    currentTab = currentTab + n
    if (currentTab >= x.length) {
      document.getElementById("multistepForm").submit();
      return false;
    }
    showTab(currentTab);
  }

  function validateForm() {

    var x, y, i, valid = true;
    x = document.getElementsByClassName("step");
    y = x[currentTab].getElementsByTagName("input");
    for (i = 0; i < y.length; i++) {
      if (y[i].value == "") {
        y[i].className += " invalid";
        valid = true;
      }
    }
    if (valid) {
      document.getElementsByClassName("step-progress__item")[currentTab].className += " finish";
    }
    return valid;
  }



  var stepIndicators = document.getElementsByClassName("step-progress__item");
  for (var i = 0; i < stepIndicators.length; i++) {
    stepIndicators[i].addEventListener("click", function () {
      var stepNumber = parseInt(this.getAttribute("data-step")) - 1;
      showTab(stepNumber);
    });
  }



  function fixStepIndicator(n) {
    var i, x = document.getElementsByClassName("step-progress__item");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }

    x[n].className += " active";
  }



  function nextPrev(n) {
    var x = document.getElementsByClassName("step");
    if (n == 1 && !validateForm()) return false;
    document.getElementById("multistepForm").scrollIntoView({
      behavior: "smooth"
    });
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
      document.getElementById("multistepForm").submit();
      return false;
    }
    showTab(currentTab);
  }

}


// =========================== upload image, video

// const dragDropUpload = document.querySelector(".upload-file");

// if (dragDropUpload) {
//   function triggerFileInput(inputId) {
//     document.getElementById(inputId).click();
//   }


//   function handleFileSelect(event, fileType, boxType) {
//     const file = event.target.files[0];
//     if (file && file.type.match(fileType)) {
//       updateUploadText(file.name, boxType);
//     }
//   }


//   function handleDragOver(event) {
//     event.preventDefault();
//   }

//   function handleFileDrop(event, fileType, boxType) {
//     event.preventDefault();
//     const file = event.dataTransfer.files[0];
//     if (file && file.type.match(fileType)) {
//       updateUploadText(file.name, boxType);
//     }
//   }


//   function updateUploadText(fileName, boxType) {
//     const textElement = boxType === 'banner' ? document.getElementById('banner-text') : document.getElementById('video-text');
//     textElement.innerHTML = `<strong>${fileName}</strong>`;
//   }

// }



// =================== file upload with close

const fileUploadInput = document.querySelectorAll('.file-upload__input');

if (fileUploadInput) {
  fileUploadInput.forEach(inputElement => {
    const inputWrapper = inputElement.closest('.file-upload__input-wrapper');
    const fileNameDisplay = inputWrapper.querySelector('.file-upload__text');

    inputElement.addEventListener('change', function () {
      if (inputElement.files && inputElement.files.length > 0) {
        fileNameDisplay.textContent = inputElement.files[0].name;
      } else {
        fileNameDisplay.textContent = 'Choose a file';
      }
    });
  });

}


// sidebar theme color change
// Get radio buttons and sidebar element
const sidebarLight = document.querySelector('#sidebar-light');

if (sidebarLight) {
  const sidebarDark = document.querySelector('#sidebar-dark');
  const sidebar = document.querySelector('.sidebar');

  // Function to update the sidebar theme
  function updateSidebarTheme() {
    if (sidebarLight.checked) {
      sidebar.classList.add('sidebar--style2'); // Apply light theme
    } else if (sidebarDark.checked) {
      sidebar.classList.remove('sidebar--style2'); // Remove light theme, default to dark
    }
  }

  // Add event listeners for both radio buttons
  sidebarLight.addEventListener('change', updateSidebarTheme);
  sidebarDark.addEventListener('change', updateSidebarTheme);

  // Trigger the function once to set the correct initial state
  updateSidebarTheme();

}






