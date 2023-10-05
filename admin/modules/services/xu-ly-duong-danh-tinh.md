** Các bước tạo đường dẫn tĩnh **

- Bước 1: Lấy tên (Trường tên)
- Bước 2: Thay thế

* Chuyển tất cả các ký tự thành chữ thường
* Chuyển các chữ tiếng việt có dấu => không dấu
* Chuyển các ký tự đặc biệt (bao gồm cả khoảng trắng) => -

- Bước cuối: tự động điền input slug (sử dụng js)

** Ngôn ngữ lập trình sử dụng **

1. PHP

- Tạo slug tự động dựa vào trên (Trường slug không nhập)
- Update slug vào CSDL

2. JavaScript

- Tạo slug tự động dựa vào tên (Bắt sự kiện onkeyup ở trường tên)
- Điền dữ liệu vào trường slug

=> Gõ ký tự ở trường tên => trường slug sẽ tự động có slug
