-- Thêm 15 sách mẫu vào bảng books (database online_shop).
-- Chạy MỘT LẦN trong phpMyAdmin: chọn database online_shop, tab SQL, dán và bấm Thực hiện.
-- Cột id tự tăng nên không cần ghi. created_at và updated_at là số giây Unix.

INSERT INTO books (title, author, price, stock, description, created_at, updated_at) VALUES
('Cây Cam Ngọt Của Tôi', 'José Mauro de Vasconcelos', 95000, 18, 'Câu chuyện cảm động về cậu bé Zezé và người bạn là cây cam', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Dế Mèn Phiêu Lưu Ký', 'Tô Hoài', 55000, 20, 'Cuộc phiêu lưu của chú dế mèn qua nhiều vùng đất', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Mắt Biếc', 'Nguyễn Nhật Ánh', 89000, 15, 'Chuyện tình day dứt của Ngạn dành cho Hà Lan', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'Nguyễn Nhật Ánh', 92000, 14, 'Tuổi thơ làng quê của hai anh em Thiều và Tường', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'Nguyễn Nhật Ánh', 78000, 16, 'Những trò nghịch ngợm và ký ức tuổi thơ trong trẻo', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Sapiens: Lược Sử Loài Người', 'Yuval Noah Harari', 189000, 10, 'Lịch sử loài người từ thời nguyên thủy đến hiện đại', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Atomic Habits - Thay Đổi Tí Hon, Hiệu Quả Bất Ngờ', 'James Clear', 139000, 12, 'Cách xây dựng thói quen tốt bằng những thay đổi nhỏ', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Tư Duy Nhanh Và Chậm', 'Daniel Kahneman', 169000, 8, 'Hai hệ thống tư duy chi phối cách chúng ta quyết định', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Nghĩ Giàu Làm Giàu', 'Napoleon Hill', 98000, 17, 'Các nguyên tắc tư duy giúp đạt được thành công', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Cha Giàu Cha Nghèo', 'Robert T. Kiyosaki', 109000, 19, 'Bài học về tiền bạc và đầu tư từ hai người cha', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Hoàng Tử Bé', 'Antoine de Saint-Exupéry', 65000, 20, 'Chuyện về cậu hoàng tử nhỏ đến từ một tiểu hành tinh', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Không Gia Đình', 'Hector Malot', 120000, 9, 'Hành trình lưu lạc của cậu bé Remi cùng gánh xiếc rong', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Sherlock Holmes Toàn Tập', 'Arthur Conan Doyle', 249000, 6, 'Các vụ án nổi tiếng của thám tử Sherlock Holmes', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Số Đỏ', 'Vũ Trọng Phụng', 72000, 13, 'Tiểu thuyết trào phúng về xã hội thành thị đầu thế kỷ 20', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('Clean Code', 'Robert C. Martin', 295000, 5, 'Nguyên tắc viết mã nguồn sạch, dễ đọc và dễ bảo trì', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
