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

function getLinkSlug(renderLink, slug, id) {
  let currentLink = null;
  if (id != null) {
    currentLink = `<a href="${rootUrl}/${prefixLink}/${slug}-${id}.html" target="_blank">${rootUrl}/${prefixLink}/${slug}-${id}.html</a>`;
  } else {
    currentLink = `<a href="${rootUrl}/${prefixLink}/${slug}.html" target="_blank">${rootUrl}/${prefixLink}/${slug}.html</a>`;
  }
  renderLink.querySelector("span").innerHTML = currentLink;
}

//Lất id từ url
let fullUrl = window.location.href;
let searchParams = new URLSearchParams(fullUrl);
let id = searchParams.get("id");

//Xử lý hiển thị đường dẫn đúng sau khi tạo thành công
let renderLink = document.querySelector(".render-link");
let serviceNameElement = document.querySelector("#name");
let serviceSlugElement = document.querySelector("#slug");

if (renderLink != null) {
  let slug = "";
  if (serviceSlugElement.value.trim() != null) {
    slug = serviceSlugElement.value.trim();
  }
  getLinkSlug(renderLink, slug, id);
}

if (serviceNameElement !== null && serviceSlugElement !== null) {
  //Xử lý khi keyup name => tự sinh ra slug
  serviceNameElement.addEventListener("keyup", (e) => {
    if (!sessionStorage.getItem("save_slug")) {
      var slug = toSlug(e.target.value);
      serviceSlugElement.value = slug;
      getLinkSlug(renderLink, slug, id);
    }
  });

  //Xử lý tự động sinh link khi keyup slug
  serviceSlugElement.addEventListener("keyup", (e) => {
    var slug = e.target.value;
    getLinkSlug(renderLink, slug, id);
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
      getLinkSlug(renderLink, slug, id);
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

function openCkfinderMulti() {
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
              let fileUrls = evt.data.files.map((file) => file.getUrl());
              // Xử lý chèn các đường dẫn ảnh vào input hoặc làm gì đó với mảng fileUrls
              imageLink.value = fileUrls.join(", "); // Ví dụ: ghép các đường dẫn bằng dấu phẩy và khoảng trắng
            });
            finder.on("file:choose:resizedImage", function (evt) {
              let fileUrls = evt.data.resizedUrl;
              // Xử lý chèn các đường dẫn ảnh vào input hoặc làm gì đó với mảng fileUrls
              imageLink.value = fileUrls.join(", "); // Ví dụ: ghép các đường dẫn bằng dấu phẩy và khoảng trắng
            });
          },
        });
      });
    });
  }
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
              let fileUrl = rootUrl + evt.data.files.first().getUrl();
              //Xử lý chèn link ảnh vào input
              imageLink.value = fileUrl;
            });
            finder.on("file:choose:resizedImage", function (evt) {
              let fileUrl = rootUrl + evt.data.resizedUrl;
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

//Xử lý thêm progress ở home_about
let progressObjects = document.querySelector(".about_progress");
let btnAddProgress = document.querySelector("#addAboutProgress");
let htmlProgressItem = `
<div class="about_progress-item">
  <div class="row">
      <div class="col-11 row">
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
          <label for="about_progress_name">Tên công việc</label>
            <input type="text" name="home_about[about_progress_name][]"
              id="about_progress_name" class="form-control" placeholder="Tên công việc...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
        <label>Tiến độ</label>
          <input class="progress-range" type="text" name="home_about[progress-range][]"
              value="">
        </div>
      </div>
      <div class="col-1 pt-30">
        <button class="btn btn-danger btn-block remove">X</button>
      </div>
  </div>
  <hr>
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

// console.log(Json.pare(oldAboutProgress));

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

//Xử lý thêm progress ở home_facts
let factObjects = document.querySelector(".facts");
let btnAddFact = document.querySelector("#addFact");
let htmlFactItem = `
<div class="facts_item">
  <div class="row">
    <div class="col-11 row">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
        <label for="facts_item_desc">Thành tựu</label>
            <input type="text" name="home_facts[facts_item_desc][]" id="facts_item_desc"
              class="form-control" placeholder="Thành tựu...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
        <label for="facts_item_icon">Icon</label>
            <input type="text" name="home_facts[facts_item_icon][]" id="facts_item_icon"
              class="form-control" placeholder="Icon...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
        <label for="facts_item_number">Số lượng</label>
            <input type="number" name="home_facts[facts_item_number][]" id="facts_item_number"
              class="form-control" placeholder="Số lượng...">
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="form-group">
        <label for="facts_item_unit">Đơn vị</label>
            <input type="text" name="home_facts[facts_item_unit][]" id="facts_item_unit"
              class="form-control" placeholder="Đơn vị...">
        </div>
      </div>
    </div>
    <div class="col-lg-1 col-md-1 pt-30">
      <button class="btn btn-danger btn-block remove">X</button>
    </div>
  </div>
  <hr>
</div>`;

if (factObjects !== null && btnAddFact !== null) {
  btnAddFact.addEventListener("click", (e) => {
    e.preventDefault();
    let factItemHtmlNode = new DOMParser()
      .parseFromString(htmlFactItem, "text/html")
      .querySelector(".facts_item");
    factObjects.appendChild(factItemHtmlNode);
  });

  factObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let factsItem = e.target;
        while (factsItem) {
          factsItem = factsItem.parentElement;
          if (factsItem.classList.contains("facts_item")) {
            break;
          }
        }
        if (factsItem !== null) {
          factsItem.remove();
        }
      }
    }
  });
}

//Xử lý thêm partner ở home_partner
let partnerObjects = document.querySelector(".partners-list");
let btnAddPartner = document.querySelector("#addPartners");
let htmlPartnerItem = `
<div class="partners-item">
  <div class="row">
    <div class="col-11 row">
    <div class="col-lg-7 col-md-7 col-12 mb-2">
      <div class="row ckfinder-group">
        <div class="col-9">
        <label for="partners_imgs">Ảnh đối tác</label>
            <input type="text" name="home_partners[partners_imgs][]" id="partners_imgs"
              class="form-control image-link" placeholder="Ảnh đối tác...">
        </div>
        <div class="col-3 pt-30">
            <button type="button" class="btn btn-success btn-block ckfinder-choose-image">
              <i class="fa fa-upload" aria-hidden="true"></i>
            </button>
        </div>
      </div>
    </div>
      <div class="col-lg-5 col-md-5 col-12">
        <div class="form-group">
        <label for="partners_imgs">Liên kết</label>
          <input type="text" name="home_partners[partners_links][]" id="partners_links"
            class="form-control image-link" placeholder="Liên kết...">
        </div>
      </div>
      </div>
      <div class="col-1 pt-30">
        <button class="btn btn-danger btn-block remove">X</button>
      </div>
  </div>
  <hr>
</div>`;

if (partnerObjects !== null && btnAddPartner !== null) {
  btnAddPartner.addEventListener("click", (e) => {
    e.preventDefault();
    let partnerItemHtmlNode = new DOMParser()
      .parseFromString(htmlPartnerItem, "text/html")
      .querySelector(".partners-item");
    partnerObjects.appendChild(partnerItemHtmlNode);
    openCkfinder();
  });

  partnerObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let partnersItem = e.target;
        while (partnersItem) {
          partnersItem = partnersItem.parentElement;
          if (partnersItem.classList.contains("partners-item")) {
            break;
          }
        }
        if (partnersItem !== null) {
          partnersItem.remove();
        }
      }
    }
  });
}

//Xử lý thêm quick link ở footer 2
let footer2ListObject = document.querySelector(".footer_2_list");
let btnAddQuickLinkFooter2 = document.querySelector("#addQuickLinkFooter2");
let htmlQuickLinkFooter2Item = `
<div class="footer_2_item">
  <div class="row">
      <div class="col-5">
        <div class="form-group">
            <input type="text" name="footer_2[footer_2_qick_link_content][]"
              id="footer_2_qick_link_content" class="form-control"
              placeholder="Nội dung liên kết...">
        </div>
      </div>
      <div class="col-5">
        <div class="form-group">
            <input type="text" name="footer_2[footer_2_qick_link][]" id="footer_2_qick_link"
              class="form-control" placeholder="Link liên kết...">
        </div>
      </div>
      <div class="col-2">
        <button class="btn btn-danger btn-block remove">X</button>
      </div>
  </div>
</div>`;

if (footer2ListObject !== null && btnAddQuickLinkFooter2 !== null) {
  btnAddQuickLinkFooter2.addEventListener("click", (e) => {
    e.preventDefault();
    let quickLinkFooter2ItemHtmlNode = new DOMParser()
      .parseFromString(htmlQuickLinkFooter2Item, "text/html")
      .querySelector(".footer_2_item");
    footer2ListObject.appendChild(quickLinkFooter2ItemHtmlNode);
  });

  footer2ListObject.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let quickLinkFooter2Item = e.target;
        while (quickLinkFooter2Item) {
          quickLinkFooter2Item = quickLinkFooter2Item.parentElement;
          if (quickLinkFooter2Item.classList.contains("footer_2_item")) {
            break;
          }
        }
        if (quickLinkFooter2Item !== null) {
          quickLinkFooter2Item.remove();
        }
      }
    }
  });
}

//Xử lý thêm member ở page team
let teamObjects = document.querySelector(".team-list");
let btnAddMember = document.querySelector("#addTeam");
let htmlTeamItem = `
<div class="team-item">
  <div class="row">
    <div class="col-11 row">
        <div class="col-lg-6 col-md-6 col-12">
          <div class="row ckfinder-group form-group">
              <div class="col-10">
                <label for="team_member_img">Ảnh thành viên</label>
                <input type="text" name="page_team[team_member_img][]"
                    id="team_member_img" class="form-control image-link"
                    placeholder="Ảnh thành viên...">
              </div>
              <div class="col-2 pt-30">
                <button type="button"
                    class="btn btn-success btn-block ckfinder-choose-image">
                    <i class="fa fa-upload" aria-hidden="true"></i>
                </button>
              </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_name">Tên thành viên</label>
              <input type="text" name="page_team[team_member_name][]"
                id="team_member_name" class="form-control image-link"
                placeholder="Tên thành viên...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_position">Chức vụ</label>
              <input type="text" name="page_team[team_member_position][]"
                id="team_member_position" class="form-control image-link"
                placeholder="Chức vụ...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_facebook">Liên kết Facebook</label>
              <input type="text" name="page_team[team_member_facebook][]"
                id="team_member_facebook" class="form-control image-link"
                placeholder="Liên kết facebook...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_twitter">Liên kết Twitter</label>
              <input type="text" name="page_team[team_member_twitter][]"
                id="team_member_twitter" class="form-control image-link"
                placeholder="Liên kết twitter...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_linkedin">Liên kết Linkedin</label>
              <input type="text" name="page_team[team_member_linkedin][]"
                id="team_member_linkedin" class="form-control image-link"
                placeholder="Liên kết linkedin...">
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12">
          <div class="form-group">
              <label for="team_member_behance">Liên kết Behance</label>
              <input type="text" name="page_team[team_member_behance][]"
                id="team_member_behance" class="form-control image-link"
                placeholder="Liên kết behance...">
          </div>
        </div>
    </div>
    <div class="col-1 pt-30">
        <button class="btn btn-danger btn-block remove">X</button>
    </div>
  </div>
  <hr>
</div>`;

if (teamObjects !== null && btnAddMember !== null) {
  btnAddMember.addEventListener("click", (e) => {
    e.preventDefault();
    let teamItemHtmlNode = new DOMParser()
      .parseFromString(htmlTeamItem, "text/html")
      .querySelector(".team-item");
    teamObjects.appendChild(teamItemHtmlNode);
    openCkfinder();
  });

  teamObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let teamItem = e.target;
        while (teamItem) {
          teamItem = teamItem.parentElement;
          if (teamItem.classList.contains("team-item")) {
            break;
          }
        }
        if (teamItem !== null) {
          teamItem.remove();
        }
      }
    }
  });
}

//Xử lý thêm member ở page team
let messageTypeObjects = document.querySelector(".message_type");
let btnAddMessageType = document.querySelector("#addMessageType");
let htmlMessageTypeItem = `
<div class="message_type-item">
  <div class="row">
    <div class="col-11">
        <div class="form-group">
          <input type="text" name="page_contact_message_type[]"
              id="page_contact_message_type" class="form-control"
              placeholder="Liên hệ...">
        </div>
    </div>
    <div class="col-1">
        <button class="btn btn-danger btn-block remove">X</button>
    </div>
  </div>
</div>`;

if (messageTypeObjects !== null && btnAddMessageType !== null) {
  btnAddMessageType.addEventListener("click", (e) => {
    e.preventDefault();
    let messageTypeItemHtmlNode = new DOMParser()
      .parseFromString(htmlMessageTypeItem, "text/html")
      .querySelector(".message_type-item");
    messageTypeObjects.appendChild(messageTypeItemHtmlNode);
  });

  messageTypeObjects.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("remove") ||
      e.target.parentElement.classList.contains("remove")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let messageTypeItem = e.target;
        while (messageTypeItem) {
          messageTypeItem = messageTypeItem.parentElement;
          if (messageTypeItem.classList.contains("message_type-item")) {
            break;
          }
        }
        if (messageTypeItem !== null) {
          messageTypeItem.remove();
        }
      }
    }
  });
}

//select multi tags
if (document.getElementById("portfolio_cate_id") != null) {
  new MultiSelectTag("portfolio_cate_id");
}

//SETUP menu editor
// icon picker options
var iconPickerOptions = { searchText: "Buscar...", labelHeader: "{0}/{1}" };
// sortable list options
var sortableListOptions = {
  placeholderCss: { "background-color": "#cccccc" },
};
var editor = new MenuEditor("myEditor", {
  listOptions: sortableListOptions,
  iconPicker: iconPickerOptions,
  maxLevel: 2, // (Optional) Default is -1 (no level limit)
  // Valid levels are from [0, 1, 2, 3,...N]
});

if ($("#save-menu").length > 0) {
  editor.setData(arrayJson);
  editor.setForm($("#frmEdit"));
  editor.setUpdateButton($("#btnUpdate"));
  //Calling the update method
  $("#btnUpdate").click(function () {
    editor.update();
  });
  // Calling the add method
  $("#btnAdd").click(function () {
    editor.add();
  });
  $("#save-menu").click(function (e) {
    e.preventDefault();
    var str = editor.getString();
    $("#json-menu").val(str);
    $("#frmEdit").submit();
  });
}

//Xử lý phân quyền
var permissionObj = document.querySelector(".permission-list");
if (permissionObj != null) {
  var allowArr = ["add", "edit", "delete", "permission"];
  var listTr = document.querySelectorAll("tr");
  if (listTr != null) {
    listTr.forEach(function (item) {
      var listInput = item.querySelectorAll('input[type="checkbox"]');
      if (listInput != null) {
        listInput.forEach((input) => {
          input.addEventListener("click", () => {
            let valueInput = input.value;
            if (valueInput.trim() !== "" && allowArr.includes(valueInput)) {
              let listsObj = item.querySelector('input[value="lists"]');
              if (listsObj != null) {
                listsObj.checked = true;
              }
            } else if (valueInput == "lists") {
              if (input.checked == false) {
                listInput.forEach((itemInput) => {
                  if (itemInput.value != "lists") {
                    itemInput.checked = false;
                  }
                });
              }
            }
          });
        });
      }
    });
  }
}
