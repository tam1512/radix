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
  ).innerHTML = `<a href="${rootUrlAdmin}${slug}" target="_blank">${rootUrlAdmin}${prefixLink}/${slug}</a>`;
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

function openCkfinder() {
  let ckfinderChooseImages = document.querySelectorAll(
    ".ckfinder-choose-image"
  );
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
}

openCkfinder();

//Xử lý thêm ảnh portfolio_images
let galleryImagesObject = document.querySelector(".gallery-images");
let btnAddImage = document.querySelector("#addImage");
let htmlGalleryItem = `
<div class="gallery-item">
  <div class="row ckfinder-group">
    <div class="col-9">
        <input type="text" id="gallery" name="gallery[]" class="form-control image-link"
          placeholder="Đường dẫn ảnh...">
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
          ảnh</button>
    </div>
    <div class="col-1">
        <button type="button" class="btn btn-danger btn-block btn-remove-image"><i
              class="fa fa-times"></i></button>
    </div>
  </div>
</div>`;

if (galleryImagesObject !== null && btnAddImage !== null) {
  btnAddImage.addEventListener("click", (e) => {
    e.preventDefault();
    let galleryItemHtmlNode = new DOMParser()
      .parseFromString(htmlGalleryItem, "text/html")
      .querySelector(".gallery-item");
    galleryImagesObject.appendChild(galleryItemHtmlNode);
    openCkfinder();
  });

  galleryImagesObject.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("btn-remove-image") ||
      e.target.parentElement.classList.contains("btn-remove-image")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let galleryItem = e.target;
        while (galleryItem) {
          galleryItem = galleryItem.parentElement;
          if (galleryItem.classList.contains("gallery-item")) {
            break;
          }
        }
        if (galleryItem !== null) {
          galleryItem.remove();
        }
      }
    }
  });
}

//Xử lý thêm slide của home_slider
let sliderObjects = document.querySelector(".slider");
let btnAddSlide = document.querySelector("#addSlide");
let htmlSlideItem = `
<div class="card border shadow-none mb-2 slider-item">
  <div class="card-body">
      <!-- content -->
      <div class="d-flex align-items-start border-bottom pb-3">
        <div class="flex-grow-1 align-self-center overflow-hidden">
            <div class="row">
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_title">Tiêu đề</label>
                    <input type="text" name="home_slide[slider_title][]" id="slider_title" class="form-control"
                        placeholder="Tiêu đề...">
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_btn">Nút xem thêm</label>
                    <input type="text" name="home_slide[slider_btn][]" id="slider_btn" class="form-control"
                        placeholder="Nút xem thêm...">
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_btn_link">Link nút xem thêm</label>
                    <input type="text" name="home_slide[slider_btn_link][]" id="slider_btn_link" class="form-control"
                        placeholder="Link nút xem thêm...">
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_youtube_link">Link Youtube</label>
                    <input type="text" name="home_slide[slider_youtube_link][]" id="slider_youtube_link" class="form-control"
                        placeholder="Link Youtube...">
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_image_1">Ảnh 1</label>
                    <div class="row ckfinder-group">
                        <div class="col-9">
                          <input type="text" name="home_slide[slider_image_1][]" id="slider_image_1"
                              class="form-control image-link" placeholder="Đường dẫn ảnh...">
                        </div>
                        <div class="col-3">
                          <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                              <i class="fa fa-upload" aria-hidden="true"></i>
                          </button>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_image_2">Ảnh 2</label>
                    <div class="row ckfinder-group">
                        <div class="col-9">
                          <input type="text" name="home_slide[slider_image_2][]" id="slider_image_2"
                              class="form-control image-link" placeholder="Đường dẫn ảnh...">
                        </div>
                        <div class="col-3">
                          <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                              <i class="fa fa-upload" aria-hidden="true"></i>
                          </button>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_bg">Ảnh nền</label>
                    <div class="row ckfinder-group">
                        <div class="col-9">
                          <input type="text" name="home_slide[slider_bg][]" id="slider_bg" class="form-control image-link"
                              placeholder="Đường dẫn ảnh...">
                        </div>
                        <div class="col-3">
                          <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
                              <i class="fa fa-upload" aria-hidden="true"></i>
                          </button>
                        </div>
                    </div>
                  </div>
              </div>
              <div class="col-6">
                  <div class="form-group">
                    <label for="slider_desc">Mô tả</label>
                    <textarea type="text" name="home_slide[slider_desc][]" id="slider_desc" class="form-control"
                        placeholder="Mô tả..."></textarea>
                  </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="slider_position">Vị trí</label>
                  <select name="home_slide[slider_position][]" id="slider_position" class="form-control">
                      <option value="0">Chọn vị trí</option>
                      <option value="left">Left</option>
                      <option value="right">Right</option>
                      <option value="center">Center</option>
                  </select>
                </div>
              </div>
            </div>
        </div>
        <div class="flex-shrink-0 ms-2">
            <ul class="list-inline mb-0">
              <li class="list-inline-item">
                  <button type="button" class="text-muted px-1 btn remove">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
              </li>
            </ul>
        </div>
      </div>
  </div>
</div>`;

if (sliderObjects !== null && btnAddSlide !== null) {
  btnAddSlide.addEventListener("click", (e) => {
    e.preventDefault();
    let sliderItemHtmlNode = new DOMParser()
      .parseFromString(htmlSlideItem, "text/html")
      .querySelector(".slider-item");
    sliderObjects.appendChild(sliderItemHtmlNode);
    openCkfinder();
  });

  sliderObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let sliderItem = e.target;
        while (sliderItem) {
          sliderItem = sliderItem.parentElement;
          if (sliderItem.classList.contains("slider-item")) {
            break;
          }
        }
        if (sliderItem !== null) {
          sliderItem.remove();
        }
      }
    }
  });
}

//Xử lý thêm slide của home_slider
let progressObjects = document.querySelector(".about_progress");
let btnAddProgress = document.querySelector("#addAboutProgress");
let htmlProgressItem = `
<div class="about_progress-item">
  <div class="row">
      <div class="col-5">
        <div class="form-group">
          <input type="text" name="home_about[about_progress_name][]"
            id="about_progress_name" class="form-control" placeholder="Tên công việc...">
        </div>
      </div>
      <div class="col-6">
        <input class="progress-range" type="text" name="home_about[progress-range][]"
            value="">
      </div>
      <div class="col-1">
        <button class="btn btn-danger btn-block remove">X</button>
      </div>
  </div>
</div>`;

if (progressObjects !== null && btnAddProgress !== null) {
  btnAddProgress.addEventListener("click", (e) => {
    e.preventDefault();
    let progressItemHtmlNode = new DOMParser()
      .parseFromString(htmlProgressItem, "text/html")
      .querySelector(".about_progress-item");
    progressObjects.appendChild(progressItemHtmlNode);
    $(".progress-range").each(function () {
      var item = $(this);
      item.ionRangeSlider({
        min: 0,
        max: 100,
        // from: progressValue,
        type: "single",
        step: 1,
        postfix: "%",
        prettify: false,
        hasGrid: true,
      });
    });
  });

  progressObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let progressItem = e.target;
        while (progressItem) {
          progressItem = progressItem.parentElement;
          if (progressItem.classList.contains("about_progress-item")) {
            break;
          }
        }
        if (progressItem !== null) {
          progressItem.remove();
        }
      }
    }
  });
}

console.log(Json.pare(oldAboutProgress));

$(".progress-range").each(function () {
  var item = $(this);
  item.ionRangeSlider({
    min: 0,
    max: 100,
    // from: progressValue,
    type: "single",
    step: 1,
    postfix: "%",
    prettify: false,
    hasGrid: true,
  });
});
