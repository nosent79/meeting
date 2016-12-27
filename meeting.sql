-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        10.1.19-MariaDB - mariadb.org binary distribution
-- 서버 OS:                        Win32
-- HeidiSQL 버전:                  9.4.0.5141
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- meeting 데이터베이스 구조 내보내기
DROP DATABASE IF EXISTS `meeting`;
CREATE DATABASE IF NOT EXISTS `meeting` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `meeting`;

-- 테이블 meeting.tbl_assess 구조 내보내기
DROP TABLE IF EXISTS `tbl_assess`;
CREATE TABLE IF NOT EXISTS `tbl_assess` (
  `assessor_id` int(10) NOT NULL,
  `target_id` int(10) NOT NULL,
  `point` tinyint(4) NOT NULL DEFAULT '0',
  `comment` varchar(200) NOT NULL DEFAULT '',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`assessor_id`,`target_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='평가테이블';

-- 테이블 데이터 meeting.tbl_assess:~0 rows (대략적) 내보내기
DELETE FROM `tbl_assess`;
/*!40000 ALTER TABLE `tbl_assess` DISABLE KEYS */;
INSERT INTO `tbl_assess` (`assessor_id`, `target_id`, `point`, `comment`, `reg_date`) VALUES
	(1, 2, 100, '', '2016-12-27 14:11:05');
/*!40000 ALTER TABLE `tbl_assess` ENABLE KEYS */;

-- 테이블 meeting.tbl_code 구조 내보내기
DROP TABLE IF EXISTS `tbl_code`;
CREATE TABLE IF NOT EXISTS `tbl_code` (
  `code` varchar(10) NOT NULL,
  `id` varchar(4) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`code`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='코드성 데이터';

-- 테이블 데이터 meeting.tbl_code:~66 rows (대략적) 내보내기
DELETE FROM `tbl_code`;
/*!40000 ALTER TABLE `tbl_code` DISABLE KEYS */;
INSERT INTO `tbl_code` (`code`, `id`, `name`) VALUES
	('education', '10', '중졸'),
	('education', '20', '고졸'),
	('education', '30', '전문대졸'),
	('education', '40', '대졸'),
	('education', '50', '석사'),
	('education', '60', '박사'),
	('education', '99', '기타'),
	('hobby', '10', '등산'),
	('hobby', '11', '독서'),
	('hobby', '12', '음악감상'),
	('hobby', '13', '헬스'),
	('hobby', '14', '영화관람'),
	('hobby', '15', '스포츠'),
	('hobby', '16', '낚시'),
	('hobby', '17', '게임'),
	('hobby', '18', '산책'),
	('hobby', '19', '여행'),
	('hobby', '20', '십자수'),
	('hobby', '21', '사진'),
	('hobby', '22', '악기연주'),
	('hobby', '23', '봉사활동'),
	('hobby', '24', '자전거'),
	('job', '10', '사무직'),
	('job', '11', '프리랜서'),
	('job', '12', '학생'),
	('job', '13', '전문직'),
	('job', '14', '의료직'),
	('job', '15', '언론직'),
	('job', '16', '교육직'),
	('job', '17', '공무원'),
	('job', '18', '사업가'),
	('job', '19', '금융직'),
	('job', '20', '연구기술직'),
	('location', '10', '서울'),
	('location', '20', '강원'),
	('location', '30', '대전'),
	('location', '31', '충남'),
	('location', '33', '세종'),
	('location', '36', '충북'),
	('location', '40', '인천'),
	('location', '41', '경기'),
	('location', '50', '광주'),
	('location', '51', '전남'),
	('location', '56', '전북'),
	('location', '60', '부산'),
	('location', '62', '경남'),
	('location', '68', '울산'),
	('location', '69', '제주'),
	('location', '70', '대구'),
	('location', '71', '경북'),
	('location', '99', '해외'),
	('salary', '10', '2200'),
	('salary', '11', '2400'),
	('salary', '12', '2600'),
	('salary', '13', '2800'),
	('salary', '14', '3000'),
	('salary', '15', '3200'),
	('salary', '16', '3400'),
	('salary', '17', '3600'),
	('salary', '18', '3800'),
	('salary', '19', '4000'),
	('salary', '20', '4300'),
	('salary', '21', '4500'),
	('salary', '22', '5000'),
	('salary', '23', '5500'),
	('salary', '24', '6000');
/*!40000 ALTER TABLE `tbl_code` ENABLE KEYS */;

-- 테이블 meeting.tbl_good_feel 구조 내보내기
DROP TABLE IF EXISTS `tbl_good_feel`;
CREATE TABLE IF NOT EXISTS `tbl_good_feel` (
  `send_id` int(10) NOT NULL,
  `receive_id` int(10) NOT NULL,
  `status` enum('S','F','P') DEFAULT 'P',
  `reg_date` datetime DEFAULT NULL,
  `upd_date` datetime DEFAULT NULL,
  PRIMARY KEY (`send_id`,`receive_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='호감도';

-- 테이블 데이터 meeting.tbl_good_feel:~0 rows (대략적) 내보내기
DELETE FROM `tbl_good_feel`;
/*!40000 ALTER TABLE `tbl_good_feel` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_good_feel` ENABLE KEYS */;

-- 테이블 meeting.tbl_member 구조 내보내기
DROP TABLE IF EXISTS `tbl_member`;
CREATE TABLE IF NOT EXISTS `tbl_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `birth_year` varchar(4) NOT NULL DEFAULT '',
  `sex` enum('M','F') NOT NULL DEFAULT 'M',
  `location` varchar(4) NOT NULL DEFAULT '',
  `education` varchar(4) NOT NULL DEFAULT '',
  `job` varchar(4) NOT NULL DEFAULT '',
  `salary` varchar(4) NOT NULL DEFAULT '',
  `hobby` varchar(200) NOT NULL DEFAULT '',
  `cellphone` varchar(15) NOT NULL DEFAULT '',
  `admin_flag` char(1) NOT NULL DEFAULT '',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upd_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 meeting.tbl_member:~0 rows (대략적) 내보내기
DELETE FROM `tbl_member`;
/*!40000 ALTER TABLE `tbl_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_member` ENABLE KEYS */;

-- 테이블 meeting.tbl_member_weight 구조 내보내기
DROP TABLE IF EXISTS `tbl_member_weight`;
CREATE TABLE IF NOT EXISTS `tbl_member_weight` (
  `w_id` int(10) NOT NULL,
  `w_item` varchar(10) DEFAULT NULL,
  `w_point` int(11) DEFAULT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='회원별 가중치';

-- 테이블 데이터 meeting.tbl_member_weight:~0 rows (대략적) 내보내기
DELETE FROM `tbl_member_weight`;
/*!40000 ALTER TABLE `tbl_member_weight` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_member_weight` ENABLE KEYS */;

-- 테이블 meeting.tbl_popular 구조 내보내기
DROP TABLE IF EXISTS `tbl_popular`;
CREATE TABLE IF NOT EXISTS `tbl_popular` (
  `p_id` int(10) unsigned DEFAULT NULL,
  `p_point` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='인기도';

-- 테이블 데이터 meeting.tbl_popular:~0 rows (대략적) 내보내기
DELETE FROM `tbl_popular`;
/*!40000 ALTER TABLE `tbl_popular` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_popular` ENABLE KEYS */;

-- 테이블 meeting.tbl_weight 구조 내보내기
DROP TABLE IF EXISTS `tbl_weight`;
CREATE TABLE IF NOT EXISTS `tbl_weight` (
  `seq` int(10) NOT NULL AUTO_INCREMENT,
  `w_item` varchar(10) NOT NULL,
  `ranges` varchar(8) NOT NULL DEFAULT '',
  `point` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='가중치 기초테이블';

-- 테이블 데이터 meeting.tbl_weight:~63 rows (대략적) 내보내기
DELETE FROM `tbl_weight`;
/*!40000 ALTER TABLE `tbl_weight` DISABLE KEYS */;
INSERT INTO `tbl_weight` (`seq`, `w_item`, `ranges`, `point`) VALUES
	(1, 'age', '18', 10),
	(2, 'age', '19', 9),
	(3, 'age', '20', 8),
	(4, 'age', '21', 7),
	(5, 'age', '22', 6),
	(6, 'age', '23', 5),
	(9, 'age', '24', 4),
	(10, 'age', '26', 3),
	(11, 'age', '28', 2),
	(12, 'age', '30', 1),
	(13, 'age', '32', 0),
	(14, 'location', '서울', 10),
	(15, 'location', '강원', 3),
	(16, 'location', '대전', 7),
	(17, 'location', '충남', 4),
	(18, 'location', '세종', 6),
	(19, 'location', '충북', 10),
	(20, 'location', '인천', 8),
	(21, 'location', '경기', 8),
	(22, 'location', '광주', 10),
	(23, 'location', '전남', 5),
	(24, 'location', '전북', 4),
	(25, 'location', '부산', 9),
	(26, 'location', '경남', 3),
	(27, 'location', '울산', 1),
	(28, 'location', '제주', 6),
	(29, 'location', '대구', 6),
	(30, 'location', '경북', 2),
	(31, 'location', '해외', 10),
	(32, 'education', '중졸', 1),
	(33, 'education', '고졸', 2),
	(34, 'education', '전문대졸', 4),
	(35, 'education', '대졸', 6),
	(36, 'education', '석사', 8),
	(37, 'education', '박사', 10),
	(70, 'salary', '2200', 1),
	(71, 'salary', '2400', 2),
	(72, 'salary', '2600', 3),
	(73, 'salary', '2800', 4),
	(74, 'salary', '3000', 5),
	(75, 'salary', '3200', 6),
	(76, 'salary', '3400', 7),
	(77, 'salary', '3600', 8),
	(78, 'salary', '3800', 9),
	(79, 'salary', '4000', 10),
	(80, 'salary', '4300', 11),
	(81, 'salary', '4500', 12),
	(82, 'salary', '5000', 13),
	(83, 'salary', '5500', 14),
	(84, 'salary', '6000', 15),
	(85, 'job', '사무직', 5),
	(86, 'job', '프리랜서', 4),
	(87, 'job', '학생', 3),
	(88, 'job', '전문직', 8),
	(89, 'job', '의료직', 9),
	(90, 'job', '언론직', 7),
	(91, 'job', '교육직', 8),
	(92, 'job', '공무원', 10),
	(93, 'job', '사업가', 7),
	(94, 'job', '금융직', 8),
	(95, 'job', '연구기술직', 6),
	(96, 'salary', '0', 0),
	(97, 'age', '0', 0);
/*!40000 ALTER TABLE `tbl_weight` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
