-- --------------------------------------------------------
-- Хост:                         127.0.0.1
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


-- Дамп структуры для таблица blog.article
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `context` int(11) unsigned DEFAULT NULL,
  `name` char(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` bit(1) NOT NULL DEFAULT b'0',
  `about` text,
  `content` longtext,
  `image` char(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы blog.article: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` (`id`, `context`, `name`, `date`, `visible`, `about`, `content`, `image`) VALUES
	(1, 3, 'Wi-Fi ДГТУ', '2015-02-16 13:29:39', b'1', 'Статья о подключении к открытой точке доступа dstu в Донском Государственном Техническом Университете из дистрибутивов Linux с avahi из коробки.', '[center][img width=&quot;400px&quot;]http://1.bp.blogspot.com/-OcJPky_N8dM/VEuPJgzmK9I/AAAAAAAACGc/MAghQK9ixas/s1600/dstu_login.png[/img][/center]\n\n\nМногие знакомые сталкивались с проблемой невозможности подключиться к Wi-Fi в ДГТУ из некоторых дистрибутивов Linux. Вся проблема заключается в том, что один из сетевых демонов Ubuntu блокирует домен .local в процессе работы.\nДемоном, блокирующим .local является [b]avahi-deamon[/b], реализующий протокол Zeroconf, который в свою очередь позволяет подключаться к различным сервисам в локальной сети, без сложной настройки. Подробнее о Zeroconf, можно прочитать на википедии.\n\nИ так, для успешного прохождения авторизации на страничке входа в личный кабинет, достаточно отключить сервис avahi-deamon:\n[quote]\n$ sudo service avahi-daemon stop\n[/quote]\nПосле выполнения команды, вы можете повторить процедуру авторизации и при наличие подключения, все будет работать.\nЧто бы не вводить команду после каждой перезагрузки, можно убрать сервис с автозагрузки. Для запуска avahi-daemon используется Upstart, конфигурация которого находится тут:\n[quote]\n/etc/init\n[/quote]\nЧто бы отключить автозагрузку avahi-daemon, создайте файл [b]avahi-daemon.override[/b]\nsudo touch /etc/init/avahi-daemon.override\nИ запишите в него способ запуска службы &quot;manual&quot; (ручной)\n[quote]\n$sudo echo &quot;manual&quot; &gt;&gt; /etc/init/avahi-daemon.override\n[/quote]\nТеперь, avahi-deamon не будет нас беспокоить и мы сможем гулять по бескрайним просторам сети без проблем. ', 'http://www.festivalnauki.ru/sites/default/files/logo/logodstu_custom.jpg'),
	(2, 4, 'CentOS установка и настройка', '2015-02-16 13:30:37', b'1', 'Так как я не являюсь опытным администратором, а настраивать CentOS время от времени приходится, я написал для себя небольшую заметку, посвященную установке и настройке дистрибутива. К статье я периодически обращаюсь, потому она дополняется время от времени.\nПоследний раз я использовал эту статью в марте 2015 года на CentOS 7. Внес соответствующие поправки.', '[img width=200px]http://xaxatyxa.ru/wp-content/uploads/2012/07/centos.png[/img]\nУстанавливаю [b]CentOS minimal[/b]. Скачал с официального сайта последнюю версию и установил на VirtualBox. Весь процесс я проделывал под CentOS 5 и CentOS 6. Статью я дополняю по мере накопления опыта. Последние пункты были добавлены во время настройки CentOS на VPS.\n1. Сеть\nТут вариантов много, но наиболее привычные мне, два:\nПодключить виртуальную машину, как виртуальный адаптер и повесить на него proxy\nОставить дефолтный NAT, настроить проброс портов. Тут меньше всего проблем, если виртуалка не подведет. Но, способ неуниверсальный.\n\nОпишу способ с NAT, второй способ описан в статье про Raspberry Pi. Для проброса портов из гостевой системы на хост, жмем кнопку проброс портов в настройках сетевых адаптеров, дальше все интуитивно ясно.\n\n[quote]\n# ifconfig eth0 up\n[/quote]\nЕсли есть DHCP сервер, либо, как в моем случае - NAT на виртуалке, для получения настроек сети рубим:\n[quote]\n# dhclient eth0\n[/quote]\nДля автоматического запуска при старте нужно поправить файлик \n[quote]\n/etc/sysconfig/network-scripts/ifcfg-eth0\n[/quote]\nДля варианта с DHCP сервером, правим так:\n[quote]\nONBOOT=yes\nBOOTPROTO=dhcp\nЕсли хотите статический адрес для машины:\nDEVICE=eth0\nBOOTPROTO=static\nNM_CONTROLLED=yes\nONBOOT=yes\nTYPE=Ethernet\nIPADDR=&lt;адрес&gt;\nNETMASK=&lt;маска&gt;\nNETWORK=&lt;сеть (ip адрес, с примененной маской)&gt;\nBROADCAST=&lt;широковещательный адрес&gt;\nGATEWAY=&lt;шлюз&gt;\n[/quote]\nХорошая статья и пример тут.\n2. Обновление CentOS\nОбновление системы просто.\n[quote]\n# yum update\n[/quote]\nфлаг -y отвечает на все вопросы утвердительно\n3. Установка сервера Apache\n[quote]\n# yum install httpd\n[/quote]\nДля добавления сервиса в автозапуск можно воспользоваться утилитой chkconfig (chkconfig)\n[quote]\n# chkconfig httpd on\n[/quote]\nДля запуска\n[quote]\n# service httpd start\n[/quote]\nНастройки apache в /ect/httpd/conf/httpd.conf\n\n3. Установка PHP\n[quote]\n# yum install php\n[/quote]\nПерезапуск apache\n[quote]\n# service httpd restart\n[/quote]\nНастройки php в /etc/php.ini\nТеперь имеет смысл установить плагины\nMySQL:\n[quote]\n# yum install php-mysql\n[/quote]\nПоддержка кодировок (в том числе и Русских):\n[quote]\n # yum install php-mbstring\n[/quote]\n4. Установка MySQL или MariaDB\nВ связи с поглащением Sun компанией Oracle в 2009 и неопределенностями при лицензировании MySQL, в тот же год был сделан свободный форк популярной базы данных, который получил название MariaDB. Теперь, среди пакетов официального репозитория CentOS нет mysql-server. И на замену нам предлагают установить пакеты mariadb-server и mariadb. MariaDB полностью совместима с MySQL, а движек InnoDB заменяется на полностью совместимый XtraDB. (краткий пересказ википедии)\nУстановка [b]MariaDB[/b]:\n[quote]\n# yum install mariadb-server mariadb\n# chkconfig mariadb on\n# service mariadb start \n[/quote]\n[b]Обратите внимание.[/b] Похоже, в целях той же совместимости, исполняемый файл клиента MariaDB называется mysql.\nДля страстно желающих установить [b]MySQL[/b] нет никаких преград, просто добавьте воды:\n[quote]\n# rpm -Uvh http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm\n# yum install mysql-community-server mysql-community-client\n# chkconfig mysqld on\n# service mysqld start \n[/quote]\nИ живите [s]с этим[/s] как жили.\nТеперь следует запустить скрипт настроек. Он удалит тестовые базы данных и тестовых пользователей [s]и их тестовых детей[/s], а также предложит ввести новый пароль для root пользователя.\n[quote]\n/usr/bin/mysql_secure_installation\n[/quote]\n5. Добавление пользователей \nБуду добавлять пользователя ssh_user.\n[quote]\n# useradd ssh_user\n# passwd ssh_user\n[/quote]\nВам предложат ввести пароль для пользователя. Можно попробовать залогиниться:\n[quote]\n# su ssh_user\n[/quote]\nУстанавливаем sudo\n[quote]\n# yum install sudo\n[/quote]\nТеперь, надо настроить sudo. Можно воспользоваться visudo. \nВнимание! Если ранее, вы не сталкивались с редактором vim - настоятельно советую сделать так:\n[quote]\n# yum install nano\n# export EDITOR=nano\n[/quote]\nЭти команды установят интуитивно понятный редактор nano и установят переменную окружения EDITOR, делая тем самым nano, редактором по-умолчанию. Теперь при вызове visudo, запустится nano.\n[quote]\n# visudo\n[/quote]\nЕсли в процессе редактирования вы допустите ошибки, visudo спросит, что делать дальше. Отвечайте на вопрос: &quot;e&quot;. И редактирование продолжится.\nТеперь, добавляем в файл sudoers (в раздел User Aliases) такую строку :\n[quote]\nssh_user ALL = (root) ALL\n[/quote]\nНовоиспеченный пользователь сможет выполнять любые команды от лица root. Подробнее тут.\n6. Установка OpenSSH\nУстанавливать не надо, стоит из коробки.\nРабота с SSH описана в статье выше(или ниже).\n\n7. Установка средств сборки\nЕсли планируете собирать что-то из исходников, следует неприменимо установить набор средств для сборки. Для установки набора (make, gcc и т.д.), выполните команду:\n[quote]\n# yum groupinstall &quot;Developing Tools&quot;\n[/quote]\nДля cmake, boost, automake:\n[quote]\n# yum install cmake boost-devel automake\n[/quote]\nВажно! Не мне судить, баг это или фича, но выяснилось, что в дистрибутивах Red Hat каталог /usr/local/lib отсутствует в списке мест, где система ищет динамические библиотеки. Правится это в файле /etc/ld.so.conf. Просто добавьте строчку &quot;/usr/local/lib&quot; в этот файл и выполните команду:\n[quote]\n# sudo ldconfig\n[/quote]\nРазумеется, если вам удобно вы можете добавить в список  &quot;/etc/ld.so.conf&quot; любые другие пути. Подробнее об этом можно почитать тут.\n\n8. Установка и удаление rpm пакетов (для справки)\nУстановить пакет:\n[quote]\nrpm -Uvh &lt;путь к пакету&gt;\n[/quote]\nУдалить пакет:\n[quote]\nrpm -e &lt;имя пакета&gt;\n[/quote]\nПоказать список файлов пакета:\nrpm -ql &lt;имя пакета&gt;\n', 'https://lh3.googleusercontent.com/-czfmLmbcTis/AAAAAAAAAAI/AAAAAAAAABA/LR0WMlMJRQY/photo.jpg'),
	(3, 2, 'SSH', '2015-02-18 23:20:05', b'1', 'Статья о SSH. Задумано, что бы статья дала быстрый старт решившим разбираться с SSH доступом. Сам я впервые серьезно столкнулся с протоколом, когда ковырялся с Raspberry Pi. В дальнейшем эти знания мне пригодились, когда я решил перебраться в Web-программирование.', '[img width=&quot;200&quot;]http://upload.wikimedia.org/wikipedia/de/thumb/3/3d/SSH_Communications_Security_logo.svg/640px-SSH_Communications_Security_logo.svg.png[/img]\nПродолжаю разбираться с администрированием сервера. Т.к. я работал под Windows, а сервер работал под linux - эту конфигурацию я и буду описывать. Для подключения через OpenSSH из Unix систем, мало что отличается.\n\n[img width=&quot;750&quot;]http://localhost/blog/data/SSH.png[/img]\n\n[b]Подключение по паролю.[/b]\n\nПодключение к ssh из windows можно выполнить при помощи Putty. Без использования ключей. Просто вводим login password и профит.\n\nПередача файлов по ssh выполняется при помощи утилиты winscp. А под *nix, я пользуюсь популярным двухпанельным файловым менеджером mc. Запускем winscp, создаем новую сессию, выбираем способ подключения &quot;scp&quot;, вводим логин, пароль и подключаемся.\n\nПодключение с использование RSA аутентификации.\n\nМожно подключаться с использованием открытого/закрытого ключа для авторизации. Суть проста:\nУ сервера — файл с открытым ключем.\nУ клиента — файл с закрытым ключем.\nГенерация ключей\nГенерируются ключи вместе, либо на основе уже известного закрытого ключа и используются для авторизации. Для того что бы создать ключи можно воспользоваться утилитой из openSSH - ssh-keygen либо puttygen, из состава Putty. \n\nВАЖНО:\nФайлы ключей — текстовые файлы их форматы отличаются у Putty и OpenSSH . Возможны 2 варианта развития событий:\n\n1. Ключи созданы в Putty.\nЗапускаем puttygen, открываем ключи (либо генерируем). Копируем на сервер открытый ключ, (функции для его экспорта почему-то нет, что кажется мне нелогичным).\n\n2. Ключи созданы в ssh-keygen. \nОтдаем закрытый ключ клиенту, а клиент, если ему нужно, преобразует ключ из формата SSH в формат Putty при помощи puttygen (интуитивно понятный интерфейс).\n\nНастройка сервера\n1. Включаем поддержку ключей в конфигурационном файле (у меня /etc/ssh/sshd_config). \n[quote]\nRSAAuthentication yes\nPubkeyAuthentication yes\n[/quote]\nAuthorizedKeysFile ~/.ssh/authorized_keys #Может быть любой путь\n2. Нужно создать и заполнить сам файл authorized_keys.\n\nСей файл состоит из ключей записанных построчно (формат OpenSSH - весь ключ в одну строку). Т.е. если вы хотите разрешить логиниться с ключом, который вы создали в OpenSSH, просто дописываете открытый ключ с новой строки:\ncat rsa_key.pub &gt;&gt; ~/.ssh/authorized_keys\nИли, если ключ был cгенерирован в puttygen:\nssh_keygen -i -f rsa_key.pub &gt;&gt; ~/.ssh/authorized_keys\n\nТеперь, можно перезапустить сервис:\n[quote]\n$sudo services ssh restart\n[/quote]\nили\n/etc/init.d/sshd restart.\nНастройка клиента\nТут ничего хитрого. \nВ случае Putty - интуитивно понятный интерфейс. \nВ случае OpenSSH - команда:\nssh &lt;пользователь&gt;@&lt;адрес&gt; -p &lt;порт&gt; -i &lt;путь к закрытому ключу&gt;\nЕсли планируется запускать иксовые приложения, добавьте ключ -X.\n\nТеперь, когда у клиента закрытый ключ, а у сервера открытый, клиент может логиниться без пароля.\n\nВОЗМОЖНЫЕ ПРОБЛЕМЫ:\n1) Putty может не подключаться по rsa, если версии SSH и Putty не совместимы, потому советую качать самую свежую версию Putty при первых проблемах, что-бы отсечь этот вариант.', 'http://upload.wikimedia.org/wikipedia/de/thumb/3/3d/SSH_Communications_Security_logo.svg/640px-SSH_Communications_Security_logo.svg.png');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;


-- Дамп структуры для таблица blog.context
CREATE TABLE IF NOT EXISTS `context` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `list_size` int(10) unsigned DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы blog.context: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `context` DISABLE KEYS */;
INSERT INTO `context` (`id`, `list_size`) VALUES
	(1, 10),
	(2, 50),
	(3, 50),
	(4, 50);
/*!40000 ALTER TABLE `context` ENABLE KEYS */;


-- Дамп структуры для таблица blog.message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '0',
  `email` char(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `text` text NOT NULL,
  `context` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы blog.message: ~15 rows (приблизительно)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
INSERT INTO `message` (`id`, `name`, `email`, `date`, `text`, `context`) VALUES
	(28, 'test', 'test@test.ru', '2015-02-20 17:00:51', 'Test message', 1),
	(29, 'test', 'tset', '2015-02-20 17:06:15', 'test', 1),
	(30, 'test', 'tset', '2015-02-20 17:06:16', 'test', 1),
	(31, 'test', 'tset', '2015-02-20 17:06:17', 'test', 1),
	(32, 'test', 'tset', '2015-02-20 17:06:18', 'test', 1),
	(33, 'fasd', 'fasdf', '2015-02-20 17:18:59', 'fasdf', 1),
	(34, 'sdf', 'sdf', '2015-02-20 17:23:05', 'fasd', 1),
	(35, 'test', 'test', '2015-02-20 19:40:21', 'test', 3),
	(36, 'test', 'test', '2015-02-20 19:40:25', 'test', 3),
	(37, 'test', 'test', '2015-02-20 19:40:28', 'test1', 3),
	(38, 'test', 'test', '2015-02-20 19:40:33', 'test2', 3),
	(39, 'test', 'test@test.ru', '2015-02-20 20:02:57', 'test', 4),
	(40, 'test', 'test@test.ru', '2015-02-20 20:03:02', 'test1', 4),
	(41, 'test', 'test@test.ru', '2015-02-20 20:03:05', 'test2', 4),
	(42, 'Android', 'android@a.com', '2015-02-20 22:20:48', 'Mobile test! ', 1);
/*!40000 ALTER TABLE `message` ENABLE KEYS */;


-- Дамп структуры для таблица blog.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` char(20) NOT NULL,
  `pass_hash` binary(16) NOT NULL,
  `key` binary(16) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `name` char(50) DEFAULT NULL,
  `rights` char(15) DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы blog.user: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `pass_hash`, `key`, `email`, `name`, `rights`) VALUES
	('admin', _binary 0x94DA29D9E5E84C7C54196F3DA4E2614B, _binary 0x1D9DD681ED10CC1C1506DB24B75CBCBE, 'mrtrizer@gmail.com', 'Zdorovtsov Denis', 'admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
