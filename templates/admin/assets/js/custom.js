//chuyển chuỗi thành slug
function toSlug(str) {
  //Chuyển tất cả sang chữ thường
  str = str.toLowerCase().trim();

  //Xóa dấu
  //sử dụng normalize để chuyển sang unicode tổ hợp
  str = str.normalize("NFD");

  //Xóa các ký tự dấu sau khi tách tổ hợp (đây là khoảng các ký tự dấu trong unicode tổ hợp)
  str = str.replace(/[\u00300-\u0036F]/g, "");

  //Thay ký tự đ Đ (trường hợp này đặc biệt nên phải tách riêng)
  str = str.replace(/[đĐ]/g, "d");

  //Xóa các ký tự đặc biệt
  str = str.replace(/[^0-9a-z-\s]/g, "");

  //Thay khoảng trắng bằng ký tự -
  str = str.replace(/(\s+)/g, "-");

  //Xóa ký tự - liên tiếp
  str = str.replace(/-+/g, "-");

  //Xóa phần dư - ở đầu và cuối
  str = str.replace(/^-+|-+$/g, "");

  return str;
}

//Xử lý hiển thị đường dẫn đúng sau khi tạo thành công
let renderLink = document.querySelector(".render-link");
if (renderLink != null) {
  renderLink.querySelector(
    "span"
  ).innerHTML = `<a href="${rootUrlAdmin}" target="_blank">${rootUrlAdmin}</a>`;
}

function getLinkSlug(renderLink, slug) {
  renderLink.querySelector(
    "span"
  ).innerHTML = `<a href="${rootUrlAdmin}${slug}" target="_blank">${rootUrlAdmin}${slug}</a>`;
}

let serviceNameElement = document.querySelector("#name");
let serviceSlugElement = document.querySelector("#slug");
if (serviceNameElement != null && serviceSlugElement != null) {
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
