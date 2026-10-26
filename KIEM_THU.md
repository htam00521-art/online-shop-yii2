# Bảng kiểm thử CRUD giỏ hàng

- **Dự án:** online-shop-yii2 (Yii2, MySQL `online_shop`)
- **Người kiểm thử:** (ghi tên bạn)
- **Ngày kiểm thử:** 26/10/2026
- **Môi trường:** Windows, XAMPP (MySQL), PHP 8.2.12, chạy bằng `php yii serve`, trình duyệt Cốc Cốc
- **Nhánh:** `feature/giao-dien-kiem-thu` (đã gộp `feature/delete` và `feature/update`)
- **Cách điền:** thao tác thật trên trình duyệt rồi ghi vào cột "Kết quả thực tế". Cột "Đạt/Lỗi" ghi `Đạt` hoặc `Lỗi`. Mỗi dòng `Lỗi` phải có một Issue trên GitHub (ghi số Issue ở cột cuối).
- **Lưu ý khi thử Xóa:** dùng giỏ do chính mình tạo, không xóa giỏ #1 và 3 sách mẫu.

Địa chỉ các trang (thay 8080 nếu bạn đổi cổng):

| Trang | Địa chỉ |
|---|---|
| Danh sách giỏ | `http://localhost:8080/index.php?r=cart-create/index` |
| Chi tiết giỏ | `http://localhost:8080/index.php?r=cart-create/view&id=1` |
| Danh sách dòng giỏ (chức năng Xem) | `http://localhost:8080/index.php?r=cart/index` |
| Sửa số lượng | `http://localhost:8080/index.php?r=cart/update&id=<mã dòng>` |
| Trang Xóa của nhóm | `http://localhost:8080/index.php?r=cart-delete/index` |

## A. Xem

| STT | Thao tác | Kết quả mong đợi | Kết quả thực tế | Đạt/Lỗi | Phụ trách | Issue |
|---|---|---|---|---|---|---|
| A1 | Mở danh sách giỏ | Hiện đủ các giỏ, giỏ mới nhất ở trên | | | Hoàng Quí | |
| A2 | Bấm "Xem giỏ" một giỏ có sách | Hiện đúng sách, số lượng, thành tiền; tổng cộng bằng tổng các thành tiền | | | Hoàng Quí | |
| A3 | Tạo giỏ mới rồi mở giỏ đó | Hiện dòng "Giỏ hàng đang trống" | | | Hoàng Quí | |
| A4 | Mở `cart-create/view&id=9999` | Báo "Giỏ hàng không tồn tại" (404) | | | Hoàng Quí | |
| A5 | Mở `cart/index` | Hiện các dòng giỏ với tên sách, đơn giá, số lượng, thành tiền | | | Người làm PR #2 | |
| A6 | Tạo giỏ mới, so giờ "Tạo lúc" với đồng hồ máy | Khớp giờ Việt Nam | | | Nhóm trưởng (config) | |

## B. Thêm

| STT | Thao tác | Kết quả mong đợi | Kết quả thực tế | Đạt/Lỗi | Phụ trách | Issue |
|---|---|---|---|---|---|---|
| B1 | Bấm "+ Tạo giỏ hàng mới" | Thông báo xanh, chuyển sang trang giỏ mới | | | Hoàng Quí | |
| B2 | Chọn sách, số lượng 1, bấm "Thêm vào giỏ" | Thông báo xanh, sách xuất hiện trong bảng, tổng tiền tăng | | | Hoàng Quí | |
| B3 | Thêm lại đúng cuốn sách đó | Số lượng cộng dồn, không tạo dòng mới | | | Hoàng Quí | |
| B4 | Nhập số lượng lớn hơn tồn kho (ví dụ 100) | Thông báo đỏ "chỉ còn ... cuốn trong kho" | | | Hoàng Quí | |
| B5 | Nhập số lượng 0 | Bị chặn hoặc báo lỗi "Số lượng phải lớn hơn 0" | | | Hoàng Quí | |
| B6 | Nhập số lượng âm (ví dụ -3) | Bị chặn hoặc báo lỗi | | | Hoàng Quí | |
| B7 | Để trống ô số lượng rồi thêm | Báo lỗi, không bị văng trang lỗi | | | Hoàng Quí | |
| B8 | Gõ thẳng `r=cart-create/create` lên thanh địa chỉ | Bị từ chối (chỉ nhận POST), không tạo giỏ | | | Hoàng Quí | |

## C. Sửa

| STT | Thao tác | Kết quả mong đợi | Kết quả thực tế | Đạt/Lỗi | Phụ trách | Issue |
|---|---|---|---|---|---|---|
| C1 | Bấm nút "Sửa" ở một dòng sách | Mở form sửa, ô số lượng hiện số hiện tại | | | Thủy (PR #4) | |
| C2 | Đổi số lượng hợp lệ (không vượt tồn kho) rồi lưu | Thông báo "Cập nhật số lượng thành công", số lượng đổi | | | Thủy (PR #4) | |
| C3 | Sửa số lượng vượt tồn kho | Thông báo đỏ "Số lượng vượt quá tồn kho" | | | Thủy (PR #4) | |
| C4 | Sửa số lượng 0 hoặc âm | Thông báo đỏ "Số lượng phải lớn hơn 0" | | | Thủy (PR #4) | |
| C5 | Mở `cart/update&id=9999` | Báo không tìm thấy (404), không văng lỗi 500 | | | Thủy (PR #4) | |
| C6 | Sau khi sửa thành công, xem thông báo | Thông báo hiện ra ở trang đích, người dùng thấy được | | | Thủy (PR #4) | |
| C7 | Sau khi sửa xong, trang chuyển đến đâu | Quay lại trang giỏ đang xem (không nhảy sang trang khác) | | | Thủy (PR #4) | |

## D. Xóa

| STT | Thao tác | Kết quả mong đợi | Kết quả thực tế | Đạt/Lỗi | Phụ trách | Issue |
|---|---|---|---|---|---|---|
| D1 | Bấm "Xóa" ở một sách, chọn Hủy | Không xóa gì | | | Hiếu Tâm (PR #5) | |
| D2 | Bấm "Xóa" ở một sách, chọn OK | Sách biến mất khỏi giỏ, có thông báo | | | Hiếu Tâm (PR #5) | |
| D3 | Bấm "Xóa giỏ hàng", chọn Hủy | Không xóa gì | | | Hiếu Tâm (PR #5) | |
| D4 | Bấm "Xóa giỏ hàng", chọn OK | Giỏ biến mất khỏi danh sách; trong phpMyAdmin các dòng `cart_items` của giỏ cũng mất | | | Hiếu Tâm (PR #5) | |
| D5 | Gõ thẳng `r=cart-delete/remove-item&id=<số>` lên thanh địa chỉ | Bị từ chối (chỉ nhận POST), dữ liệu không mất | | | Hiếu Tâm (PR #5) | |
| D6 | Xóa dòng không tồn tại (id 9999) | Báo không tìm thấy (404) | | | Hiếu Tâm (PR #5) | |
| D7 | Sau khi xóa xong, trang chuyển đến đâu | Quay lại trang hợp lý (danh sách giỏ hoặc giỏ đang xem) | | | Hiếu Tâm (PR #5) | |

## E. Giao diện chung

| STT | Thao tác | Kết quả mong đợi | Kết quả thực tế | Đạt/Lỗi | Phụ trách | Issue |
|---|---|---|---|---|---|---|
| E1 | Thu nhỏ cửa sổ trình duyệt bằng độ rộng điện thoại | Trang không vỡ, bảng cuộn ngang được | | | Du Kiệt | |
| E2 | Đi qua các trang cart-create, cart, cart-delete | Màu sắc, kiểu nút, đơn vị tiền (đ hay VNĐ) thống nhất | | | Cả nhóm | |
| E3 | Xem thanh menu trên cùng | Có mục dẫn tới Giỏ hàng, không còn chữ mặc định của Yii | | | Du Kiệt | |

## Danh sách lỗi đã ghi Issue

| STT | Mô tả ngắn | Mã kiểm thử | Số Issue | Giao cho | Trạng thái |
|---|---|---|---|---|---|
| 1 | | | | | |
