# Tài liệu bàn giao: bước 7 (giao diện và kiểm thử)

Tài liệu này giúp người tiếp theo chạy được dự án, biết file nào của ai, và biết còn việc gì.
Ô `[ ]` là việc cần tích sau khi làm xong. Chỗ `#?` là số Issue cần điền.

## 1. Dự án

- Tên: online-shop-yii2 (quản lý giỏ hàng sách), repo `htam00521-art/online-shop-yii2`
- Công nghệ: Yii2 basic, PHP 8.2, MySQL (XAMPP), Bootstrap 5
- Nhánh bàn giao: `feature/giao-dien-kiem-thu`, Pull request #6

## 2. Cách chạy dự án

1. Cài Git, XAMPP, Composer, VS Code.
2. `git clone https://github.com/htam00521-art/online-shop-yii2.git`, vào thư mục rồi `composer install`
   (khi hỏi "c3.php has changed ... replace?" thì gõ `n`).
3. XAMPP: bấm Start ở MySQL. Vào `http://localhost/phpmyadmin`, tạo database `online_shop`
   (collation `utf8mb4_general_ci`), tab Import chọn `database/online_shop.sql`.
4. `config/db.php` đã đặt sẵn: dbname `online_shop`, user `root`, mật khẩu trống.
5. Nếu `cookieValidationKey` trong `config/web.php` rỗng thì điền chuỗi bất kỳ (không commit).
6. Chạy `php yii serve` rồi mở `http://localhost:8080`.

Mỗi lần mở máy: bật MySQL trong XAMPP, rồi chạy lại `php yii serve`.

## 3. Địa chỉ các trang

| Trang | Địa chỉ |
|---|---|
| Danh sách giỏ hàng | `/index.php?r=cart-create/index` |
| Chi tiết giỏ (thêm, sửa, xóa sách) | `/index.php?r=cart-create/view&id=<mã giỏ>` |
| Danh sách các dòng giỏ (Xem) | `/index.php?r=cart/index` |
| Sửa số lượng | `/index.php?r=cart/update&id=<mã dòng>` |
| Trang Xóa của bạn Tâm | `/index.php?r=cart-delete/index` |
| Danh sách sách | `/index.php?r=book/index` |

## 4. Dữ liệu (database `online_shop`)

| Bảng | Cột |
|---|---|
| `books` | id, title, author, price, stock, description, created_at, updated_at |
| `carts` | id, created_at, updated_at (không có cột `status`) |
| `cart_items` | id, cart_id, book_id, quantity, created_at, updated_at |

`created_at` và `updated_at` là số giây Unix, hiển thị bằng `Yii::$app->formatter->asDatetime(...)`.

## 5. Controller và view theo chức năng

| Chức năng | Controller::action | View | Người làm |
|---|---|---|---|
| Thêm | `CartCreateController` (index, create, view, add-item) | `views/cart-create/` | Hoàng Quí |
| Xem | `CartController` (index, view) | `views/cart/` | người làm PR #2 |
| Sửa | `CartController::actionUpdate` | `views/cart/update.php` | Thủy (PR #4) |
| Xóa | `CartDeleteController` (index, remove-item, delete-cart) | `views/cart-delete/` | Hiếu Tâm (PR #5) |
| Sách | `BookController::actionIndex` | `views/book/index.php` | bước 7 |

## 6. Giao diện

- CSS dùng chung: `web/css/shop.css`, mọi class có tiền tố `shop-` (không đụng CSS của người khác).
- Mỗi view nạp CSS bằng `$this->registerCssFile('@web/css/shop.css');`.
- Màu đổi ở khối `:root` đầu file `shop.css`.
- Các trang `views/cart/` và `views/cart-delete/` vẫn dùng Bootstrap mặc định.

## 7. Việc đã làm ở bước 7

- [ ] Làm lại giao diện danh sách giỏ và chi tiết giỏ (`cart-create`), thêm form thêm sách
- [ ] Gắn nút Sửa, Xóa từng sách và nút Xóa giỏ vào trang chi tiết giỏ
- [ ] Truyền `item_id` từ `CartCreateController` sang view
- [ ] Sau khi Sửa và Xóa, chuyển về trang giỏ hàng (không còn nhảy sang trang khác)
- [ ] Thêm trang danh sách sách và mục menu Giỏ hàng, Sách
- [ ] Sửa lỗi trong code của thành viên khác (chi tiết ở mục 8)
- [ ] Kiểm thử và ghi kết quả trong `KIEM_THU.md`

## 8. Lỗi đã biết và đã xử lý

| Lỗi | Phụ trách | Tình trạng | Issue |
|---|---|---|---|
| Sửa số lượng báo `Unknown Property Cart::status` (bảng không có cột status) | Thủy | Đã tạm sửa bằng `hasAttribute('status')`, chờ xác nhận | #? |
| `CartDeleteController.php` có dòng trống trước `<?php` gây Compile Error | Hiếu Tâm | Đã sửa trong PR #6 | #? |
| Thông báo của chức năng Xóa viết không dấu | Hiếu Tâm | Đã thêm dấu trong PR #6 | #? |
| Giờ hiển thị lệch 6 tiếng (múi giờ mặc định Europe/Berlin) | Nhóm trưởng | Đã đặt `timeZone` Asia/Ho_Chi_Minh trong `config/web.php` | #? |
| `models/LoginForm.php` lỗi cú pháp dòng 31 | Nhóm trưởng | Xem Issue | #? |
| Sửa dòng không tồn tại báo lỗi 500 thay vì 404 | Thủy | Đã thêm kiểm tra null | #? |

## 9. Quy tắc làm việc nhóm

- Mỗi việc một nhánh `feature/...`, gộp qua Pull request, không đẩy thẳng lên `main`.
- Không commit `config/db.php` hay khóa `cookieValidationKey` của riêng máy mình.
- Không dùng `git add .`; thêm đúng từng file đã sửa.
- Xóa trong lúc thử chỉ làm trên giỏ tự tạo, không xóa giỏ mẫu.
- Mỗi lỗi tìm thấy phải có một Issue, gán đúng người phụ trách.

## 10. Việc đề xuất cho người tiếp theo

- Thống nhất giao diện `views/cart/` và `views/cart-delete/` theo `shop.css`.
- Quyết định về cột `status` của giỏ: thêm vào bảng hoặc bỏ phần kiểm tra trong `actionUpdate`.
- `actionUpdate` đang cho nạp mọi trường của `CartItem` từ form; nên chỉ cho sửa `quantity`.
- Hoàn thiện đăng nhập sau khi sửa `LoginForm.php`.
- Điền các dòng còn trống trong `KIEM_THU.md`.
