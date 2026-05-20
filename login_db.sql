-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2026 lúc 05:47 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `login_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lophoc`
--

CREATE TABLE `lophoc` (
  `id` int(11) NOT NULL,
  `ten_lop` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lophoc`
--

INSERT INTO `lophoc` (`id`, `ten_lop`) VALUES
(1, 'HÁN NGỮ HW Tối 2-4-6'),
(7, 'HÁN NGỮ HW TỐI 3-5-7');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ngayhoc`
--

CREATE TABLE `ngayhoc` (
  `id` int(11) NOT NULL,
  `day_number` int(11) NOT NULL,
  `ten_day` varchar(50) DEFAULT NULL,
  `lop_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ngayhoc`
--

INSERT INTO `ngayhoc` (`id`, `day_number`, `ten_day`, `lop_id`) VALUES
(1, 1, 'Day 1', 1),
(2, 2, 'Day 2', 1),
(3, 3, 'Day 3', 1),
(4, 4, 'Day 4', 1),
(5, 5, 'Day 5', 1),
(19, 1, 'Day 1', 7),
(20, 2, 'Day 2', 7),
(25, 3, 'Day 3', 7),
(26, 4, 'Day 4', 7),
(27, 5, 'Day 5', 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ontap`
--

CREATE TABLE `ontap` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `cau_hoi` varchar(500) NOT NULL,
  `dap_an_a` varchar(255) NOT NULL,
  `dap_an_b` varchar(255) NOT NULL,
  `dap_an_dung` char(1) NOT NULL,
  `dap_an_c` varchar(500) NOT NULL DEFAULT '',
  `dap_an_d` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ontap`
--

INSERT INTO `ontap` (`id`, `day_id`, `cau_hoi`, `dap_an_a`, `dap_an_b`, `dap_an_dung`, `dap_an_c`, `dap_an_d`) VALUES
(1, 1, '\"Bác sĩ\" trong tiếng Trung là gì?', '医院 (Yīyuàn)', '护士 (Hùshi)', 'c', '医生 (Yīshēng)', '老师 (Lǎoshī)'),
(2, 1, '\"眼睛\" (Yǎnjīng) nghĩa là gì?', 'Cái tai', 'Cái mũi', 'c', 'Đôi mắt', 'Cái miệng'),
(3, 1, 'Khi bị đau đầu, ta nói?', '发烧 (Fāshāo)', '咳嗽', 'd', '感冒', '头疼 (Tóuténg)'),
(4, 1, '\"Mũi\" trong tiếng Trung gọi là?', '嘴 (Zuǐ)', '眼睛', 'd', '耳朵', '鼻子 (Bízi)'),
(5, 1, '\"Tay\" và \"Chân\" là bộ đôi nào?', '耳朵 - 嘴', '手 (Shǒu) - 脚 (Jiǎo)', 'b', '头 - 手', '眼睛 - 鼻子'),
(6, 1, '\"Thuốc\" tiếng Trung là gì?', '医院', '医生', 'c', '药 (Yào)', '休息 (Xiūxi)'),
(7, 1, '\"Nghỉ ngơi\" nghĩa là gì?', '工作', '学习', 'd', '起床', '休息 (Xiūxi)'),
(8, 1, 'Phát âm của \"身体\" (Cơ thể)?', 'shēng bìng', 'shēn bìng', 'd', 'shēng tǐ', 'shēn tǐ'),
(9, 1, '\"Mũi\" là Bízi, vậy \"Miệng\" là gì?', '耳朵', '眼睛', 'd', '鼻子', '嘴 (Zuǐ)'),
(10, 1, '\"Bị ốm/Bị bệnh\" là từ nào?', '身体', '健康', 'd', '医生', '生病 (Shēngbìng)'),
(11, 2, '\"Bây giờ\" trong tiếng Trung là gì?', '昨天', '明天', 'c', '现在 (Xiànzài)', '以前'),
(12, 2, '\"Hôm qua\" phát âm là gì?', 'Jīntiān', 'Míngtiān', 'd', 'Xiànzài', 'Zuótiān'),
(13, 2, '\"星期\" (Xīngqī) nghĩa là gì?', 'Tháng', 'Năm', 'd', 'Ngày', 'Tuần'),
(14, 2, '1 tiếng đồng hồ là?', '分钟', '秒', 'c', '小时 (Xiǎoshí)', '天'),
(15, 2, '\"Buổi tối\" trong tiếng Trung là?', '下午', '早上', 'd', '中午', '晚上 (Wǎnshàng)'),
(16, 2, 'Hôm nay là \"Jīntiān\", vậy ngày mai là?', '昨天', '现在', 'd', '以前', '明天 (Míngtiān)'),
(17, 2, '\"Trước đây\" và \"Sau này\" là cặp nào?', '早上 - 晚上', '今天 - 明天', 'd', '昨天 - 今天', '以前 - 以后'),
(18, 2, 'Từ nào chỉ đơn vị \"Phút\"?', '小时', '秒', 'd', '天', '分钟 (Fēnzhōng)'),
(19, 2, '\"Buổi sáng\" phát âm là gì?', 'Xiàwǔ', 'Wǎnshàng', 'd', 'Zhōngwǔ', 'Zǎoshang'),
(20, 2, '\"Tháng\" trong tiếng Trung là?', '年', '天', 'd', '星期', '月 (Yuè)'),
(21, 3, '\"Trường học\" tiếng Trung là gì?', '教室', '老师', 'd', '学生', '学校 (Xuéxiào)'),
(22, 3, '\"Giáo viên\" gọi là gì?', '同学', '学生', 'd', '校长', '老师 (Lǎoshī)'),
(23, 3, '\"Làm bài tập\" dùng từ nào?', '考试', '学习', 'd', '写字', '作业 (Zuòyè)'),
(24, 3, '\"Hiểu/Thông hiểu\" nghĩa là gì?', '回答', '学习', 'd', '记住', '理解 (Lǐjiě)'),
(25, 3, '\"Ôn tập bài cũ\" là từ nào?', '预习', '学习', 'd', '考试', '复习 (Fùxí)'),
(26, 3, '\"Cố gắng, nỗ lực\" tiếng Trung là?', '成绩', '学习', 'd', '加油', '努力 (Nǔlì)'),
(27, 3, '\"Bạn học\" phát âm là gì?', 'Lǎoshī', 'Xuéxiào', 'd', 'Jiàoshì', 'Tóngxué'),
(28, 3, '\"Trả lời\" câu hỏi dùng từ gì?', '问题', '理解', 'd', '学习', '回答 (Huídá)'),
(29, 3, '\"Lớp học\" là từ nào?', '学校', '学生', 'd', '老师', '教室 (Jiàoshì)'),
(30, 3, '\"Thành tích/Điểm số\" là gì?', '作业', '考试', 'd', '学习', '成绩 (Chéngjì)'),
(31, 4, '\"Vui vẻ\" trong tiếng Trung là gì?', '难过', '生气', 'd', '害怕', '高兴 (Gāoxìng)'),
(32, 4, '\"Tức giận\" phát âm là gì?', 'Hàipà', 'Gāoxìng', 'd', 'Nánguò', 'Shēngqì'),
(33, 4, '\"Thông minh\" là từ nào?', '认真', '努力', 'd', '简单', '聪明 (Cōngmíng)'),
(34, 4, '\"Thân thiện\" nghĩa là gì?', '热情', '冷淡', 'd', '开心', '友好 (Yǒuhǎo)'),
(35, 4, '\"Giúp đỡ\" người khác dùng từ gì?', '希望', '喜欢', 'd', '觉得', '帮助 (Bāngzhù)'),
(36, 4, '\"Sợ hãi\" tiếng Trung là?', '担心', '紧张', 'd', '生气', '害怕 (Hàipà)'),
(37, 4, '\"Yêu\" tiếng Trung là gì?', '喜欢', '帮助', 'd', '希望', '爱 (Ài)'),
(38, 4, '\"Cảm thấy/Cho rằng\" là từ?', '希望', '喜欢', 'd', '帮助', '觉得 (Juéde)'),
(39, 4, '\"Buồn bã\" là từ?', '失望', '生气', 'd', '开心', '难过 (Nánguò)'),
(40, 5, '\"Ăn cơm\" trong tiếng Trung là gì?', '睡觉', '学习', 'd', '工作', '吃饭 (Chīfàn)'),
(41, 5, '\"Thức dậy\" phát âm là gì?', '洗澡', '睡觉', 'd', '吃饭', 'Qǐchuáng'),
(42, 5, '\"Siêu thị\" là từ nào?', '公园', '学校', 'd', '商店', '超市 (Chāoshì)'),
(43, 5, '\"Sở thích\" nghĩa là gì?', '运动', '学习', 'd', '工作', '爱好 (Àihào)'),
(44, 5, '\"Thời tiết\" tiếng Trung là gì?', '生活', '时间', 'd', '日子', '天气 (Tiānqì)'),
(45, 5, '\"Đi tắm\" dùng từ nào?', '睡觉', '起床', 'd', '吃饭', '洗澡 (Xǐzǎo)'),
(46, 5, '\"Ngủ\" phát âm là gì?', '起床', '洗澡', 'd', '工作', 'Shuìjiào'),
(47, 5, '\"Mua đồ\" tiếng Trung là gì?', '吃饭', '学习', 'd', '工作', '买东西 (Mǎi dōngxi)'),
(48, 19, '\"Bố\" trong tiếng Trung là gì?', '母亲', '哥哥', 'c', '父亲 (Fùqīn)', '爷爷'),
(49, 19, '\"Mẹ\" phát âm là gì?', 'Fùqīn', 'Mǔqīn', 'b', 'Jiějie', 'Mèimei'),
(50, 19, '\"Anh trai\" là từ nào?', '姐姐', '弟弟', 'c', '哥哥 (Gēge)', '妹妹'),
(51, 19, '\"Em gái\" nghĩa là gì?', '姐姐', '妹妹 (Mèimei)', 'b', '哥哥', '弟弟'),
(52, 19, '\"Vợ\" trong tiếng Trung là?', '丈夫', '妻子 (Qīzi)', 'b', '母亲', '孩子'),
(53, 19, '\"Chồng\" phát âm là gì?', 'Zhàngfu', 'Qīzi', 'a', 'Fùqīn', 'Háizi'),
(54, 19, '\"Ông\" là từ nào?', '奶奶', '爷爷 (Yéye)', 'b', '父亲', '哥哥'),
(55, 19, '\"Bà\" nghĩa là gì?', '爷爷', '母亲', 'c', '奶奶 (Nǎinai)', '姐姐'),
(56, 19, '\"Kết hôn\" tiếng Trung là gì?', '出生', '结婚 (Jiéhūn)', 'b', '帮助', '喜欢'),
(57, 19, '\"Sinh ra\" phát âm là gì?', 'Jiéhūn', 'Chūshēng', 'b', 'Xuéxí', 'Gōngzuò'),
(58, 20, '\"Màu đỏ\" trong tiếng Trung là gì?', '蓝色', '红色 (Hóngsè)', 'b', '黄色', '绿色'),
(59, 20, '\"Màu xanh lá\" là từ nào?', '绿色 (Lǜsè)', '蓝色', 'a', '黄色', '黑色'),
(60, 20, '\"Màu đen\" phát âm là gì?', 'Báisè', 'Hēisè', 'b', 'Huīsè', 'Zǐsè'),
(61, 20, '\"Màu trắng\" nghĩa là gì?', '白色 (Báisè)', '黑色', 'a', '红色', '粉色'),
(62, 20, '\"Màu hồng\" là từ nào?', '粉色 (Fěnsè)', '紫色', 'a', '橙色', '灰色'),
(63, 20, '\"Màu tím\" phát âm là gì?', 'Chéngsè', 'Zǐsè', 'b', 'Jīnsè', 'Yínsè'),
(64, 20, '\"Màu vàng\" là gì?', '黄色 (Huángsè)', '金色', 'a', '橙色', '红色'),
(65, 20, '\"Màu xám\" nghĩa là gì?', '灰色 (Huīsè)', '白色', 'a', '黑色', '蓝色'),
(66, 20, '\"Màu cam\" phát âm là gì?', 'Zǐsè', 'Chéngsè', 'b', 'Hóngsè', 'Lǜsè'),
(67, 20, '\"Màu nhạt\" là từ nào?', '深色', '浅色 (Qiǎnsè)', 'b', '白色', '灰色'),
(68, 25, '\"Cơm\" trong tiếng Trung là gì?', '面条', '米饭 (Mǐfàn)', 'b', '包子', '汤'),
(69, 25, '\"Mì\" phát âm là gì?', 'Miàntiáo', 'Mǐfàn', 'a', 'Bāozi', 'Jiǎozi'),
(70, 25, '\"Bánh bao\" là từ nào?', '包子 (Bāozi)', '面包', 'a', '饺子', '汤'),
(71, 25, '\"Thịt bò\" nghĩa là gì?', '鸡肉', '牛肉 (Niúròu)', 'b', '猪肉', '鱼'),
(72, 25, '\"Cá\" phát âm là gì?', 'Yú', 'Ròu', 'a', 'Tāng', 'Dàn'),
(73, 25, '\"Rau\" là từ nào?', '水果', '蔬菜 (Shūcài)', 'b', '鸡蛋', '面包'),
(74, 25, '\"Trái cây\" nghĩa là gì?', '蔬菜', '水果 (Shuǐguǒ)', 'b', '鸡肉', '牛肉'),
(75, 25, '\"Trứng\" phát âm là gì?', 'Jīdàn', 'Miànbāo', 'a', 'Tāng', 'Tiándiǎn'),
(98, 19, '\"Bố\" trong tiếng Trung là gì?', '母亲', '哥哥', 'c', '父亲 (Fùqīn)', '爷爷'),
(99, 19, '\"Mẹ\" phát âm là gì?', 'Fùqīn', 'Mǔqīn', 'b', 'Jiějie', 'Mèimei'),
(100, 19, '\"Anh trai\" là từ nào?', '姐姐', '弟弟', 'c', '哥哥 (Gēge)', '妹妹'),
(101, 19, '\"Em gái\" nghĩa là gì?', '姐姐', '妹妹 (Mèimei)', 'b', '哥哥', '弟弟'),
(102, 19, '\"Vợ\" trong tiếng Trung là?', '丈夫', '母亲', 'd', '孩子', '妻子 (Qīzi)'),
(103, 19, '\"Chồng\" phát âm là gì?', 'Zhàngfu', 'Qīzi', 'a', 'Fùqīn', 'Háizi'),
(104, 19, '\"Ông\" là từ nào?', '爷爷 (Yéye)', '奶奶', 'a', '父亲', '哥哥'),
(105, 19, '\"Bà\" nghĩa là gì?', '爷爷', '母亲', 'c', '奶奶 (Nǎinai)', '姐姐'),
(106, 19, '\"Kết hôn\" tiếng Trung là gì?', '出生', '帮助', 'd', '喜欢', '结婚 (Jiéhūn)'),
(107, 19, '\"Sinh ra\" phát âm là gì?', 'Jiéhūn', 'Xuéxí', 'c', 'Chūshēng', 'Gōngzuò'),
(108, 20, '\"Màu đỏ\" trong tiếng Trung là gì?', '蓝色', '黄色', 'd', '绿色', '红色 (Hóngsè)'),
(109, 20, '\"Màu xanh lá\" là từ nào?', '绿色 (Lǜsè)', '蓝色', 'a', '黄色', '黑色'),
(110, 20, '\"Màu đen\" phát âm là gì?', 'Báisè', 'Huīsè', 'c', 'Hēisè', 'Zǐsè'),
(111, 20, '\"Màu trắng\" nghĩa là gì?', '黑色', '白色 (Báisè)', 'b', '红色', '粉色'),
(112, 20, '\"Màu hồng\" là từ nào?', '紫色', '橙色', 'c', '粉色 (Fěnsè)', '灰色'),
(113, 20, '\"Màu tím\" phát âm là gì?', 'Zǐsè', 'Chéngsè', 'a', 'Jīnsè', 'Yínsè'),
(114, 20, '\"Màu vàng\" là gì?', '金色', '橙色', 'd', '红色', '黄色 (Huángsè)'),
(115, 20, '\"Màu xám\" nghĩa là gì?', '白色', '灰色 (Huīsè)', 'b', '黑色', '蓝色'),
(116, 20, '\"Màu cam\" phát âm là gì?', 'Zǐsè', 'Hóngsè', 'd', 'Lǜsè', 'Chéngsè'),
(117, 20, '\"Màu nhạt\" là từ nào?', '深色', '白色', 'c', '浅色 (Qiǎnsè)', '灰色'),
(118, 25, '\"Cơm\" trong tiếng Trung là gì?', '米饭 (Mǐfàn)', '面条', 'a', '包子', '汤'),
(119, 25, '\"Mì\" phát âm là gì?', 'Mǐfàn', 'Miàntiáo', 'b', 'Bāozi', 'Jiǎozi'),
(120, 25, '\"Bánh bao\" là từ nào?', '面包', '饺子', 'd', '汤', '包子 (Bāozi)'),
(121, 25, '\"Thịt bò\" nghĩa là gì?', '鸡肉', '猪肉', 'c', '牛肉 (Niúròu)', '鱼'),
(122, 25, '\"Cá\" phát âm là gì?', 'Yú', 'Ròu', 'a', 'Tāng', 'Dàn'),
(123, 25, '\"Rau\" là từ nào?', '水果', '鸡蛋', 'd', '面包', '蔬菜 (Shūcài)'),
(124, 25, '\"Trái cây\" nghĩa là gì?', '水果 (Shuǐguǒ)', '蔬菜', 'a', '鸡肉', '牛肉'),
(125, 25, '\"Trứng\" phát âm là gì?', 'Miànbāo', 'Tāng', 'c', 'Jīdàn', 'Tiándiǎn'),
(126, 25, '\"Đồ ngọt\" là từ nào?', '饮料', '汤', 'd', '面条', '甜点 (Tiándiǎn)'),
(127, 25, '\"Đồ uống\" nghĩa là gì?', '水', '饮料 (Yǐnliào)', 'b', '牛奶', '咖啡'),
(128, 26, '\"Xe buýt\" trong tiếng Trung là gì?', '出租车', '火车', 'c', '公交车 (Gōngjiāochē)', '飞机'),
(129, 26, '\"Taxi\" phát âm là gì?', 'Huǒchē', 'Fēijī', 'd', 'Dìtiě', 'Chūzūchē'),
(130, 26, '\"Máy bay\" là từ nào?', '火车', '飞机 (Fēijī)', 'b', '地铁', '车'),
(131, 26, '\"Xe đạp\" nghĩa là gì?', '摩托车', '公交车', 'c', '自行车 (Zìxíngchē)', '出租车'),
(132, 26, '\"Tài xế\" phát âm là gì?', 'Chē', 'Sījī', 'b', 'Lù', 'Piào'),
(133, 26, '\"Sân bay\" là từ nào?', '车站', '路', 'd', '票', '机场 (Jīchǎng)'),
(134, 26, '\"Vé\" nghĩa là gì?', '票 (Piào)', '钱', 'a', '卡', '站'),
(135, 26, '\"Lên xe\" phát âm là gì?', 'Xiàchē', 'Zǒulù', 'c', 'Shàngchē', 'Kāichē'),
(136, 26, '\"Xuống xe\" là từ nào?', '上车', '开车', 'd', '走路', '下车 (Xiàchē)'),
(137, 26, '\"Đường\" nghĩa là gì?', '路 (Lù)', '车', 'a', '站', '机场'),
(138, 27, '\"Mua\" trong tiếng Trung là gì?', '卖', '钱', 'c', '买 (Mǎi)', '店'),
(139, 27, '\"Bán\" phát âm là gì?', 'Mǎi', 'Qián', 'd', 'Diàn', 'Mài'),
(140, 27, '\"Cửa hàng\" là từ nào?', '市场', '商店 (Shāngdiàn)', 'b', '超市', '公司'),
(141, 27, '\"Giá\" nghĩa là gì?', '钱', '卡', 'c', '价格 (Jiàgé)', '票'),
(142, 27, '\"Rẻ\" phát âm là gì?', 'Guì', 'Jiàgé', 'd', 'Mǎi', 'Piányi'),
(143, 27, '\"Đắt\" là từ nào?', '贵 (Guì)', '便宜', 'a', '价格', '钱'),
(144, 27, '\"Tiền\" nghĩa là gì?', '卡', '票', 'c', '钱 (Qián)', '价格'),
(145, 27, '\"Thẻ tín dụng\" phát âm là gì?', 'Xiànjīn', 'Qián', 'd', 'Zhīfù', 'Xìnyòngkǎ'),
(146, 27, '\"Giảm giá\" là từ nào?', '买', '打折 (Dǎzhé)', 'b', '卖', '钱'),
(147, 27, '\"Quần áo\" nghĩa là gì?', '衣服 (Yīfu)', '鞋', 'a', '市场', '大小');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tiendohoc`
--

CREATE TABLE `tiendohoc` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `day_number` int(11) DEFAULT NULL,
  `phan_hoc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tuvung`
--

CREATE TABLE `tuvung` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `hanzi` varchar(100) NOT NULL,
  `pinyin` varchar(100) NOT NULL,
  `nghia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tuvung`
--

INSERT INTO `tuvung` (`id`, `day_id`, `hanzi`, `pinyin`, `nghia`) VALUES
(1, 1, '身体', 'shen ti', 'Cơ thể'),
(2, 1, '医院', 'yī yuàn', 'Bệnh viện'),
(3, 1, '医生', 'yī shēng', 'Bác sĩ'),
(4, 1, '药', 'yào', 'Thuốc'),
(5, 1, '头', 'tóu', 'Đầu'),
(6, 1, '眼睛', 'yǎn jīng', 'Mắt'),
(7, 1, '耳朵', 'ěr duǒ', 'Tai'),
(8, 1, '鼻子', 'bí zi', 'Mũi'),
(9, 1, '嘴', 'zuǐ', 'Miệng'),
(10, 1, '手', 'shǒu', 'Tay'),
(11, 1, '脚', 'jiǎo', 'Chân'),
(12, 1, '生病', 'shēng bìng', 'Bị bệnh'),
(13, 1, '发烧', 'fā shāo', 'Sốt'),
(14, 1, '头疼', 'tóu téng', 'Đau đầu'),
(15, 1, '休息', 'xiū xi', 'Nghỉ ngơi'),
(16, 2, '时间', 'shí jiān', 'Thời gian'),
(17, 2, '现在', 'xiàn zài', 'Bây giờ'),
(18, 2, '今天', 'jīn tiān', 'Hôm nay'),
(19, 2, '昨天', 'zuó tiān', 'Hôm qua'),
(20, 2, '明天', 'míng tiān', 'Ngày mai'),
(21, 2, '下午', 'xià wǔ', 'Buổi chiều'),
(22, 2, '早上', 'zǎo shàng', 'Buổi sáng'),
(23, 2, '晚上', 'wǎn shàng', 'Buổi tối'),
(24, 2, '以前', 'yǐ qián', 'Trước đây'),
(25, 2, '以后', 'yǐ hòu', 'Sau này'),
(26, 2, '小时', 'xiǎo shí', 'Giờ (đơn vị)'),
(27, 2, '分钟', 'fēn zhōng', 'Phút'),
(28, 2, '星期', 'xīng qī', 'Tuần'),
(29, 2, '月', 'yuè', 'Tháng'),
(30, 2, '年', 'nián', 'Năm'),
(31, 3, '工作', 'gōng zuò', 'Công việc'),
(32, 3, '学习', 'xué xí', 'Học tập'),
(33, 3, '学校', 'xué xiào', 'Trường học'),
(34, 3, '教室', 'jiào shì', 'Lớp học'),
(35, 3, '老师', 'lǎo shī', 'Giáo viên'),
(36, 3, '同学', 'tóng xué', 'Bạn học'),
(37, 3, '作业', 'zuò yè', 'Bài tập'),
(38, 3, '考试', 'kǎo shì', 'Kỳ thi'),
(39, 3, '成绩', 'chéng jì', 'Điểm số'),
(40, 3, '努力', 'nǔ lì', 'Cố gắng'),
(41, 3, '复习', 'fù xí', 'Ôn bài'),
(42, 3, '预习', 'yù xí', 'Học trước'),
(43, 3, '问题', 'wèn tí', 'Câu hỏi'),
(44, 3, '回答', 'huí dá', 'Trả lời'),
(45, 3, '理解', 'lǐ jiě', 'Hiểu'),
(46, 4, '高兴', 'gāo xìng', 'Vui vẻ'),
(47, 4, '快乐', 'kuài lè', 'Hạnh phúc'),
(48, 4, '难过', 'nán guò', 'Buồn'),
(49, 4, '生气', 'shēng qì', 'Tức giận'),
(50, 4, '害怕', 'hài pà', 'Sợ hãi'),
(51, 4, '担心', 'dān xīn', 'Lo lắng'),
(52, 4, '喜欢', 'xǐ huān', 'Thích'),
(53, 4, '爱', 'ài', 'Yêu'),
(54, 4, '觉得', 'jué de', 'Cảm thấy'),
(55, 4, '希望', 'xī wàng', 'Hy vọng'),
(56, 4, '聪明', 'cōng míng', 'Thông minh'),
(57, 4, '认真', 'rèn zhēn', 'Nghiêm túc'),
(58, 4, '热情', 'rè qíng', 'Nhiệt tình'),
(59, 4, '友好', 'yǒu hǎo', 'Thân thiện'),
(60, 4, '帮助', 'bāng zhù', 'Giúp đỡ'),
(61, 5, '天气', 'tiān qì', 'Thời tiết'),
(62, 5, '运动', 'yùn dòng', 'Thể thao'),
(63, 5, '吃饭', 'chī fàn', 'Ăn cơm'),
(64, 5, '睡觉', 'shuì jiào', 'Ngủ'),
(65, 5, '起床', 'qǐ chuáng', 'Thức dậy'),
(66, 5, '洗澡', 'xǐ zǎo', 'Tắm'),
(67, 5, '买东西', 'mǎi dōng xi', 'Mua đồ'),
(68, 5, '超市', 'chāo shì', 'Siêu thị'),
(69, 5, '公园', 'gōng yuán', 'Công viên'),
(70, 5, '图书馆', 'tú shū guǎn', 'Thư viện'),
(71, 5, '电影', 'diàn yǐng', 'Phim'),
(72, 5, '音乐', 'yīn yuè', 'Âm nhạc'),
(73, 5, '旅游', 'lǚ yóu', 'Du lịch'),
(74, 5, '爱好', 'ài hào', 'Sở thích'),
(75, 5, '生活', 'shēng huó', 'Cuộc sống'),
(79, 19, '家庭', 'jiā tíng', 'Gia đình'),
(80, 19, '父亲', 'fù qīn', 'Bố'),
(81, 19, '母亲', 'mǔ qīn', 'Mẹ'),
(82, 19, '哥哥', 'gē ge', 'Anh trai'),
(83, 19, '姐姐', 'jiě jie', 'Chị gái'),
(84, 19, '弟弟', 'dì di', 'Em trai'),
(85, 19, '妹妹', 'mèi mei', 'Em gái'),
(86, 19, '孩子', 'hái zi', 'Con cái'),
(87, 19, '丈夫', 'zhàng fu', 'Chồng'),
(88, 19, '妻子', 'qī zi', 'Vợ'),
(89, 19, '爷爷', 'yé ye', 'Ông'),
(90, 19, '奶奶', 'nǎi nai', 'Bà'),
(91, 19, '亲戚', 'qīn qi', 'Họ hàng'),
(92, 19, '结婚', 'jié hūn', 'Kết hôn'),
(93, 19, '出生', 'chū shēng', 'Sinh ra'),
(94, 20, '颜色', 'yán sè', 'Màu sắc'),
(95, 20, '红色', 'hóng sè', 'Màu đỏ'),
(96, 20, '蓝色', 'lán sè', 'Màu xanh dương'),
(97, 20, '黄色', 'huáng sè', 'Màu vàng'),
(98, 20, '绿色', 'lǜ sè', 'Màu xanh lá'),
(99, 20, '黑色', 'hēi sè', 'Màu đen'),
(100, 20, '白色', 'bái sè', 'Màu trắng'),
(101, 20, '粉色', 'fěn sè', 'Màu hồng'),
(102, 20, '灰色', 'huī sè', 'Màu xám'),
(103, 20, '橙色', 'chéng sè', 'Màu cam'),
(104, 20, '紫色', 'zǐ sè', 'Màu tím'),
(105, 20, '金色', 'jīn sè', 'Màu vàng kim'),
(106, 20, '银色', 'yín sè', 'Màu bạc'),
(107, 20, '深色', 'shēn sè', 'Màu đậm'),
(108, 20, '浅色', 'qiǎn sè', 'Màu nhạt'),
(109, 25, '米饭', 'mǐ fàn', 'Cơm'),
(110, 25, '面条', 'miàn tiáo', 'Mì'),
(111, 25, '包子', 'bāo zi', 'Bánh bao'),
(112, 25, '饺子', 'jiǎo zi', 'Há cảo'),
(113, 25, '鸡肉', 'jī ròu', 'Thịt gà'),
(114, 25, '牛肉', 'niú ròu', 'Thịt bò'),
(115, 25, '猪肉', 'zhū ròu', 'Thịt heo'),
(116, 25, '鱼', 'yú', 'Cá'),
(117, 25, '蔬菜', 'shū cài', 'Rau'),
(118, 25, '水果', 'shuǐ guǒ', 'Trái cây'),
(119, 25, '鸡蛋', 'jī dàn', 'Trứng'),
(120, 25, '面包', 'miàn bāo', 'Bánh mì'),
(121, 25, '汤', 'tāng', 'Canh'),
(122, 25, '甜点', 'tián diǎn', 'Đồ ngọt'),
(123, 25, '饮料', 'yǐn liào', 'Đồ uống'),
(124, 26, '车', 'chē', 'Xe'),
(125, 26, '公交车', 'gōng jiāo chē', 'Xe buýt'),
(126, 26, '出租车', 'chū zū chē', 'Taxi'),
(127, 26, '火车', 'huǒ chē', 'Tàu hỏa'),
(128, 26, '飞机', 'fēi jī', 'Máy bay'),
(129, 26, '地铁', 'dì tiě', 'Tàu điện ngầm'),
(130, 26, '自行车', 'zì xíng chē', 'Xe đạp'),
(131, 26, '摩托车', 'mó tuō chē', 'Xe máy'),
(132, 26, '司机', 'sī jī', 'Tài xế'),
(133, 26, '车站', 'chē zhàn', 'Bến xe'),
(134, 26, '机场', 'jī chǎng', 'Sân bay'),
(135, 26, '票', 'piào', 'Vé'),
(136, 26, '上车', 'shàng chē', 'Lên xe'),
(137, 26, '下车', 'xià chē', 'Xuống xe'),
(138, 26, '路', 'lù', 'Đường'),
(139, 27, '买', 'mǎi', 'Mua'),
(140, 27, '卖', 'mài', 'Bán'),
(141, 27, '商店', 'shāng diàn', 'Cửa hàng'),
(142, 27, '价格', 'jià gé', 'Giá'),
(143, 27, '便宜', 'pián yi', 'Rẻ'),
(144, 27, '贵', 'guì', 'Đắt'),
(145, 27, '钱', 'qián', 'Tiền'),
(146, 27, '现金', 'xiàn jīn', 'Tiền mặt'),
(147, 27, '信用卡', 'xìn yòng kǎ', 'Thẻ tín dụng'),
(148, 27, '打折', 'dǎ zhé', 'Giảm giá'),
(149, 27, '试', 'shì', 'Thử'),
(150, 27, '大小', 'dà xiǎo', 'Kích cỡ'),
(151, 27, '衣服', 'yī fu', 'Quần áo'),
(152, 27, '鞋', 'xié', 'Giày'),
(153, 27, '市场', 'shì chǎng', 'Chợ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `so_dien_thoai` varchar(15) DEFAULT NULL,
  `id_lop` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ho_ten`, `ngay_sinh`, `so_dien_thoai`, `id_lop`) VALUES
(1, 'admin', '123456', 'tuilahoangtucuaem@gmail.com', 'Nguyễn Văn Admin', '1995-10-20', '0987654321', 1),
(2, 'tranthib', 'matkhau123', 'tranthib@gmail.com', 'Trần Thị B', '2002-05-15', '0357123456', 1),
(8, 'ddhEstella95', 'Thanhduc1!', 'thanhbuiduc534@gmail.com', 'Thắng Ngu111', '2017-06-09', '0387193456', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `ten_video` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `video`
--

INSERT INTO `video` (`id`, `day_id`, `ten_video`) VALUES
(1, 1, 'vd1.mp4'),
(2, 2, 'vd2.mp4'),
(3, 3, 'vd3.mp4'),
(4, 4, 'vd4.mp4'),
(5, 5, 'vd5.mp4'),
(8, 19, 'vd19.mp4');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_lop` (`ten_lop`);

--
-- Chỉ mục cho bảng `ngayhoc`
--
ALTER TABLE `ngayhoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ngayhoc_lophoc` (`lop_id`);

--
-- Chỉ mục cho bảng `ontap`
--
ALTER TABLE `ontap`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tiendohoc`
--
ALTER TABLE `tiendohoc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tiendo_user` (`user_id`);

--
-- Chỉ mục cho bảng `tuvung`
--
ALTER TABLE `tuvung`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_lop` (`id_lop`);

--
-- Chỉ mục cho bảng `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `lophoc`
--
ALTER TABLE `lophoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `ngayhoc`
--
ALTER TABLE `ngayhoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `ontap`
--
ALTER TABLE `ontap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT cho bảng `tiendohoc`
--
ALTER TABLE `tiendohoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tuvung`
--
ALTER TABLE `tuvung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ngayhoc`
--
ALTER TABLE `ngayhoc`
  ADD CONSTRAINT `fk_ngayhoc_lophoc` FOREIGN KEY (`lop_id`) REFERENCES `lophoc` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tiendohoc`
--
ALTER TABLE `tiendohoc`
  ADD CONSTRAINT `fk_tiendo_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_lop` FOREIGN KEY (`id_lop`) REFERENCES `lophoc` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
