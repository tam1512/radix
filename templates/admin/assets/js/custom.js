//chuyển chuỗi thành slug
function toSlug(str) {
  //Chuyển tất cả sang chữ thường
  str = str.toLowerCase().trim();

  //Xóa dấu
  //sử dụng normalize để chuyển sang unicode tổ hợp
  str = str.normalize("NFD");

  //Xóa các ký tự dấu sau khi tách tổ hợp (đây là khoảng các ký tự dấu trong unicode tổ hợp)
  str = str.replace(/[\u0300-\u036F]/g, "");

  //Thay ký tự đ Đ (trường hợp này đặc biệt nên phải tách riêng)
  str = str.replace(/[đĐ]/g, "d");

  //Xóa các ký tự đặc biệt
  str = str.replace(/([^0-9a-z-\s])/g, "");

  //Thay khoảng trắng bằng ký tự -
  str = str.replace(/(\s+)/g, "-");

  //Xóa ký tự - liên tiếp
  str = str.replace(/-+/g, "-");

  //Xóa phần dư - ở đầu và cuối
  str = str.replace(/^-+|-+$/g, "");

  return str;
}

function getLinkSlug(renderLink, slug) {
  renderLink.querySelector(
    "span"
  ).innerHTML = `<a href="${rootUrlAdmin}${slug}" target="_blank">${rootUrlAdmin}${slug}</a>`;
}

//Xử lý hiển thị đường dẫn đúng sau khi tạo thành công
let renderLink = document.querySelector(".render-link");
let serviceNameElement = document.querySelector("#name");
let serviceSlugElement = document.querySelector("#slug");

if (renderLink != null) {
  let slug = "";
  if (serviceSlugElement.value.trim() != null) {
    slug = serviceSlugElement.value.trim();
  }
  getLinkSlug(renderLink, slug);
}

if (serviceNameElement !== null && serviceSlugElement !== null) {
  //Xử lý khi keyup name => tự sinh ra slug
  serviceNameElement.addEventListener("keyup", (e) => {
    if (!sessionStorage.getItem("save_slug")) {
      var slug = toSlug(e.target.value);
      serviceSlugElement.value = slug;
      getLinkSlug(renderLink, slug);
    }
  });

  //Xử lý tự động sinh link khi keyup slug
  serviceSlugElement.addEventListener("keyup", (e) => {
    var slug = e.target.value;
    getLinkSlug(renderLink, slug);
  });

  //Khi onchang (click ra ngoài) name thì sẽ k tự động sinh slug theo name nữa
  serviceNameElement.addEventListener("change", (e) => {
    if (e.target.value != "") {
      sessionStorage.setItem("save_slug", 1);
    }
  });

  //Khi onchange slug mà value = rỗng thì sẽ tự động sinh slug theo name
  serviceSlugElement.addEventListener("change", (e) => {
    if (e.target.value.trim() == "") {
      sessionStorage.removeItem("save_slug");
      let slug = toSlug(serviceNameElement.value);
      e.target.value = slug;
      getLinkSlug(renderLink, slug);
    }
  });

  //Khi load lại trang nếu name không có thì xóa session để có thể tự động sinh slug theo name
  if (serviceNameElement.value.trim() == "") {
    sessionStorage.removeItem("save_slug");
  }
}

//Tích hợp ckeditor
let listEditor = document.querySelectorAll(".editor");
if (listEditor != null) {
  listEditor.forEach((item, index) => {
    item.id = "editor_" + index;
    CKEDITOR.replace(item.id);

    //Lấy ra label tương ứng
    let label = item.parentNode.querySelector("label");

    if (label != null) {
      label.setAttribute("for", item.id);
    }
  });
}

//tích hợp ckfinder
let ckfinderChooseImages = document.querySelectorAll(".ckfinder-choose-image");
if (ckfinderChooseImages !== null) {
  ckfinderChooseImages.forEach((item) => {
    item.addEventListener("click", () => {
      let parentElementObject = item.parentElement;
      let parent = "ckfinder-group";
      while (parentElementObject) {
        if (parentElementObject.classList.contains(parent)) {
          break;
        } else {
          parentElementObject = parentElementObject.parentElement;
        }
      }

      let imageLink = parentElementObject.querySelector(".image-link");

      CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        onInit: function (finder) {
          finder.on("files:choose", function (evt) {
            let fileUrl = evt.data.files.first().getUrl();
            //Xử lý chèn link ảnh vào input
            imageLink.value = fileUrl;
          });
          finder.on("file:choose:resizedImage", function (evt) {
            let fileUrl = evt.data.resizedUrl;
            //Xử lý chèn link ảnh vào input
            imageLink.value = fileUrl;
          });
        },
      });
    });
  });
}
