-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 192.168.10.10    Database: molfar
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `priceable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceable_id` bigint(20) unsigned NOT NULL,
  `price` decimal(13,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_priceable_type_priceable_id_index` (`priceable_type`,`priceable_id`),
  KEY `bill_order_id_foreign` (`order_id`),
  CONSTRAINT `bill_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `callback`
--

DROP TABLE IF EXISTS `callback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `callback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('NEW','PROCESSED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `callback`
--

LOCK TABLES `callback` WRITE;
/*!40000 ALTER TABLE `callback` DISABLE KEYS */;
/*!40000 ALTER TABLE `callback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_number` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cards_card_number_unique` (`card_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,'Сенькив Владимир','4149499104347842',NULL,1,1,NULL,NULL,'2018-06-25 12:26:28','2018-07-15 14:29:06'),(2,'Николай Дендро','4444333322221111',NULL,1,1,1,'2018-07-15 14:27:48','2018-06-25 12:28:38','2018-07-15 14:27:48'),(3,'Мария Ерик','1122334455667788',NULL,1,1,1,'2018-07-15 14:27:48','2018-06-25 12:29:30','2018-07-15 14:27:48');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_rows`
--

DROP TABLE IF EXISTS `data_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_rows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_type_id` int(10) unsigned NOT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `data_rows_data_type_id_foreign` (`data_type_id`),
  CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_rows`
--

LOCK TABLES `data_rows` WRITE;
/*!40000 ALTER TABLE `data_rows` DISABLE KEYS */;
INSERT INTO `data_rows` VALUES (1,1,'id','number','ID',1,0,0,0,0,0,'',1),(2,1,'name','text','Name',1,1,1,1,1,1,'',2),(3,1,'email','text','Email',1,1,1,1,1,1,'',3),(4,1,'password','password','Password',1,0,0,1,1,0,'',4),(5,1,'remember_token','text','Remember Token',0,0,0,0,0,0,'',5),(6,1,'created_at','timestamp','Created At',0,1,1,0,0,0,'',6),(7,1,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',7),(8,1,'avatar','image','Avatar',0,1,1,1,1,1,'',8),(9,1,'user_belongsto_role_relationship','relationship','Role',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\"}',10),(10,1,'user_belongstomany_role_relationship','relationship','Roles',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}',11),(11,1,'locale','text','Locale',0,1,1,1,1,0,'',12),(12,1,'settings','hidden','Settings',0,0,0,0,0,0,'',12),(13,2,'id','number','ID',1,0,0,0,0,0,'',1),(14,2,'name','text','Name',1,1,1,1,1,1,'',2),(15,2,'created_at','timestamp','Created At',0,0,0,0,0,0,'',3),(16,2,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',4),(17,3,'id','number','ID',1,0,0,0,0,0,'',1),(18,3,'name','text','Name',1,1,1,1,1,1,'',2),(19,3,'created_at','timestamp','Created At',0,0,0,0,0,0,'',3),(20,3,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',4),(21,3,'display_name','text','Display Name',1,1,1,1,1,1,'',5),(22,1,'role_id','text','Role',1,1,1,1,1,1,'',9),(23,4,'id','text','Id',1,0,0,0,0,0,NULL,1),(24,4,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:events|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',4),(25,4,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',2),(26,4,'date_from','date','Дата начала',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}}}',5),(27,4,'date_to','date','Дата окончания',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}}}',6),(28,4,'place','text','Место проведения',0,1,1,1,1,1,NULL,7),(29,4,'created_at','timestamp','Создано',0,0,0,1,0,1,'{\"format\":\"%d.%m.%Y\"}',8),(30,4,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,9),(31,5,'id','text','Id',1,0,0,0,0,0,NULL,1),(32,5,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:speakers|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',4),(33,5,'name','text','Имя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите имя\"}}}',3),(34,5,'image','image','Фото',0,1,1,1,1,1,NULL,2),(35,5,'summary','text_area','Резюме',0,0,1,1,1,1,NULL,5),(36,5,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(37,5,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(38,7,'id','text','Id',1,0,0,0,0,0,NULL,1),(39,7,'speaker_id','hidden','Speaker Id',1,0,0,1,1,1,NULL,2),(40,7,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"FACEBOOK\",\"options\":{\"FACEBOOK\":\"Facebook\",\"INSTAGRAM\":\"Instagram\",\"WEBSITE\":\"Веб-сайт\"}}',4),(41,7,'value','text','Ссылка',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите ссылку\"}}}',5),(42,7,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(43,7,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(44,7,'speakers_contact_belongsto_data_row_relationship','relationship','Спикер',0,1,1,1,1,1,'{\"model\":\"App\\\\Speaker\",\"table\":\"speakers\",\"type\":\"belongsTo\",\"column\":\"speaker_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(45,8,'id','text','Id',1,0,0,0,0,0,NULL,1),(46,8,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:speeches|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',5),(47,8,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',4),(48,8,'preview','text_area','Краткий обзор',0,1,1,1,1,1,NULL,6),(49,8,'speaker_id','hidden','Speaker Id',1,0,0,1,1,1,NULL,2),(50,8,'content','rich_text_box','Содержание',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите содержимое доклада\"}}}',7),(51,8,'created_at','timestamp','Создан',0,0,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',8),(52,8,'updated_at','timestamp','Изменен',0,0,1,1,0,0,'{\"format\":\"%d.%m.%Y\"}',9),(53,8,'speech_belongsto_speaker_relationship','relationship','Спикер',0,1,1,1,1,1,'{\"model\":\"App\\\\Speaker\",\"table\":\"speakers\",\"type\":\"belongsTo\",\"column\":\"speaker_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(54,4,'event_belongstomany_speech_relationship','relationship','Доклады',0,0,1,1,1,1,'{\"model\":\"App\\\\Speech\",\"table\":\"speeches\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"event_speeches\",\"pivot\":\"1\",\"taggable\":\"on\"}',3),(55,9,'id','text','Id',1,0,0,0,0,0,NULL,1),(56,9,'name','text','Имя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите имя\"}}}',2),(57,9,'image','image','Изображение',1,1,1,1,1,1,NULL,3),(58,9,'link','text','Ссылка',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите ссылку\"}}}',4),(59,10,'id','text','Id',1,0,0,0,0,0,NULL,1),(60,10,'slug','text','Ссылка',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"unique:tickets|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',8),(61,10,'event_id','hidden','Event Id',1,0,0,1,1,1,NULL,3),(62,10,'flow','text','Поток',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',5),(63,10,'price','number','Цена',0,1,1,1,1,1,NULL,6),(64,10,'qty','number','Количество',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите количество билетов\"}}}',7),(65,10,'created_by','hidden','Кем создано',1,0,0,0,0,1,NULL,9),(66,10,'updated_by','hidden','Кем отредактировано',0,0,0,0,0,1,NULL,10),(67,10,'deleted_by','hidden','Кем удалено',0,0,0,0,0,1,NULL,11),(68,10,'deleted_at','timestamp','Когда удалено',0,0,0,0,0,1,'{\"format\":\"%d.%m.%Y\"}',12),(69,10,'created_at','timestamp','Когда создано',0,0,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',13),(70,10,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{\"format\":\"%d.%m.%Y\"}',14),(71,10,'ticket_belongsto_event_relationship','relationship','Событие',0,1,1,1,1,1,'{\"model\":\"App\\\\Event\",\"table\":\"events\",\"type\":\"belongsTo\",\"column\":\"event_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',4),(72,11,'id','text','Id',1,0,0,0,0,0,NULL,1),(73,11,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',3),(74,11,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"INCLUSIVE\",\"options\":{\"ACCOMMODATION\":\"Проживание\",\"FOOD\":\"Питание\",\"INCLUSIVE\":\"Включено\"}}',2),(75,11,'price','number','Цена',0,1,1,1,1,1,NULL,4),(76,11,'qty','number','Количество',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required|numeric|min:0|max:65535\"},\"description\":\"Сколько единиц доступно для заказа\"}',5),(77,11,'created_by','text','Кем создано',1,0,0,0,0,1,NULL,6),(78,11,'updated_by','text','Кем отредактировано',0,0,0,0,0,1,NULL,7),(79,11,'deleted_by','text','Кем удалено',0,0,0,0,0,1,NULL,8),(80,11,'deleted_at','timestamp','Когда удалено',0,0,0,0,0,1,NULL,9),(81,11,'created_at','timestamp','Когда создано',0,0,0,0,0,1,NULL,10),(82,11,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(83,12,'id','text','Id',1,0,0,0,0,0,NULL,1),(84,12,'name','text','Название',1,1,1,1,1,1,NULL,3),(85,12,'is_available','checkbox','Отображение',1,1,1,1,1,1,'{\"on\":\"Показать\",\"off\":\"Скрыть\",\"checked\":\"true\"}',2),(86,12,'description','text_area','Описание',0,0,1,1,1,1,NULL,6),(87,12,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"PERCENT\",\"options\":{\"PERCENT\":\"Процент\",\"FLAT\":\"Сумма\",\"FIXED\":\"Фиксированная цена\"}}',4),(88,12,'value','number','Скидка',1,1,1,1,1,1,NULL,5),(89,12,'check_on','select_dropdown','Применить к',1,1,1,1,1,1,'{\"default\":\"CASH\",\"options\":{\"CASH\":\"Наличные\",\"INSTALLMENTS\":\"Рассрочка\",\"BOTH\":\"Везде\"}}',7),(90,12,'created_by','text','Кем создано',1,0,1,1,0,1,NULL,8),(91,12,'updated_by','text','Кем отредактировано',0,0,1,1,0,1,NULL,9),(92,12,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,10),(93,12,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,11),(94,12,'created_at','timestamp','Кем создано',0,0,0,1,0,1,NULL,12),(95,12,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,13),(96,13,'id','text','Id',1,0,0,0,0,0,NULL,1),(97,13,'name','text','Название',1,1,1,1,1,1,NULL,2),(98,13,'commission','number','Комиссия',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|regex:/^\\\\d*(\\\\.\\\\d{2})?$/\",\"messages\":{\"required\":\"Введите комиссию\",\"regex\":\"Значение от 0 до 100\"}},\"description\":\"Значение в %\"}',3),(99,13,'deadline','number','Число выплаты',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите число месяца\"}},\"description\":\"Число месяца для погашения рассрочки\"}',4),(100,13,'expires_at','date','Дата окончания рассрочки',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}},\"description\":\"Дата до которой нужно выплатить\"}',5),(101,13,'description','text_area','Описание',0,0,1,1,1,1,NULL,6),(102,13,'created_by','text','Кем создано',1,0,0,0,0,1,NULL,7),(103,13,'updated_by','text','Кем отредактировано',0,0,0,0,0,1,NULL,8),(104,13,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,9),(105,13,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,10),(106,13,'created_at','timestamp','Когда создано',0,0,0,0,0,1,NULL,11),(107,13,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,12),(108,14,'id','number','Заказ',1,1,1,1,1,0,NULL,2),(109,14,'status','select_dropdown','Статус',1,1,1,1,0,1,'{\"default\":\"NEW\",\"options\":{\"NEW\":\"Новый\",\"CONFIRMED\":\"Подтверждён\",\"PAID\":\"Оплачен\",\"RESERVED\":\"Зарезервирован\",\"CANCELED\":\"Отменен\"}}',1),(110,14,'ticket_id','number','Билет',1,1,1,0,0,1,NULL,7),(111,14,'total_price','number','Полная стоимость',1,1,1,0,0,1,NULL,5),(112,14,'payment_type','select_dropdown','Тип оплаты',1,0,1,1,0,1,'{\"default\":\"CASH\",\"options\":{\"CASH\":\"Наличные\",\"INSTALLMENTS\":\"Рассрочка\"}}',6),(113,14,'name','text','Имя',1,0,1,1,0,1,NULL,3),(114,14,'email','text','E-mail',0,0,1,1,0,1,'{\"validation\":{\"rule\":\"email\",\"messages\":{\"email\":\"E-mail неверный\"}}}',8),(115,14,'phone','number','Телефон',1,0,1,1,0,1,'{\"validation\":{\"rule\":\"required|min:3|max:13|phone:AUTO,UA\",\"messages\":{\"required\":\"Введите телефон\",\"min\":\"От 3 цифр\",\"max\":\"Не больше 13 цифр\",\"phone\":\"Неверный номер\"}},\"description\":\"Формат номера 380112222222\"}',4),(116,14,'city','text','Город',0,0,1,1,0,1,NULL,9),(117,14,'comment','text_area','Комментарий',0,0,1,0,0,1,NULL,13),(118,14,'notation','text_area','Заметка',0,0,1,1,0,1,NULL,14),(119,14,'created_by','text','Кем создано',1,0,1,0,0,1,NULL,15),(120,14,'updated_by','text','Кем отредактировано',0,0,1,0,0,1,NULL,16),(121,14,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,17),(122,14,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,18),(123,14,'created_at','timestamp','Дата',0,1,1,0,0,1,'{\"format\":\"%d.%m.%Y %H:%M:%S\"}',12),(124,14,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,19),(126,15,'id','text','Id',1,0,0,0,0,0,NULL,0),(127,15,'order_id','hidden','Order Id',1,0,0,1,1,1,NULL,2),(128,15,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"OPTION\",\"options\":{\"DISCOUNT\":\"Скидка\",\"OPTION\":\"Опция\",\"EARLY_BIRD\":\"Ранние пташки\"}}',4),(129,15,'value','hidden','Значение',1,0,0,1,1,1,NULL,5),(130,15,'price','number','Цена',1,1,1,1,1,1,NULL,6),(131,15,'price_breakdown_belongsto_order_relationship','relationship','Заказ',0,1,1,1,1,1,'{\"model\":\"App\\\\Order\",\"table\":\"orders\",\"type\":\"belongsTo\",\"column\":\"order_id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(132,16,'id','text','№ платежа',1,1,1,1,1,0,NULL,0),(133,16,'order_id','hidden','Order Id',1,0,0,1,1,1,NULL,2),(134,16,'amount','number','Сумма',1,1,1,1,1,1,NULL,4),(135,16,'notice','text_area','Заметка',0,1,1,1,1,1,NULL,5),(136,16,'created_by','text','Кем создано',1,0,1,1,0,1,NULL,6),(137,16,'updated_by','text','Кем отредактировано',0,0,1,1,0,1,NULL,7),(138,16,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,8),(139,16,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,9),(140,16,'created_at','timestamp','Создано',0,1,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',10),(141,16,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(142,16,'payment_belongsto_order_relationship','relationship','Заказ',0,1,1,1,1,1,'{\"model\":\"App\\\\Order\",\"table\":\"orders\",\"type\":\"belongsTo\",\"column\":\"order_id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(144,10,'ticket_belongsto_user_relationship_1','relationship','Изменено',0,1,1,0,0,1,'{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"updated_by\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',16),(146,10,'ticket_belongstomany_installment_relationship','relationship','Рассрочка',0,0,1,1,1,1,'{\"model\":\"App\\\\Installment\",\"table\":\"installments\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"ticket_installments\",\"pivot\":\"1\",\"taggable\":\"0\"}',18),(147,13,'closed_at','date','Дата закрытия',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}},\"description\":\"Дата закрытия возможности рассрочки\"}',5),(148,17,'id','text','Id',1,0,0,0,0,0,NULL,1),(149,17,'name','text','Имя держателя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Укажите имя держателя карты\"}}}',2),(150,17,'card_number','number','Номер карты',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|size:16|unique:cards,card_number\",\"messages\":{\"size\":\"Введите :size цифр\",\"required\":\"Укажите номер карты\",\"unique\":\"Эта карта уже есть\"}}}',3),(151,17,'note','text_area','Заметка',0,0,1,1,1,1,NULL,4),(152,17,'created_by','text','Created By',1,0,0,0,0,1,NULL,5),(153,17,'updated_by','text','Updated By',0,0,0,0,0,1,NULL,6),(154,17,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,7),(155,17,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,8),(156,17,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,9),(157,17,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,10),(158,10,'ticket_belongstomany_card_relationship','relationship','Карты для выплат',0,0,1,1,1,1,'{\"model\":\"App\\\\Card\",\"table\":\"cards\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"ticket_cards\",\"pivot\":\"1\",\"taggable\":\"0\"}',19),(159,18,'id','text','Id',1,0,0,0,0,0,NULL,1),(160,18,'name','text','Имя',1,1,1,1,1,1,NULL,2),(161,18,'code','text','Код продавца',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|max:60|regex:/^[a-zA-Z0-9-]+$/u|unique:sellers,code\",\"messages\":{\"required\":\"Введите код продавца\",\"max\":\"Максимальное количество символов :max.\",\"unique\":\"Этот код уже существуеТ\",\"regex\":\"Допустимые символы: A-z, a-z, 0-9, _\"}}}',3),(162,18,'user_id','hidden','User Id',0,1,1,1,1,1,'{\"null\":\"Не задано\"}',4),(163,18,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,5),(164,18,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,6),(165,18,'seller_belongsto_user_relationship','relationship','Пользователь',0,1,1,1,1,1,'{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(166,19,'id','text','Id',1,0,0,0,0,0,NULL,1),(167,19,'code','text','Код',1,1,1,1,1,1,NULL,4),(168,19,'seller_id','hidden','Seller Id',1,0,0,1,1,1,NULL,2),(169,19,'note','text_area','Заметка',0,1,1,1,1,1,NULL,5),(170,19,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(171,19,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(172,19,'promo_code_belongsto_seller_relationship','relationship','Продавец',0,1,1,1,1,1,'{\"model\":\"App\\\\Seller\",\"table\":\"sellers\",\"type\":\"belongsTo\",\"column\":\"seller_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(174,14,'seller_id','number','Продавец',0,0,1,1,0,1,NULL,10),(175,14,'promocode','text','Промокод / Продавец',0,1,1,0,0,1,NULL,11),(177,14,'card_id','number','Карта оплаты',0,0,1,0,0,1,NULL,10),(178,13,'first_part','hidden','Первая часть',0,0,0,1,1,1,NULL,3),(179,14,'installment_id','number','Installment Id',0,0,0,1,0,1,NULL,10),(180,20,'id','text','Id',1,0,0,0,0,0,NULL,0),(181,20,'order_id','hidden','Order Id',1,1,1,1,1,1,NULL,2),(182,20,'priceable_type','text','Тип опции',1,1,1,1,1,1,NULL,3),(183,20,'priceable_id','text','Опция',1,1,1,1,1,1,NULL,4),(184,20,'price','text','Цена',1,1,1,1,1,1,NULL,5),(185,21,'id','text','Id',1,0,0,0,0,0,NULL,1),(186,21,'user_id','text','User Id',1,1,1,1,1,1,NULL,2),(187,21,'setting_id','text','Setting Id',1,1,1,1,1,1,NULL,3),(188,21,'value','text','Value',1,1,1,1,1,1,NULL,4),(189,21,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,5),(190,21,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,6),(191,22,'id','text','Id',1,0,0,0,0,0,NULL,1),(192,22,'ticket_id','hidden','Ticket Id',1,0,0,1,1,1,NULL,3),(193,22,'date_from','date','Дата начала',1,1,1,1,1,1,NULL,4),(194,22,'date_to','date','Дата окончания',1,1,1,1,1,1,NULL,5),(195,22,'price','number','Цена',1,1,1,1,1,1,NULL,6),(196,22,'created_by','hidden','Кем создано',1,0,0,0,0,1,NULL,7),(197,22,'updated_by','hidden','Updated By',0,0,0,0,0,1,NULL,8),(198,22,'deleted_by','hidden','Deleted By',0,0,0,0,0,1,NULL,9),(199,22,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,10),(200,22,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,11),(201,22,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,12),(202,13,'first_payment','number','Нулевой платеж',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите стоимость нулевого платежа\"}},\"description\":\"Нулевой платеж для внесения в течении 5 дней\"}',4),(203,22,'early_bird_belongsto_ticket_relationship','relationship','Билет',0,1,1,1,1,1,'{\"model\":\"App\\\\Ticket\",\"table\":\"tickets\",\"type\":\"belongsTo\",\"column\":\"ticket_id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',2),(204,10,'is_available','checkbox','Наличие билета',1,1,1,1,1,1,'{\"on\":\"В продаже\",\"off\":\"Недоступен\",\"checked\":\"true\"}',2),(205,10,'ticket_belongstomany_discount_relationship','relationship','Скидки',0,0,1,1,1,1,'{\"model\":\"App\\\\Discount\",\"table\":\"discounts\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"ticket_discounts\",\"pivot\":\"1\",\"taggable\":\"0\"}',20),(206,24,'ticket_id','hidden','Ticket Id',1,0,0,1,1,1,NULL,1),(207,24,'option_id','hidden','Опция',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\"}}',2),(208,24,'group','select_dropdown','Группа',0,0,1,1,1,1,'{\"default\":\"\",\"options\":{\"1\":\"Группа 1\",\"2\":\"Группа 2\",\"3\":\"Группа 3\",\"4\":\"Группа 4\",\"5\":\"Группа 5\",\"\":\"Без группы\"}}',4),(210,24,'ticket_option_belongsto_option_relationship','relationship','Опция',0,1,1,1,1,1,'{\"model\":\"App\\\\Option\",\"table\":\"options\",\"type\":\"belongsTo\",\"column\":\"option_id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(211,10,'order','hidden','Order',1,0,0,1,1,1,NULL,8),(212,25,'id','number','№',1,0,0,0,0,0,NULL,1),(213,25,'status','select_dropdown','Статус',1,1,1,1,0,1,'{\"default\":\"NEW\",\"options\":{\"PROCESSED\":\"Обработано\",\"NEW\":\"Новый\"}}',2),(214,25,'name','text','Имя',1,1,1,0,0,1,NULL,3),(215,25,'phone','text','Телефон',1,0,1,0,0,1,NULL,4),(216,25,'email','text','E-mail',1,0,1,0,0,1,NULL,5),(217,25,'question','text_area','Вопрос',0,1,1,0,0,1,NULL,6),(218,25,'note','rich_text_box','Заметка',0,0,1,1,0,1,NULL,7),(219,25,'created_at','timestamp','Создано',0,1,1,0,0,1,'{\"format\":\"%d %b\"}',8),(220,25,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,9),(221,14,'number','text','№ Заказа',1,0,1,1,1,1,NULL,2);
/*!40000 ALTER TABLE `data_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_types`
--

DROP TABLE IF EXISTS `data_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint(4) NOT NULL DEFAULT '0',
  `details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `data_types_name_unique` (`name`),
  UNIQUE KEY `data_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,'users','users','User','Users','voyager-person','TCG\\Voyager\\Models\\User','TCG\\Voyager\\Policies\\UserPolicy','','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(2,'menus','menus','Menu','Menus','voyager-list','TCG\\Voyager\\Models\\Menu',NULL,'','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(3,'roles','roles','Role','Roles','voyager-lock','TCG\\Voyager\\Models\\Role',NULL,'','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(4,'events','events','Событие','События','voyager-calendar','App\\Event',NULL,NULL,'События',1,1,'{\"order_column\":null,\"order_display_column\":null}','2018-06-04 20:22:50','2018-06-04 20:22:50'),(5,'speakers','speakers','Спикер','Спикеры','voyager-megaphone','App\\Speaker',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 09:49:59','2018-06-05 09:49:59'),(7,'speakers_contacts','speakers-contacts','Контакт','Контакты спикеров','voyager-list','App\\SpeakerContact',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 10:27:25','2018-06-05 10:27:25'),(8,'speeches','speeches','Доклад','Доклады','voyager-file-text','App\\Speech',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 10:51:30','2018-06-05 10:51:30'),(9,'partners','partners','Партнер','Партнеры','voyager-person','App\\Partner',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 13:07:01','2018-06-05 13:07:01'),(10,'tickets','tickets','Билет','Билеты','voyager-ticket','App\\Ticket',NULL,NULL,NULL,1,0,'{\"order_column\":\"order\",\"order_display_column\":\"flow\"}','2018-06-05 14:51:11','2018-07-14 18:53:15'),(11,'options','options','Опция','Опции билета','voyager-beer','App\\Option',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 15:25:44','2018-06-20 09:21:42'),(12,'discounts','discounts','Скидка','Скидки','voyager-pie-chart','App\\Discount',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 15:52:18','2018-06-05 15:52:18'),(13,'installments','installments','Рассрочка','Рассрочка','voyager-scissors','App\\Installment',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 16:07:40','2018-06-05 16:07:40'),(14,'orders','orders','Заказ','Заказы','voyager-documentation','App\\Order',NULL,'\\App\\Http\\Controllers\\Voyager\\OrderController',NULL,1,1,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 19:18:51','2018-06-22 11:39:25'),(15,'price_breakdowns','price-breakdowns','Составляющие цены','Составляющие цены','voyager-puzzle','App\\PriceBreakdown',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 19:32:20','2018-06-05 19:32:20'),(16,'payments','payments','Платеж','Платежи','voyager-dollar','App\\Payment',NULL,'\\App\\Http\\Controllers\\Voyager\\PaymentController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 21:00:06','2018-06-28 16:00:23'),(17,'cards','cards','Банковская карта','Банковские карты','voyager-credit-cards','App\\Card',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 09:39:55','2018-06-25 09:39:55'),(18,'sellers','sellers','Продавец','Продавцы','voyager-shop','App\\Seller',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 10:35:14','2018-06-25 10:35:14'),(19,'promo_codes','promo-codes','Промокод','Промокоды','voyager-paperclip','App\\PromoCode',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 10:47:03','2018-06-25 10:47:03'),(20,'bills','bills','Счет','Счета','voyager-bag','App\\Bill',NULL,'\\App\\Http\\Controllers\\Voyager\\BillController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-28 13:38:22','2018-06-28 15:59:51'),(21,'user_settings','user-settings','Настройка','Мои настройки','voyager-params','App\\UserSetting',NULL,'\\App\\Http\\Controllers\\Voyager\\UserSettingsController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-03 16:13:53','2018-07-03 16:19:51'),(22,'early_birds','early-birds','Ранняя пташка','Ранние пташки','voyager-twitter','App\\EarlyBird',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-05 12:53:20','2018-07-05 12:53:20'),(24,'ticket_options','ticket-options','Опция','Опции билета',NULL,'App\\TicketOption',NULL,'\\App\\Http\\Controllers\\Voyager\\TicketOptionController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-06 07:50:30','2018-07-06 10:36:11'),(25,'callback','callback','Обратная связь','Обратная связь','voyager-telephone','App\\Callback',NULL,'\\App\\Http\\Controllers\\Voyager\\CallbackController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-19 20:39:11','2018-07-20 10:10:56');
/*!40000 ALTER TABLE `data_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('PERCENT','FLAT','FIXED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PERCENT',
  `value` decimal(13,2) NOT NULL,
  `check_on` enum('CASH','INSTALLMENTS','BOTH') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CASH',
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
INSERT INTO `discounts` VALUES (1,'Скидка 10%',1,'','PERCENT',10.00,'CASH',1,1,NULL,NULL,'2018-06-20 08:46:40','2018-06-20 08:46:40'),(2,'Скидка -5 ₴',1,'','FLAT',5.00,'CASH',1,1,NULL,NULL,'2018-06-20 08:48:03','2018-06-20 08:48:03'),(3,'Фикс цена 24 ₴',1,'','FIXED',24.00,'CASH',1,1,NULL,NULL,'2018-06-20 08:50:40','2018-06-20 08:50:40');
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `early_birds`
--

DROP TABLE IF EXISTS `early_birds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `early_birds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_id` int(10) unsigned NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `price` decimal(13,2) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `early_birds_ticket_id_foreign` (`ticket_id`),
  CONSTRAINT `early_birds_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `early_birds`
--

LOCK TABLES `early_birds` WRITE;
/*!40000 ALTER TABLE `early_birds` DISABLE KEYS */;
INSERT INTO `early_birds` VALUES (5,1,'2018-07-01 00:00:00','2019-01-01 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-07-15 18:26:29'),(6,2,'2018-07-01 00:00:00','2019-01-01 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-07-15 18:26:29'),(7,3,'2018-07-01 00:00:00','2019-01-01 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-07-15 18:26:29'),(8,4,'2018-07-01 00:00:00','2019-01-01 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-07-15 18:26:29'),(9,5,'2018-07-01 00:00:00','2019-01-01 00:00:00',10000.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-07-15 18:26:29');
/*!40000 ALTER TABLE `early_birds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_speeches`
--

DROP TABLE IF EXISTS `event_speeches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_speeches` (
  `event_id` int(10) unsigned NOT NULL,
  `speech_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`event_id`,`speech_id`),
  KEY `event_speeches_speech_id_foreign` (`speech_id`),
  CONSTRAINT `event_speeches_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_speeches_speech_id_foreign` FOREIGN KEY (`speech_id`) REFERENCES `speeches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_speeches`
--

LOCK TABLES `event_speeches` WRITE;
/*!40000 ALTER TABLE `event_speeches` DISABLE KEYS */;
INSERT INTO `event_speeches` VALUES (1,3);
/*!40000 ALTER TABLE `event_speeches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'molfar-forum-2019','Molfar Beauty Forum ‘19','2019-05-12 00:00:00','2019-05-16 00:00:00','Буковель','2018-06-04 20:36:00','2018-07-25 18:57:23'),(3,'testovoe-sobytie','Тестовое событие','2018-07-18 00:00:00','2018-07-27 00:00:00','','2018-07-25 11:57:04','2018-07-25 11:57:04');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installments`
--

DROP TABLE IF EXISTS `installments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `installments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_part` decimal(5,2) unsigned DEFAULT '0.00',
  `first_payment` decimal(13,2) NOT NULL DEFAULT '0.00',
  `commission` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `deadline` tinyint(3) unsigned NOT NULL DEFAULT '7',
  `closed_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installments`
--

LOCK TABLES `installments` WRITE;
/*!40000 ALTER TABLE `installments` DISABLE KEYS */;
INSERT INTO `installments` VALUES (1,'Рассрочка до апреля',0.00,1500.00,10.00,5,'2019-01-01 00:00:00','2019-04-05 00:00:00','',1,1,NULL,NULL,'2018-07-12 11:41:06','2018-07-15 18:21:04');
/*!40000 ALTER TABLE `installments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `menu_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,1,'Панель управления','','_self','voyager-boat','#000000',NULL,1,'2018-05-19 17:46:11','2018-06-21 12:25:07','voyager.dashboard','null'),(2,1,'Галерея','','_self','voyager-images','#000000',5,1,'2018-05-19 17:46:11','2018-06-04 20:06:11','voyager.media.index','null'),(3,1,'Пользователи','','_self','voyager-person','#000000',5,2,'2018-05-19 17:46:11','2018-06-04 20:06:11','voyager.users.index','null'),(4,1,'Роли','','_self','voyager-lock','#000000',5,3,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.roles.index','null'),(5,1,'Инструменты','','_self','voyager-tools','#000000',NULL,11,'2018-05-19 17:46:12','2018-07-12 09:58:41',NULL,''),(6,1,'Меню','','_self','voyager-list','#000000',5,4,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.menus.index','null'),(7,1,'База данных','','_self','voyager-data','#000000',5,5,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.database.index','null'),(8,1,'Compass','','_self','voyager-compass',NULL,5,6,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.compass.index',NULL),(9,1,'BREAD','','_self','voyager-bread',NULL,5,7,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.bread.index',NULL),(10,1,'Настройки','','_self','voyager-settings','#000000',NULL,12,'2018-05-19 17:46:12','2018-07-12 09:58:41','voyager.settings.index','null'),(11,1,'Hooks','','_self','voyager-hook',NULL,5,8,'2018-05-19 17:46:12','2018-06-21 09:45:08','voyager.hooks',NULL),(12,1,'События','','_self','voyager-calendar','#ff0080',NULL,2,'2018-06-04 20:22:50','2018-07-19 20:40:16','voyager.events.index','null'),(13,1,'Спикеры','','_self','voyager-megaphone',NULL,NULL,6,'2018-06-05 09:49:59','2018-07-12 09:58:41','voyager.speakers.index',NULL),(14,1,'Контакты спикеров','','_self','voyager-list',NULL,NULL,7,'2018-06-05 10:27:25','2018-07-12 09:58:41','voyager.speakers-contacts.index',NULL),(15,1,'Доклады','','_self','voyager-file-text',NULL,NULL,8,'2018-06-05 10:51:30','2018-07-12 09:58:41','voyager.speeches.index',NULL),(16,1,'Партнеры','','_self','voyager-person',NULL,NULL,9,'2018-06-05 13:07:01','2018-07-12 09:58:41','voyager.partners.index',NULL),(17,1,'Билеты','','_self',NULL,'#ff0080',25,1,'2018-06-05 14:51:11','2018-07-12 10:13:53','voyager.tickets.index','null'),(18,1,'Опции','','_self',NULL,'#000000',25,2,'2018-06-05 15:25:44','2018-07-12 10:14:08','voyager.options.index','null'),(19,1,'Скидки','','_self',NULL,'#000000',25,3,'2018-06-05 15:52:19','2018-07-12 10:14:23','voyager.discounts.index','null'),(20,1,'Рассрочка','','_self',NULL,'#000000',25,4,'2018-06-05 16:07:41','2018-07-12 10:14:41','voyager.installments.index','null'),(21,1,'Заказы','','_self','voyager-documentation','#0080ff',NULL,4,'2018-06-05 19:18:52','2018-07-19 20:40:16','voyager.orders.index','null'),(25,1,'Билеты','','_self','voyager-bookmark','#ff0080',NULL,3,'2018-06-20 18:09:19','2018-07-19 20:40:16',NULL,''),(26,1,'Банковские карты','','_self',NULL,'#000000',25,5,'2018-06-25 09:39:55','2018-07-12 10:15:03','voyager.cards.index','null'),(27,1,'Продавцы','','_self',NULL,'#000000',25,6,'2018-06-25 10:35:14','2018-07-12 10:15:18','voyager.sellers.index','null'),(30,1,'Новые заказы','','_self',NULL,'#000000',29,1,'2018-06-25 16:53:30','2018-06-25 16:54:49','voyager.orders.index','{\r\n\"status\":\"new\"\r\n}'),(31,1,'Рассрочка','','_self',NULL,'#000000',29,2,'2018-06-25 16:56:39','2018-06-25 16:57:06','voyager.orders.index','{\r\n\"payment_type\":\"INSTALLMENTS\"\r\n}'),(32,1,'Мои настройки','','_self','voyager-params',NULL,NULL,10,'2018-07-03 16:13:53','2018-07-12 09:58:41','voyager.user-settings.index',NULL),(33,1,'Ранние пташки','','_self',NULL,'#000000',25,8,'2018-07-05 12:53:20','2018-07-12 10:15:48','voyager.early-birds.index','null'),(35,1,'Обратная связь','/home/callback','_self','voyager-telephone','#000000',NULL,5,'2018-07-19 20:39:12','2018-07-27 15:55:04',NULL,'');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'admin','2018-05-19 17:46:11','2018-05-19 17:46:11');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_01_01_000000_add_voyager_user_fields',1),(4,'2016_01_01_000000_create_data_types_table',1),(5,'2016_05_19_173453_create_menu_table',1),(6,'2016_10_21_190000_create_roles_table',1),(7,'2016_10_21_190000_create_settings_table',1),(8,'2016_11_30_135954_create_permission_table',1),(9,'2016_11_30_141208_create_permission_role_table',1),(10,'2016_12_26_201236_data_types__add__server_side',1),(11,'2017_01_13_000000_add_route_to_menu_items_table',1),(12,'2017_01_14_005015_create_translations_table',1),(13,'2017_01_15_000000_make_table_name_nullable_in_permissions_table',1),(14,'2017_03_06_000000_add_controller_to_data_types_table',1),(15,'2017_04_21_000000_add_order_to_data_rows_table',1),(16,'2017_07_05_210000_add_policyname_to_data_types_table',1),(17,'2017_08_05_000000_add_group_to_settings_table',1),(18,'2017_11_26_013050_add_user_role_relationship',1),(19,'2017_11_26_015000_create_user_roles_table',1),(20,'2018_03_11_000000_add_user_settings',1),(21,'2018_03_14_000000_add_details_to_data_types_table',1),(22,'2018_03_16_000000_make_settings_value_nullable',1),(23,'2018_05_30_171335_create_sessions_table',2),(25,'2018_06_01_101943_create_events_table',3),(26,'2018_06_01_102555_create_speakers_table',3),(27,'2018_06_01_104016_create_speakers_contacts_table',4),(28,'2018_06_01_112030_create_speeches_table',5),(29,'2018_06_01_121751_create_event_speeches_table',5),(30,'2018_06_01_122315_create_partners_table',6),(32,'2018_06_01_124626_create_tickets_table',7),(33,'2018_06_01_131407_create_options_table',8),(34,'2018_06_01_132841_create_ticket_options_table',9),(35,'2018_06_01_133222_create_early_birds_table',10),(36,'2018_06_01_140026_create_orders_table',11),(37,'2018_06_01_175922_create_order_options_table',12),(38,'2018_06_01_180940_create_payments_table',13),(39,'2018_06_03_134310_create_discounts_table',14),(40,'2018_06_03_140615_create_ticket_discounts_table',15),(43,'2018_06_03_143223_create_price_breakdowns_table',18),(44,'2018_06_03_141121_create_installments_table',19),(45,'2018_06_03_142920_create_ticket_installments_table',19),(46,'2018_06_08_153159_create_pages_table',20),(47,'2018_06_19_165922_add_type_ticket_to_price_breakdowns_table',21),(48,'2018_06_19_180753_drop_price_breakdowns_table',22),(50,'2018_06_19_181201_create_price_breakdowns_table',23),(51,'2018_06_19_194947_create_bills_table',24),(56,'2018_06_24_135156_create_cards_table',26),(57,'2018_06_24_135315_create_ticket_cards_table',26),(58,'2018_06_24_131838_create_sellers_table',27),(59,'2018_06_24_134730_create_promo_codes_table',27),(60,'2018_06_25_123800_add_promocode_to_orders_table',28),(61,'2018_06_25_124127_add_seller_id_to_orders_table',29),(63,'2018_06_25_130213_add_first_payment_to_installments_table',30),(64,'2018_06_26_094416_add_card_id_to_orders_table',31),(65,'2018_06_27_080133_add_installment_id_to_orders_table',32),(66,'2018_06_27_113432_rename_first_payment_to_installments_table',33),(67,'2018_07_01_122828_create_user_settings_table',34),(68,'2018_07_01_135053_create_jobs_table',35),(69,'2018_07_05_122656_add_is_available_to_tickets_table',36),(70,'2018_07_05_123645_add_first_payment_to_installments_table',37),(71,'2018_07_06_071211_add_group_to_ticket_options_table',38),(72,'2018_07_13_153104_add_number_to_orders_table',39),(73,'2018_07_13_153444_add_order_to_tickets_table',40),(74,'2018_07_19_191920_create_callback_table',41),(76,'2018_07_25_124307_alter_status_enum_to_orders_table',42),(77,'2018_07_25_222126_create_order_logs_table',43),(78,'2018_07_26_164626_create_failed_jobs_table',44);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('ACCOMMODATION','FOOD','INCLUSIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INCLUSIVE',
  `price` decimal(13,2) unsigned DEFAULT '0.00',
  `qty` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (1,'Общий номер','ACCOMMODATION',0.00,5,1,1,NULL,NULL,'2018-06-20 09:18:29','2018-07-06 21:21:53'),(2,'Одиночный номер','ACCOMMODATION',1500.00,999,1,1,NULL,NULL,'2018-06-20 09:22:40','2018-07-15 18:21:48'),(3,'Все лекции на потоке «Маникюр»','INCLUSIVE',NULL,65535,1,1,NULL,NULL,'2018-07-06 19:21:33','2018-07-06 19:21:33'),(4,'Кофе-брейки и вечеринки','INCLUSIVE',NULL,65535,1,1,NULL,NULL,'2018-07-06 19:22:48','2018-07-06 19:22:48'),(5,'Все лекции на потоке «Визаж»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:29:53','2018-07-12 11:29:53'),(6,'Все лекции на потоке «Парикмахерство»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:30:47','2018-07-12 11:30:47'),(7,'Все лекции на потоке «Менеджмент»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:31:17','2018-07-12 11:31:17'),(8,'Все лекции и семинары','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:31:59','2018-07-12 11:31:59');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_logs`
--

DROP TABLE IF EXISTS `order_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_logs_order_id_foreign` (`order_id`),
  CONSTRAINT `order_logs_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_logs`
--

LOCK TABLES `order_logs` WRITE;
/*!40000 ALTER TABLE `order_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('NEW','CONFIRMED','PENDING_PAYMENT','PAID','RESERVED','CANCELED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NEW',
  `ticket_id` int(10) unsigned NOT NULL,
  `total_price` decimal(13,2) unsigned NOT NULL,
  `payment_type` enum('CASH','INSTALLMENTS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CASH',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `installment_id` int(10) unsigned DEFAULT NULL,
  `card_id` int(10) unsigned DEFAULT NULL,
  `seller_id` int(10) unsigned DEFAULT NULL,
  `promocode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `notation` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_number_unique` (`number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'Лакми','partners/June2018/xdDszDAYGny8vzuqsDP4.jpg','google.com'),(2,'Новель','partners/June2018/H0JaIJjfPn8yPSpZ4ibr.jpg','fb.com');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(13,2) unsigned NOT NULL,
  `notice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_role`
--

DROP TABLE IF EXISTS `permission_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
INSERT INTO `permission_role` VALUES (1,1),(1,4),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(52,4),(53,1),(54,1),(54,4),(55,1),(55,4),(56,1),(57,1),(57,4),(58,1),(59,1),(59,4),(60,1),(60,4),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(67,4),(68,1),(69,1),(69,4),(70,1),(70,4),(71,1),(72,1),(72,3),(72,4),(73,1),(73,3),(73,4),(74,1),(74,4),(75,1),(75,4),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(82,4),(83,1),(83,4),(84,1),(84,4),(85,1),(85,4),(86,1),(87,1),(87,4),(88,1),(88,4),(89,1),(89,4),(90,1),(90,4),(91,1),(91,4),(92,1),(92,4),(93,1),(93,4),(94,1),(94,4),(95,1),(95,4),(96,1),(96,4),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(102,4),(103,1),(103,4),(104,1),(104,4),(105,1),(105,4),(106,1),(106,4),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(112,4),(113,1),(113,4),(114,1),(114,4),(115,1),(115,4),(116,1),(117,1),(117,4),(118,1),(119,1),(119,4),(120,1),(120,4),(121,1),(122,1),(122,4),(124,1),(124,4),(126,1),(126,4);
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_key_index` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'browse_admin',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(2,'browse_bread',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(3,'browse_database',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(4,'browse_media',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(5,'browse_compass',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(6,'browse_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(7,'read_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(8,'edit_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(9,'add_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(10,'delete_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(11,'browse_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(12,'read_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(13,'edit_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(14,'add_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(15,'delete_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(16,'browse_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(17,'read_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(18,'edit_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(19,'add_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(20,'delete_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(21,'browse_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(22,'read_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(23,'edit_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(24,'add_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(25,'delete_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(26,'browse_hooks',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(27,'browse_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(28,'read_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(29,'edit_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(30,'add_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(31,'delete_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(32,'browse_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(33,'read_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(34,'edit_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(35,'add_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(36,'delete_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(37,'browse_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(38,'read_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(39,'edit_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(40,'add_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(41,'delete_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(42,'browse_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(43,'read_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(44,'edit_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(45,'add_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(46,'delete_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(47,'browse_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(48,'read_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(49,'edit_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(50,'add_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(51,'delete_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(52,'browse_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(53,'read_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(54,'edit_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(55,'add_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(56,'delete_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(57,'browse_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(58,'read_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(59,'edit_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(60,'add_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(61,'delete_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(62,'browse_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(63,'read_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(64,'edit_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(65,'add_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(66,'delete_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(67,'browse_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(68,'read_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(69,'edit_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(70,'add_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(71,'delete_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(72,'browse_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(73,'read_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(74,'edit_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(75,'add_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(76,'delete_orders','orders','2018-06-05 19:18:52','2018-06-05 19:18:52'),(77,'browse_price_breakdowns','price_breakdowns','2018-06-05 19:32:20','2018-06-05 19:32:20'),(78,'read_price_breakdowns','price_breakdowns','2018-06-05 19:32:20','2018-06-05 19:32:20'),(79,'edit_price_breakdowns','price_breakdowns','2018-06-05 19:32:20','2018-06-05 19:32:20'),(80,'add_price_breakdowns','price_breakdowns','2018-06-05 19:32:20','2018-06-05 19:32:20'),(81,'delete_price_breakdowns','price_breakdowns','2018-06-05 19:32:20','2018-06-05 19:32:20'),(82,'browse_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(83,'read_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(84,'edit_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(85,'add_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(86,'delete_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(87,'browse_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(88,'read_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(89,'edit_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(90,'add_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(91,'delete_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(92,'browse_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(93,'read_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(94,'edit_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(95,'add_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(96,'delete_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(97,'browse_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(98,'read_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(99,'edit_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(100,'add_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(101,'delete_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(102,'browse_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(103,'read_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(104,'edit_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(105,'add_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(106,'delete_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(107,'browse_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(108,'read_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(109,'edit_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(110,'add_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(111,'delete_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(112,'browse_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(113,'read_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(114,'edit_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(115,'add_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(116,'delete_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(117,'browse_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(118,'read_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(119,'edit_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(120,'add_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(121,'delete_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(122,'browse_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(123,'read_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(124,'edit_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(125,'add_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(126,'delete_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `promo_codes`
--

DROP TABLE IF EXISTS `promo_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `promo_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_id` int(10) unsigned NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promo_codes_seller_id_foreign` (`seller_id`),
  CONSTRAINT `promo_codes_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `promo_codes`
--

LOCK TABLES `promo_codes` WRITE;
/*!40000 ALTER TABLE `promo_codes` DISABLE KEYS */;
INSERT INTO `promo_codes` VALUES (1,'005',2,NULL,'2018-06-25 15:21:43','2018-06-25 15:21:43'),(2,'006',2,NULL,'2018-06-25 15:21:54','2018-06-25 15:21:54'),(3,'007',2,NULL,'2018-06-25 15:22:08','2018-06-25 15:22:08');
/*!40000 ALTER TABLE `promo_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrator','2018-05-19 17:46:12','2018-05-19 17:46:12'),(2,'user','Normal User','2018-05-19 17:46:12','2018-05-19 17:46:12'),(3,'seller','Продавец','2018-06-25 12:24:33','2018-06-25 12:25:06'),(4,'manager','Менеджер','2018-06-30 10:37:13','2018-06-30 10:37:13');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sellers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,'SNB','snb',NULL,'2018-06-25 15:17:59','2018-07-16 12:39:01'),(2,'Hairgum','hairgum',NULL,'2018-06-25 15:20:14','2018-07-16 12:36:56'),(3,'Lakme','lakme',NULL,'2018-06-25 15:20:47','2018-07-16 12:36:33'),(4,'Nouvelle','nouvelle',NULL,'2018-07-16 12:40:10','2018-07-16 12:40:10'),(5,'Prof-cosmetic','prof',NULL,'2018-07-16 12:55:33','2018-07-16 12:55:33'),(6,'Orising','orising',NULL,'2018-07-16 12:56:35','2018-07-16 12:56:35'),(7,'Voynova ','voynova',NULL,'2018-07-16 12:57:29','2018-07-16 12:57:29'),(8,'Adore','adore',NULL,'2018-07-16 12:57:51','2018-07-16 12:57:51'),(9,'Сакелари','sakelary',NULL,'2018-07-16 12:58:48','2018-07-16 12:58:48'),(10,'Стадник','stadnik',NULL,'2018-07-16 12:59:15','2018-07-16 12:59:15'),(11,'Dieter-baumann','baumann',NULL,'2018-07-16 12:59:53','2018-07-16 12:59:53'),(12,'Elan','elan',NULL,'2018-07-16 13:00:22','2018-07-16 13:00:22');
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('htFbFkdpY83DDYchjqkTE5iQYCJdIQfRp1bz0FCh',1,'192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.60','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaGsyVUxOMVpMRDM4Zkd1R29pM0dhQlFMdjltbWlidnFUNG82UnJJQyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjE4OiJodHRwOi8vbW9sZmFyLnRlc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NToib3JkZXIiO2E6NTp7czo3OiJjYXJkX2lkIjtpOjE7czo5OiJ0aWNrZXRfaWQiO3M6MToiMyI7czoxMToib3B0aW9uc19pZHMiO2E6MTp7aTowO2k6Mjt9czoxMDoidG90YWxfY29zdCI7ZDo5MDAwO3M6MTI6InBheW1lbnRfdHlwZSI7czo0OiJjYXNoIjt9fQ==',1532702512);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `details` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site.title','Site Title','Molfar','','text',1,'Site'),(2,'site.description','Site Description','Molfar forum','','text',2,'Site'),(3,'site.logo','Site Logo',NULL,'','image',3,'Site'),(4,'site.google_analytics_tracking_id','Google Analytics Tracking ID',NULL,'','text',4,'Site'),(5,'admin.bg_image','Admin Background Image',NULL,'','image',5,'Admin'),(6,'admin.title','Admin Title','Admin','','text',1,'Admin'),(7,'admin.description','Admin Description',NULL,'','text',2,'Admin'),(8,'admin.loader','Admin Loader',NULL,'','image',3,'Admin'),(9,'admin.icon_image','Admin Icon Image',NULL,'','image',4,'Admin'),(10,'admin.google_analytics_client_id','Google Analytics Client ID (used for admin dashboard)','silence is golden','','text',1,'Admin'),(12,'notification.neworder','Оповещать про новый заказ','1',NULL,'checkbox',6,'Notification'),(13,'notification.statuschanged','Оповещать про изменение статуса заказа','1',NULL,'checkbox',7,'Notification'),(14,'notification.newpayment','Оповещать о новом платеже','1',NULL,'checkbox',8,'Notification'),(15,'notification.missedpayment','Оповещать о пропущенном платеже','1',NULL,'checkbox',9,'Notification'),(17,'osnovnoe.contact_email','Контактный E-mail','molfar.forum@gmail.com','{\"validation\":{\"rule\":\"email\",\"messages\":{\"email\":\"E-mail неверный\"}},\"description\":\"Контактный e-mail\"}','text',10,'Основное'),(19,'osnovnoe.payment_phone','Телефон по вопросам оплаты','+380 (66) 558 31 07, +380 (98) 318 71 15',NULL,'text',11,'Основное'),(20,'osnovnoe.payment_name','Контактное имя по вопросам оплаты','Ирина',NULL,'text',12,'Основное');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speakers`
--

DROP TABLE IF EXISTS `speakers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speakers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speakers`
--

LOCK TABLES `speakers` WRITE;
/*!40000 ALTER TABLE `speakers` DISABLE KEYS */;
INSERT INTO `speakers` VALUES (1,'oleg-dergachev','Олег Дергачев',NULL,'Мастер стрижки','2018-06-05 09:54:51','2018-06-05 12:42:51'),(2,'miss-mariya','Мисс Мария',NULL,'Делаю маникюр','2018-06-05 12:43:31','2018-06-05 12:43:31'),(3,'evgeniy-krasnoper','Евгений Краснопев',NULL,'Учу менеджменту','2018-06-05 12:44:24','2018-06-05 13:32:58');
/*!40000 ALTER TABLE `speakers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speakers_contacts`
--

DROP TABLE IF EXISTS `speakers_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speakers_contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speaker_id` int(10) unsigned NOT NULL,
  `type` enum('FACEBOOK','INSTAGRAM','WEBSITE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FACEBOOK',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `speakers_contacts_speaker_id_foreign` (`speaker_id`),
  CONSTRAINT `speakers_contacts_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `speakers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speakers_contacts`
--

LOCK TABLES `speakers_contacts` WRITE;
/*!40000 ALTER TABLE `speakers_contacts` DISABLE KEYS */;
INSERT INTO `speakers_contacts` VALUES (1,2,'INSTAGRAM','http://instagram.com/maria','2018-06-11 18:23:11','2018-06-11 18:23:11'),(2,1,'WEBSITE','google.com','2018-06-11 18:23:34','2018-06-11 18:23:34'),(3,1,'FACEBOOK','fb.com/dergachev','2018-06-11 18:23:59','2018-06-11 18:23:59');
/*!40000 ALTER TABLE `speakers_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speeches`
--

DROP TABLE IF EXISTS `speeches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `speeches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview` text COLLATE utf8mb4_unicode_ci,
  `speaker_id` int(10) unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `speeches_speaker_id_foreign` (`speaker_id`),
  CONSTRAINT `speeches_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `speakers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speeches`
--

LOCK TABLES `speeches` WRITE;
/*!40000 ALTER TABLE `speeches` DISABLE KEYS */;
INSERT INTO `speeches` VALUES (1,'how-to-make-manicure','Как правильно делать маникюр','',1,'<p>Бум</p>','2018-06-05 11:10:00','2018-06-05 11:10:00'),(2,'about-hair','Про укладку волос','',2,'<p>Нужно уложить так</p>','2018-06-05 12:48:00','2018-06-05 12:48:00'),(3,'about-managment','Что нужно знать про управление','',3,'<p>что-то такое</p>','2018-06-05 12:49:00','2018-06-05 12:49:00');
/*!40000 ALTER TABLE `speeches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_cards`
--

DROP TABLE IF EXISTS `ticket_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_cards` (
  `ticket_id` int(10) unsigned NOT NULL,
  `card_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ticket_id`,`card_id`),
  KEY `ticket_cards_card_id_foreign` (`card_id`),
  CONSTRAINT `ticket_cards_card_id_foreign` FOREIGN KEY (`card_id`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_cards_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_cards`
--

LOCK TABLES `ticket_cards` WRITE;
/*!40000 ALTER TABLE `ticket_cards` DISABLE KEYS */;
INSERT INTO `ticket_cards` VALUES (1,1),(2,1),(3,1),(4,1),(5,1);
/*!40000 ALTER TABLE `ticket_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_discounts`
--

DROP TABLE IF EXISTS `ticket_discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_discounts` (
  `ticket_id` int(10) unsigned NOT NULL,
  `discount_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ticket_id`,`discount_id`),
  KEY `ticket_discounts_discount_id_foreign` (`discount_id`),
  CONSTRAINT `ticket_discounts_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_discounts_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_discounts`
--

LOCK TABLES `ticket_discounts` WRITE;
/*!40000 ALTER TABLE `ticket_discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket_discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_installments`
--

DROP TABLE IF EXISTS `ticket_installments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_installments` (
  `ticket_id` int(10) unsigned NOT NULL,
  `installment_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ticket_id`,`installment_id`),
  KEY `ticket_installments_installment_id_foreign` (`installment_id`),
  CONSTRAINT `ticket_installments_installment_id_foreign` FOREIGN KEY (`installment_id`) REFERENCES `installments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_installments_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_installments`
--

LOCK TABLES `ticket_installments` WRITE;
/*!40000 ALTER TABLE `ticket_installments` DISABLE KEYS */;
INSERT INTO `ticket_installments` VALUES (1,1),(2,1),(3,1),(4,1),(5,1);
/*!40000 ALTER TABLE `ticket_installments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket_options`
--

DROP TABLE IF EXISTS `ticket_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticket_options` (
  `ticket_id` int(10) unsigned NOT NULL,
  `option_id` int(10) unsigned NOT NULL,
  `group` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`ticket_id`,`option_id`),
  KEY `ticket_options_option_id_foreign` (`option_id`),
  CONSTRAINT `ticket_options_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ticket_options_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket_options`
--

LOCK TABLES `ticket_options` WRITE;
/*!40000 ALTER TABLE `ticket_options` DISABLE KEYS */;
INSERT INTO `ticket_options` VALUES (1,1,1),(1,2,1),(1,3,NULL),(1,4,NULL),(2,1,1),(2,2,1),(2,4,NULL),(2,5,NULL),(3,1,1),(3,2,1),(3,4,NULL),(3,6,NULL),(4,1,1),(4,2,1),(4,4,NULL),(4,7,NULL),(5,1,1),(5,2,1),(5,4,NULL),(5,8,NULL);
/*!40000 ALTER TABLE `ticket_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `flow` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(13,2) unsigned DEFAULT '0.00',
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `qty` smallint(5) unsigned NOT NULL DEFAULT '0',
  `order` int(10) unsigned NOT NULL DEFAULT '1',
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `deleted_by` int(10) unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_event_id_foreign` (`event_id`),
  CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'manikyur',1,'Маникюр',8300.00,1,300,1,1,NULL,NULL,NULL,'2018-07-12 11:50:25','2018-07-26 17:26:17'),(2,'vizazh',1,'Визаж',8300.00,1,350,2,1,1,NULL,NULL,'2018-07-12 11:51:23','2018-07-14 18:53:44'),(3,'parikmaherstvo',1,'Парикмахерство',8300.00,1,300,3,1,1,NULL,NULL,'2018-07-12 11:52:53','2018-07-14 18:53:47'),(4,'menedzhment',1,'Менеджмент',8300.00,1,100,4,1,1,NULL,NULL,'2018-07-12 11:53:44','2018-07-25 12:13:11'),(5,'universal',1,'Универсальный',11000.00,1,200,5,1,NULL,NULL,NULL,'2018-07-12 11:54:45','2018-07-25 18:38:28');
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int(10) unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1,'data_types','display_name_singular',4,'en','Event','2018-06-04 20:32:35','2018-06-04 20:39:55'),(2,'data_types','display_name_plural',4,'en','Events','2018-06-04 20:32:36','2018-06-04 20:39:55'),(5,'data_types','display_name_singular',5,'en','Спикер','2018-06-05 09:51:43','2018-06-05 09:51:43'),(6,'data_types','display_name_plural',5,'en','Спикеры','2018-06-05 09:51:43','2018-06-05 09:51:43'),(7,'data_types','display_name_singular',7,'en','Контакт','2018-06-05 10:30:54','2018-06-05 10:30:54'),(8,'data_types','display_name_plural',7,'en','Контакты спикеров','2018-06-05 10:30:54','2018-06-05 10:30:54'),(9,'data_types','display_name_singular',8,'en','Доклад','2018-06-05 10:53:08','2018-06-05 10:53:08'),(10,'data_types','display_name_plural',8,'en','Доклады','2018-06-05 10:53:08','2018-06-05 10:53:08'),(11,'events','name',1,'en','Molfar Beauty Forum ‘19','2018-06-05 12:50:12','2018-07-25 12:23:34'),(12,'events','place',1,'en','Буковель','2018-06-05 12:50:12','2018-06-05 12:50:12'),(13,'data_types','display_name_singular',9,'en','Партнер','2018-06-05 13:17:30','2018-06-05 13:17:30'),(14,'data_types','display_name_plural',9,'en','Партнеры','2018-06-05 13:17:30','2018-06-05 13:17:30'),(15,'partners','name',2,'en','Novelle','2018-06-05 13:17:47','2018-06-05 13:17:47'),(16,'partners','name',1,'en','Lakme','2018-06-05 13:18:22','2018-06-05 13:18:22'),(17,'speeches','name',3,'en','About managment','2018-06-05 13:25:09','2018-06-05 13:25:09'),(18,'speeches','preview',3,'en','','2018-06-05 13:25:09','2018-06-05 13:25:09'),(19,'speeches','content',3,'en','<p>что-то такое</p>','2018-06-05 13:25:09','2018-06-05 13:25:09'),(20,'speeches','name',2,'en','About hair','2018-06-05 13:25:54','2018-06-05 13:25:54'),(21,'speeches','preview',2,'en','','2018-06-05 13:25:54','2018-06-05 13:25:54'),(22,'speeches','content',2,'en','<p>Нужно уложить так</p>','2018-06-05 13:25:54','2018-06-05 13:25:54'),(23,'speeches','name',1,'en','How to make manicure','2018-06-05 13:26:38','2018-06-05 13:26:38'),(24,'speeches','preview',1,'en','','2018-06-05 13:26:38','2018-06-05 13:26:38'),(25,'speeches','content',1,'en','<p>Бум</p>','2018-06-05 13:26:39','2018-06-05 13:26:39'),(26,'speakers','name',3,'en','Evgeniy Krasnoper','2018-06-05 13:32:58','2018-06-05 13:32:58'),(27,'speakers','summary',3,'en','Learn management ','2018-06-05 13:32:58','2018-06-05 13:32:58'),(28,'menu_items','title',17,'en','','2018-06-05 14:52:39','2018-06-05 14:52:39'),(29,'menu_items','title',12,'en','','2018-06-05 14:53:55','2018-06-05 14:53:55'),(30,'data_types','display_name_singular',10,'en','Билет','2018-06-05 15:00:04','2018-06-05 15:00:04'),(31,'data_types','display_name_plural',10,'en','Билеты','2018-06-05 15:00:04','2018-06-05 15:00:04'),(32,'data_types','display_name_singular',11,'en','Опция','2018-06-05 15:29:11','2018-06-05 15:29:11'),(33,'data_types','display_name_plural',11,'en','Опции билета','2018-06-05 15:29:11','2018-06-05 15:29:11'),(34,'data_types','display_name_singular',13,'en','Рассрочка','2018-06-05 16:09:03','2018-06-05 16:09:03'),(35,'data_types','display_name_plural',13,'en','Рассрочка','2018-06-05 16:09:03','2018-06-05 16:09:03'),(36,'data_types','display_name_singular',12,'en','Скидка','2018-06-05 16:12:08','2018-06-05 16:12:08'),(37,'data_types','display_name_plural',12,'en','Скидки','2018-06-05 16:12:08','2018-06-05 16:12:08'),(38,'data_types','display_name_singular',14,'en','Заказ','2018-06-05 19:20:46','2018-06-05 19:20:46'),(39,'data_types','display_name_plural',14,'en','Заказы','2018-06-05 19:20:46','2018-06-05 19:20:46'),(40,'data_types','display_name_singular',15,'en','Составляющие цены','2018-06-05 20:48:13','2018-06-05 20:48:13'),(41,'data_types','display_name_plural',15,'en','Составляющие цены','2018-06-05 20:48:13','2018-06-05 20:48:13'),(42,'data_types','display_name_singular',16,'en','Платеж','2018-06-05 21:02:55','2018-06-05 21:02:55'),(43,'data_types','display_name_plural',16,'en','Платежи','2018-06-05 21:02:55','2018-06-05 21:02:55'),(44,'menu_items','title',21,'en','','2018-06-05 21:06:45','2018-06-05 21:06:45'),(46,'menu_items','title',18,'en','','2018-06-05 21:24:55','2018-06-05 21:24:55'),(47,'tickets','flow',1,'en','','2018-06-07 11:25:06','2018-06-07 11:25:06'),(49,'discounts','name',1,'en','','2018-06-20 08:46:40','2018-06-20 08:46:40'),(50,'discounts','description',1,'en','','2018-06-20 08:46:40','2018-06-20 08:46:40'),(51,'discounts','name',2,'en','','2018-06-20 08:48:03','2018-06-20 08:48:03'),(52,'discounts','description',2,'en','','2018-06-20 08:48:03','2018-06-20 08:48:03'),(53,'discounts','name',3,'en','','2018-06-20 08:50:40','2018-06-20 08:50:40'),(54,'discounts','description',3,'en','','2018-06-20 08:50:40','2018-06-20 08:50:40'),(55,'options','name',1,'en','','2018-06-20 09:18:29','2018-06-20 09:18:29'),(56,'options','name',2,'en','','2018-06-20 09:22:40','2018-06-20 09:22:40'),(57,'installments','name',1,'en','','2018-06-20 15:54:34','2018-06-20 15:54:34'),(58,'installments','description',1,'en','','2018-06-20 15:54:34','2018-06-20 15:54:34'),(59,'menu_items','title',1,'en','','2018-06-20 18:08:06','2018-06-21 09:33:53'),(60,'menu_items','title',25,'en','','2018-06-20 18:09:19','2018-06-20 18:09:19'),(61,'menu_items','title',26,'en','','2018-06-20 18:12:20','2018-06-20 18:12:20'),(62,'menu_items','title',26,'ru','','2018-06-20 18:15:37','2018-06-20 18:15:37'),(64,'data_types','display_name_singular',17,'en','Банковская карта','2018-06-25 10:02:55','2018-06-25 10:02:55'),(65,'data_types','display_name_plural',17,'en','Банковские карты','2018-06-25 10:02:55','2018-06-25 10:02:55'),(66,'data_types','display_name_singular',18,'en','Продавец','2018-06-25 10:36:42','2018-06-25 10:36:42'),(67,'data_types','display_name_plural',18,'en','Продавцы','2018-06-25 10:36:42','2018-06-25 10:36:42'),(68,'sellers','name',1,'en','SNB','2018-06-25 10:40:36','2018-07-16 12:39:01'),(69,'data_types','display_name_singular',19,'en','Промокод','2018-06-25 10:48:11','2018-06-25 10:48:11'),(70,'data_types','display_name_plural',19,'en','Промокоды','2018-06-25 10:48:11','2018-06-25 10:48:11'),(71,'sellers','name',2,'en','Hairgum','2018-06-25 15:20:14','2018-07-16 12:39:37'),(72,'sellers','name',3,'en','Lakme','2018-06-25 15:20:47','2018-07-16 12:39:21'),(74,'menu_items','title',30,'en','','2018-06-25 16:53:30','2018-06-25 16:53:30'),(75,'menu_items','title',31,'en','','2018-06-25 16:56:39','2018-06-25 16:56:39'),(76,'data_types','display_name_singular',20,'en','Счет','2018-06-28 15:59:51','2018-06-28 15:59:51'),(77,'data_types','display_name_plural',20,'en','Счета','2018-06-28 15:59:51','2018-06-28 15:59:51'),(78,'tickets','flow',3,'en','','2018-06-30 10:13:54','2018-06-30 10:13:54'),(79,'data_types','display_name_singular',21,'en','Настройка','2018-07-03 16:19:51','2018-07-03 16:19:51'),(80,'data_types','display_name_plural',21,'en','Мои настройки','2018-07-03 16:19:51','2018-07-03 16:19:51'),(81,'data_types','display_name_singular',22,'en','Ранняя пташка','2018-07-05 17:27:22','2018-07-05 17:27:22'),(82,'data_types','display_name_plural',22,'en','Ранние пташки','2018-07-05 17:27:22','2018-07-05 17:27:22'),(83,'data_types','display_name_singular',24,'en','Ticket Option','2018-07-06 07:52:15','2018-07-06 07:52:15'),(84,'data_types','display_name_plural',24,'en','Ticket Options','2018-07-06 07:52:15','2018-07-06 07:52:15'),(85,'options','name',3,'en','','2018-07-06 19:21:33','2018-07-06 19:21:33'),(86,'options','name',4,'en','','2018-07-06 19:22:48','2018-07-06 19:22:48'),(87,'tickets','flow',2,'en','','2018-07-10 10:51:37','2018-07-12 11:51:23'),(88,'tickets','flow',4,'en','','2018-07-11 22:16:33','2018-07-12 11:53:44'),(89,'menu_items','title',19,'en','Скидки','2018-07-12 10:14:23','2018-07-12 10:14:23'),(90,'menu_items','title',20,'en','Рассрочка','2018-07-12 10:14:41','2018-07-12 10:14:41'),(91,'menu_items','title',27,'en','Продавцы','2018-07-12 10:15:18','2018-07-12 10:15:18'),(93,'menu_items','title',33,'en','Ранние пташки','2018-07-12 10:15:48','2018-07-12 10:15:48'),(94,'options','name',5,'en','','2018-07-12 11:29:53','2018-07-12 11:29:53'),(95,'options','name',6,'en','','2018-07-12 11:30:47','2018-07-12 11:30:47'),(96,'options','name',7,'en','','2018-07-12 11:31:17','2018-07-12 11:31:17'),(97,'options','name',8,'en','','2018-07-12 11:31:59','2018-07-12 11:31:59'),(98,'tickets','flow',5,'en','','2018-07-12 11:54:45','2018-07-12 11:54:45'),(99,'sellers','name',4,'en','','2018-07-16 12:40:10','2018-07-16 12:40:10'),(100,'sellers','name',5,'en','Prof-cosmetic','2018-07-16 12:55:33','2018-07-16 12:55:33'),(101,'sellers','name',6,'en','','2018-07-16 12:56:35','2018-07-16 12:56:35'),(102,'sellers','name',7,'en','','2018-07-16 12:57:29','2018-07-16 12:57:29'),(103,'sellers','name',8,'en','','2018-07-16 12:57:51','2018-07-16 12:57:51'),(104,'sellers','name',9,'en','','2018-07-16 12:58:48','2018-07-16 12:58:48'),(105,'sellers','name',10,'en','','2018-07-16 12:59:15','2018-07-16 12:59:15'),(106,'sellers','name',11,'en','','2018-07-16 12:59:53','2018-07-16 12:59:53'),(107,'sellers','name',12,'en','','2018-07-16 13:00:22','2018-07-16 13:00:22'),(108,'data_types','display_name_singular',25,'en','Обратная связь','2018-07-19 23:15:44','2018-07-19 23:15:44'),(109,'data_types','display_name_plural',25,'en','Обратная связь','2018-07-19 23:15:44','2018-07-19 23:15:44'),(110,'menu_items','title',35,'en','Обратная связь','2018-07-20 10:17:20','2018-07-20 10:17:20'),(111,'events','name',3,'en','','2018-07-25 11:57:04','2018-07-25 11:57:04'),(112,'events','place',3,'en','','2018-07-25 11:57:04','2018-07-25 11:57:04');
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `user_roles_user_id_index` (`user_id`),
  KEY `user_roles_role_id_index` (`role_id`),
  CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `setting_id` int(10) unsigned NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_settings_user_id_foreign` (`user_id`),
  KEY `user_settings_setting_id_foreign` (`setting_id`),
  CONSTRAINT `user_settings_setting_id_foreign` FOREIGN KEY (`setting_id`) REFERENCES `settings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_settings`
--

LOCK TABLES `user_settings` WRITE;
/*!40000 ALTER TABLE `user_settings` DISABLE KEYS */;
INSERT INTO `user_settings` VALUES (1,1,15,'0',NULL,NULL),(2,1,14,'0',NULL,NULL);
/*!40000 ALTER TABLE `user_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin','admin','users/default.png','$2y$10$s7s9S1.SrFpAlNyPs2E.COOGkl9LTN7ITqHcCej1hENNP77XYIr3m','i8rZg6A9cRni0u3wlaxOULzB8oYWHO6iVIisnAguKpWtg20JqUbj2dFrUjlz','{\"locale\":\"ru\"}','2018-05-19 18:15:48','2018-06-21 09:33:19'),(2,1,'bogdan','bogdan','users/default.png','$2y$10$s7s9S1.SrFpAlNyPs2E.COOGkl9LTN7ITqHcCej1hENNP77XYIr3m','RNraOuOj7SrEBfGxgoyXAoCoUP9OdZ0mVZghXaniCqtcKshJ9LawEnogYeOf',NULL,NULL,NULL),(3,2,'Пользователь сайта','user@molfar.com','users/default.png','$2y$10$jv9qmh5jSY.swfe.P27K7eNGTF.s6Zm8bzcf6EzvrrLT0gUNjLEYu',NULL,'{\"locale\":\"ru\"}','2018-07-02 15:10:59','2018-07-04 17:11:44'),(4,4,'Менеджер 1','andrianov@kontora.design','users/default.png','$2y$10$s7s9S1.SrFpAlNyPs2E.COOGkl9LTN7ITqHcCej1hENNP77XYIr3m','RNraOuOj7SrEBfGxgoyXAoCoUP9OdZ0mVZghXaniCqtcKshJ9LawEnogYeOf','{\"locale\":\"ru\"}',NULL,'2018-07-04 17:12:00'),(5,4,'Менеджер 2','bogd.an.drianov@gmail.com','users/default.png','$2y$10$s7s9S1.SrFpAlNyPs2E.COOGkl9LTN7ITqHcCej1hENNP77XYIr3m','RNraOuOj7SrEBfGxgoyXAoCoUP9OdZ0mVZghXaniCqtcKshJ9LawEnogYeOf',NULL,NULL,NULL),(6,4,'Менеджер','Molfar.forum@gmail.com','users/default.png','$2y$10$s3TE5QBFh038fEuf.QhLZ.3vJfwQeE2pOgR0Z4MQ2cIk/Zy6wkAT.',NULL,'{\"locale\":\"ru\"}','2018-07-16 13:36:10','2018-07-16 13:36:10');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voyager_theme_options`
--

DROP TABLE IF EXISTS `voyager_theme_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voyager_theme_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voyager_theme_id` int(10) unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voyager_theme_options_voyager_theme_id_index` (`voyager_theme_id`),
  CONSTRAINT `voyager_theme_options_voyager_theme_id_foreign` FOREIGN KEY (`voyager_theme_id`) REFERENCES `voyager_themes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voyager_theme_options`
--

LOCK TABLES `voyager_theme_options` WRITE;
/*!40000 ALTER TABLE `voyager_theme_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `voyager_theme_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voyager_themes`
--

DROP TABLE IF EXISTS `voyager_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voyager_themes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voyager_themes_folder_unique` (`folder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voyager_themes`
--

LOCK TABLES `voyager_themes` WRITE;
/*!40000 ALTER TABLE `voyager_themes` DISABLE KEYS */;
/*!40000 ALTER TABLE `voyager_themes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-07-27 17:56:20
