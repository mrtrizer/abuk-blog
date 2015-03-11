-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               5.5.41-0ubuntu0.14.04.1 - (Ubuntu)
-- ОС Сервера:                   debian-linux-gnu
-- HeidiSQL Версия:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных blog
CREATE DATABASE IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `blog`;


-- Дамп структуры для таблица blog.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `name` char(50) NOT NULL,
  `file` char(50) DEFAULT NULL,
  `description` text,
  `descriptionRU` text,
  `priority` float DEFAULT '0.5',
  `changefreq` char(10) DEFAULT 'monthly',
  `last_change` char(10) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы blog.pages: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`name`, `file`, `description`, `descriptionRU`, `priority`, `changefreq`, `last_change`) VALUES
	('about', 'about.php', 'An information about ABUKSIGUN team.', 'Информация о команде ABUKSIGUN.', NULL, 'monthly', NULL),
	('article', 'article.php', '#article_description', '#article_description', NULL, 'monthly', NULL),
	('article_editor', 'article_editor.php', 'An article editor.', 'Редактор статей.', NULL, 'monthly', NULL),
	('article_list', 'article_list.php', 'Article list', 'Список статей.', NULL, 'monthly', NULL),
	('guest_book', 'guest_book.php', 'Tell to us, what are you thinking about our work?', 'Расскажите нам, что вы думаете о нашей работе?', NULL, 'monthly', NULL),
	('main', 'main.php', 'ABUKSIGUN team official blog. Here you can find many articles about IT and game developing.', 'Оффициальный блог команды ABUKSIGUN. Здесь вы можете найти множество статей на тему IT и разработки игр.', NULL, 'monthly', NULL);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
