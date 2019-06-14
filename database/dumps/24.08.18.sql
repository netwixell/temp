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
) ENGINE=InnoDB AUTO_INCREMENT=294 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_rows`
--

LOCK TABLES `data_rows` WRITE;
/*!40000 ALTER TABLE `data_rows` DISABLE KEYS */;
INSERT INTO `data_rows` VALUES (1,1,'id','number','ID',1,0,0,0,0,0,'',1),(2,1,'name','text','Name',1,1,1,1,1,1,'',2),(3,1,'email','text','Email',1,1,1,1,1,1,'',3),(4,1,'password','password','Password',1,0,0,1,1,0,'',4),(5,1,'remember_token','text','Remember Token',0,0,0,0,0,0,'',5),(6,1,'created_at','timestamp','Created At',0,1,1,0,0,0,'',6),(7,1,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',7),(8,1,'avatar','image','Avatar',0,1,1,1,1,1,'',8),(9,1,'user_belongsto_role_relationship','relationship','Role',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\"}',10),(10,1,'user_belongstomany_role_relationship','relationship','Roles',0,1,1,1,1,0,'{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}',11),(11,1,'locale','text','Locale',0,1,1,1,1,0,'',12),(12,1,'settings','hidden','Settings',0,0,0,0,0,0,'',12),(13,2,'id','number','ID',1,0,0,0,0,0,'',1),(14,2,'name','text','Name',1,1,1,1,1,1,'',2),(15,2,'created_at','timestamp','Created At',0,0,0,0,0,0,'',3),(16,2,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',4),(17,3,'id','number','ID',1,0,0,0,0,0,'',1),(18,3,'name','text','Name',1,1,1,1,1,1,'',2),(19,3,'created_at','timestamp','Created At',0,0,0,0,0,0,'',3),(20,3,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'',4),(21,3,'display_name','text','Display Name',1,1,1,1,1,1,'',5),(22,1,'role_id','text','Role',1,1,1,1,1,1,'',9),(23,4,'id','text','Id',1,0,0,0,0,0,NULL,1),(24,4,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\"},\"validation\":{\"rule\":\"unique:events|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',4),(25,4,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',2),(26,4,'date_from','date','Дата начала',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}}}',5),(27,4,'date_to','date','Дата окончания',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}}}',6),(28,4,'place','text','Место проведения',0,1,1,1,1,1,NULL,7),(29,4,'created_at','timestamp','Создано',0,0,0,1,0,1,'{\"format\":\"%d.%m.%Y\"}',10),(30,4,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(31,5,'id','text','Id',1,0,0,0,0,0,NULL,1),(32,5,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:speakers|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',4),(33,5,'name','text','Имя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите имя\"}}}',3),(34,5,'image','image','Фото',0,1,1,1,1,1,NULL,2),(35,5,'summary','text_area','Резюме',0,0,1,1,1,1,NULL,5),(36,5,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(37,5,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(38,7,'id','text','Id',1,0,0,0,0,0,NULL,1),(39,7,'speaker_id','hidden','Speaker Id',1,0,0,1,1,1,NULL,2),(40,7,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"FACEBOOK\",\"options\":{\"FACEBOOK\":\"Facebook\",\"INSTAGRAM\":\"Instagram\",\"WEBSITE\":\"Веб-сайт\"}}',4),(41,7,'value','text','Ссылка',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите ссылку\"}}}',5),(42,7,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(43,7,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(44,7,'speakers_contact_belongsto_data_row_relationship','relationship','Спикер',0,1,1,1,1,1,'{\"model\":\"App\\\\Speaker\",\"table\":\"speakers\",\"type\":\"belongsTo\",\"column\":\"speaker_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(45,8,'id','text','Id',1,0,0,0,0,0,NULL,1),(46,8,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:speeches|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',5),(47,8,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',4),(48,8,'preview','text_area','Краткий обзор',0,1,1,1,1,1,NULL,6),(49,8,'speaker_id','hidden','Speaker Id',1,0,0,1,1,1,NULL,2),(50,8,'content','rich_text_box','Содержание',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите содержимое доклада\"}}}',7),(51,8,'created_at','timestamp','Создан',0,0,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',8),(52,8,'updated_at','timestamp','Изменен',0,0,1,1,0,0,'{\"format\":\"%d.%m.%Y\"}',9),(53,8,'speech_belongsto_speaker_relationship','relationship','Спикер',0,1,1,1,1,1,'{\"model\":\"App\\\\Speaker\",\"table\":\"speakers\",\"type\":\"belongsTo\",\"column\":\"speaker_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(54,4,'event_belongstomany_speech_relationship','relationship','Доклады',0,0,1,1,1,1,'{\"model\":\"App\\\\Speech\",\"table\":\"speeches\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"event_speeches\",\"pivot\":\"1\",\"taggable\":\"on\"}',3),(55,9,'id','text','Id',1,0,0,0,0,0,NULL,1),(56,9,'name','text','Имя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|unique:partners\",\"messages\":{\"required\":\"Введите имя\",\"unique\":\"Партнер с этим именем уже задан\"}}}',2),(57,9,'image','file','Изображение',1,1,1,1,1,1,NULL,3),(58,9,'link','text','Ссылка',0,0,1,1,1,1,'{\"validation\":{\"rule\":\"max:255\"}}',4),(59,10,'id','text','Id',1,0,0,0,0,0,NULL,1),(60,10,'slug','text','Ссылка',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"unique:tickets|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',8),(61,10,'event_id','hidden','Event Id',1,0,0,1,1,1,NULL,3),(62,10,'flow','text','Поток',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',5),(63,10,'price','number','Цена',0,1,1,1,1,1,NULL,6),(64,10,'qty','number','Количество',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите количество билетов\"}}}',7),(65,10,'created_by','hidden','Кем создано',1,0,0,0,0,1,NULL,9),(66,10,'updated_by','hidden','Кем отредактировано',0,0,0,0,0,1,NULL,10),(67,10,'deleted_by','hidden','Кем удалено',0,0,0,0,0,1,NULL,11),(68,10,'deleted_at','timestamp','Когда удалено',0,0,0,0,0,1,'{\"format\":\"%d.%m.%Y\"}',12),(69,10,'created_at','timestamp','Когда создано',0,0,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',13),(70,10,'updated_at','timestamp','Updated At',0,0,0,0,0,0,'{\"format\":\"%d.%m.%Y\"}',14),(71,10,'ticket_belongsto_event_relationship','relationship','Событие',0,1,1,1,1,1,'{\"model\":\"App\\\\Event\",\"table\":\"events\",\"type\":\"belongsTo\",\"column\":\"event_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',4),(72,11,'id','text','Id',1,0,0,0,0,0,NULL,1),(73,11,'name','select_multiple','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите название\"}}}',3),(74,11,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"INCLUSIVE\",\"options\":{\"ACCOMMODATION\":\"Проживание\",\"FOOD\":\"Питание\",\"INCLUSIVE\":\"Включено\"}}',2),(75,11,'price','number','Цена',0,1,1,1,1,1,NULL,4),(76,11,'qty','number','Количество',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required|numeric|min:0|max:65535\"},\"description\":\"Сколько единиц доступно для заказа\"}',5),(77,11,'created_by','text','Кем создано',1,0,0,0,0,1,NULL,6),(78,11,'updated_by','text','Кем отредактировано',0,0,0,0,0,1,NULL,7),(79,11,'deleted_by','text','Кем удалено',0,0,0,0,0,1,NULL,8),(80,11,'deleted_at','timestamp','Когда удалено',0,0,0,0,0,1,NULL,9),(81,11,'created_at','timestamp','Когда создано',0,0,0,0,0,1,NULL,10),(82,11,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(83,12,'id','text','Id',1,0,0,0,0,0,NULL,1),(84,12,'name','text','Название',1,1,1,1,1,1,NULL,3),(85,12,'is_available','checkbox','Отображение',1,1,1,1,1,1,'{\"on\":\"Показать\",\"off\":\"Скрыть\",\"checked\":\"true\"}',2),(86,12,'description','text_area','Описание',0,0,1,1,1,1,NULL,6),(87,12,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"PERCENT\",\"options\":{\"PERCENT\":\"Процент\",\"FLAT\":\"Сумма\",\"FIXED\":\"Фиксированная цена\"}}',4),(88,12,'value','number','Скидка',1,1,1,1,1,1,NULL,5),(89,12,'check_on','select_dropdown','Применить к',1,1,1,1,1,1,'{\"default\":\"CASH\",\"options\":{\"CASH\":\"Наличные\",\"INSTALLMENTS\":\"Рассрочка\",\"BOTH\":\"Везде\"}}',7),(90,12,'created_by','text','Кем создано',1,0,1,1,0,1,NULL,8),(91,12,'updated_by','text','Кем отредактировано',0,0,1,1,0,1,NULL,9),(92,12,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,10),(93,12,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,11),(94,12,'created_at','timestamp','Кем создано',0,0,0,1,0,1,NULL,12),(95,12,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,13),(96,13,'id','text','Id',1,0,0,0,0,0,NULL,1),(97,13,'name','text','Название',1,1,1,1,1,1,NULL,2),(98,13,'commission','number','Комиссия',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|regex:/^\\\\d*(\\\\.\\\\d{2})?$/\",\"messages\":{\"required\":\"Введите комиссию\",\"regex\":\"Значение от 0 до 100\"}},\"description\":\"Значение в %\"}',3),(99,13,'deadline','number','Число выплаты',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите число месяца\"}},\"description\":\"Число месяца для погашения рассрочки\"}',4),(100,13,'expires_at','date','Дата окончания рассрочки',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}},\"description\":\"Дата до которой нужно выплатить\"}',5),(101,13,'description','text_area','Описание',0,0,1,1,1,1,NULL,6),(102,13,'created_by','text','Кем создано',1,0,0,0,0,1,NULL,7),(103,13,'updated_by','text','Кем отредактировано',0,0,0,0,0,1,NULL,8),(104,13,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,9),(105,13,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,10),(106,13,'created_at','timestamp','Когда создано',0,0,0,0,0,1,NULL,11),(107,13,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,12),(108,14,'id','number','Заказ',1,1,1,1,1,0,NULL,2),(109,14,'status','select_dropdown','Статус',1,1,1,1,0,1,'{\"default\":\"NEW\",\"options\":{\"NEW\":\"Новый\",\"CONFIRMED\":\"Подтверждён\",\"PAID\":\"Оплачен\",\"RESERVED\":\"Зарезервирован\",\"CANCELED\":\"Отменен\"}}',1),(110,14,'ticket_id','number','Билет',1,1,1,0,0,1,NULL,7),(111,14,'total_price','number','Полная стоимость',1,1,1,0,0,1,NULL,5),(112,14,'payment_type','select_dropdown','Тип оплаты',1,0,1,1,0,1,'{\"default\":\"CASH\",\"options\":{\"CASH\":\"Наличные\",\"INSTALLMENTS\":\"Рассрочка\"}}',6),(113,14,'name','text','Имя',1,0,1,1,0,1,NULL,3),(114,14,'email','text','E-mail',0,0,1,1,0,1,'{\"validation\":{\"rule\":\"email\",\"messages\":{\"email\":\"E-mail неверный\"}}}',8),(115,14,'phone','number','Телефон',1,0,1,1,0,1,'{\"validation\":{\"rule\":\"required|min:3|max:13|phone:AUTO,UA\",\"messages\":{\"required\":\"Введите телефон\",\"min\":\"От 3 цифр\",\"max\":\"Не больше 13 цифр\",\"phone\":\"Неверный номер\"}},\"description\":\"Формат номера 380112222222\"}',4),(116,14,'city','text','Город',0,0,1,1,0,1,NULL,9),(117,14,'comment','text_area','Комментарий',0,0,1,0,0,1,NULL,13),(118,14,'notation','text_area','Заметка',0,0,1,1,0,1,NULL,14),(119,14,'created_by','text','Кем создано',1,0,1,0,0,1,NULL,15),(120,14,'updated_by','text','Кем отредактировано',0,0,1,0,0,1,NULL,16),(121,14,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,17),(122,14,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,18),(123,14,'created_at','timestamp','Дата',0,1,1,0,0,1,'{\"format\":\"%d.%m.%Y %H:%M:%S\"}',12),(124,14,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,19),(126,15,'id','text','Id',1,0,0,0,0,0,NULL,0),(127,15,'order_id','hidden','Order Id',1,0,0,1,1,1,NULL,2),(128,15,'type','select_dropdown','Тип',1,1,1,1,1,1,'{\"default\":\"OPTION\",\"options\":{\"DISCOUNT\":\"Скидка\",\"OPTION\":\"Опция\",\"EARLY_BIRD\":\"Ранние пташки\"}}',4),(129,15,'value','hidden','Значение',1,0,0,1,1,1,NULL,5),(130,15,'price','number','Цена',1,1,1,1,1,1,NULL,6),(131,15,'price_breakdown_belongsto_order_relationship','relationship','Заказ',0,1,1,1,1,1,'{\"model\":\"App\\\\Order\",\"table\":\"orders\",\"type\":\"belongsTo\",\"column\":\"order_id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(132,16,'id','text','№ платежа',1,1,1,1,1,0,NULL,0),(133,16,'order_id','hidden','Order Id',1,0,0,1,1,1,NULL,2),(134,16,'amount','number','Сумма',1,1,1,1,1,1,NULL,4),(135,16,'notice','text_area','Заметка',0,1,1,1,1,1,NULL,5),(136,16,'created_by','text','Кем создано',1,0,1,1,0,1,NULL,6),(137,16,'updated_by','text','Кем отредактировано',0,0,1,1,0,1,NULL,7),(138,16,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,8),(139,16,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,9),(140,16,'created_at','timestamp','Создано',0,1,1,1,0,1,'{\"format\":\"%d.%m.%Y\"}',10),(141,16,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(142,16,'payment_belongsto_order_relationship','relationship','Заказ',0,1,1,1,1,1,'{\"model\":\"App\\\\Order\",\"table\":\"orders\",\"type\":\"belongsTo\",\"column\":\"order_id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(144,10,'ticket_belongsto_user_relationship_1','relationship','Изменено',0,1,1,0,0,1,'{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"updated_by\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"data_rows\",\"pivot\":\"0\",\"taggable\":\"0\"}',16),(146,10,'ticket_belongstomany_installment_relationship','relationship','Рассрочка',0,0,1,1,1,1,'{\"model\":\"App\\\\Installment\",\"table\":\"installments\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"ticket_installments\",\"pivot\":\"1\",\"taggable\":\"0\"}',18),(147,13,'closed_at','date','Дата закрытия',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату\"}},\"description\":\"Дата закрытия возможности рассрочки\"}',5),(148,17,'id','text','Id',1,0,0,0,0,0,NULL,1),(149,17,'name','text','Имя держателя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Укажите имя держателя карты\"}}}',2),(150,17,'card_number','number','Номер карты',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|size:16|unique:cards,card_number\",\"messages\":{\"size\":\"Введите :size цифр\",\"required\":\"Укажите номер карты\",\"unique\":\"Эта карта уже есть\"}}}',3),(151,17,'note','text_area','Заметка',0,0,1,1,1,1,NULL,4),(152,17,'created_by','text','Created By',1,0,0,0,0,1,NULL,5),(153,17,'updated_by','text','Updated By',0,0,0,0,0,1,NULL,6),(154,17,'deleted_by','text','Deleted By',0,0,0,0,0,1,NULL,7),(155,17,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,8),(156,17,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,9),(157,17,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,10),(158,10,'ticket_belongstomany_card_relationship','relationship','Карты для выплат',0,0,1,1,1,1,'{\"model\":\"App\\\\Card\",\"table\":\"cards\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"full_name\",\"pivot_table\":\"ticket_cards\",\"pivot\":\"1\",\"taggable\":\"0\"}',19),(159,18,'id','text','Id',1,0,0,0,0,0,NULL,1),(160,18,'name','text','Имя',1,1,1,1,1,1,NULL,2),(161,18,'code','text','Код продавца',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|max:60|regex:/^[a-zA-Z0-9-]+$/u|unique:sellers,code\",\"messages\":{\"required\":\"Введите код продавца\",\"max\":\"Максимальное количество символов :max.\",\"unique\":\"Этот код уже существуеТ\",\"regex\":\"Допустимые символы: A-z, a-z, 0-9, _\"}}}',3),(162,18,'user_id','hidden','User Id',0,1,1,1,1,1,'{\"null\":\"Не задано\"}',4),(163,18,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,5),(164,18,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,6),(165,18,'seller_belongsto_user_relationship','relationship','Пользователь',0,1,1,1,1,1,'{\"model\":\"App\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(166,19,'id','text','Id',1,0,0,0,0,0,NULL,1),(167,19,'code','text','Код',1,1,1,1,1,1,NULL,4),(168,19,'seller_id','hidden','Seller Id',1,0,0,1,1,1,NULL,2),(169,19,'note','text_area','Заметка',0,1,1,1,1,1,NULL,5),(170,19,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,6),(171,19,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(172,19,'promo_code_belongsto_seller_relationship','relationship','Продавец',0,1,1,1,1,1,'{\"model\":\"App\\\\Seller\",\"table\":\"sellers\",\"type\":\"belongsTo\",\"column\":\"seller_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(174,14,'seller_id','number','Продавец',0,0,1,1,0,1,NULL,10),(175,14,'promocode','text','Промокод / Продавец',0,1,1,0,0,1,NULL,11),(177,14,'card_id','number','Карта оплаты',0,0,1,0,0,1,NULL,10),(178,13,'first_part','hidden','Первая часть',0,0,0,1,1,1,NULL,3),(179,14,'installment_id','number','Installment Id',0,0,0,1,0,1,NULL,10),(180,20,'id','text','Id',1,0,0,0,0,0,NULL,0),(181,20,'order_id','hidden','Order Id',1,1,1,1,1,1,NULL,2),(182,20,'priceable_type','text','Тип опции',1,1,1,1,1,1,NULL,3),(183,20,'priceable_id','text','Опция',1,1,1,1,1,1,NULL,4),(184,20,'price','text','Цена',1,1,1,1,1,1,NULL,5),(185,21,'id','text','Id',1,0,0,0,0,0,NULL,1),(186,21,'user_id','text','User Id',1,1,1,1,1,1,NULL,2),(187,21,'setting_id','text','Setting Id',1,1,1,1,1,1,NULL,3),(188,21,'value','text','Value',1,1,1,1,1,1,NULL,4),(189,21,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,5),(190,21,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,6),(191,22,'id','text','Id',1,0,0,0,0,0,NULL,1),(192,22,'ticket_id','hidden','Ticket Id',1,0,0,1,1,1,NULL,3),(193,22,'date_from','date','Дата начала',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату начала\"}}}',4),(194,22,'date_to','date','Дата окончания',1,1,1,1,1,1,'{\"format\":\"%d.%m.%Y\",\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите дату окончания\"}}}',5),(195,22,'price','number','Цена',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите цену\"}}}',6),(196,22,'created_by','hidden','Кем создано',1,0,0,0,0,1,NULL,7),(197,22,'updated_by','hidden','Updated By',0,0,0,0,0,1,NULL,8),(198,22,'deleted_by','hidden','Deleted By',0,0,0,0,0,1,NULL,9),(199,22,'deleted_at','timestamp','Deleted At',0,0,0,0,0,1,NULL,10),(200,22,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,11),(201,22,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,12),(202,13,'first_payment','number','Нулевой платеж',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите стоимость нулевого платежа\"}},\"description\":\"Нулевой платеж для внесения в течении 5 дней\"}',4),(203,22,'early_bird_belongsto_ticket_relationship','relationship','Билет',0,1,1,1,1,1,'{\"model\":\"App\\\\Ticket\",\"table\":\"tickets\",\"type\":\"belongsTo\",\"column\":\"ticket_id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',2),(204,10,'is_available','checkbox','Наличие билета',1,1,1,1,1,1,'{\"on\":\"В продаже\",\"off\":\"Недоступен\",\"checked\":\"true\"}',2),(205,10,'ticket_belongstomany_discount_relationship','relationship','Скидки',0,0,1,1,1,1,'{\"model\":\"App\\\\Discount\",\"table\":\"discounts\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"ticket_discounts\",\"pivot\":\"1\",\"taggable\":\"0\"}',20),(206,24,'ticket_id','hidden','Ticket Id',1,0,0,1,1,1,NULL,1),(207,24,'option_id','hidden','Опция',1,0,1,1,1,1,'{\"validation\":{\"rule\":\"required\"}}',2),(208,24,'group','select_dropdown','Группа',0,0,1,1,1,1,'{\"default\":\"\",\"options\":{\"1\":\"Группа 1\",\"2\":\"Группа 2\",\"3\":\"Группа 3\",\"4\":\"Группа 4\",\"5\":\"Группа 5\",\"\":\"Без группы\"}}',4),(210,24,'ticket_option_belongsto_option_relationship','relationship','Опция',0,1,1,1,1,1,'{\"model\":\"App\\\\Option\",\"table\":\"options\",\"type\":\"belongsTo\",\"column\":\"option_id\",\"key\":\"id\",\"label\":\"bill_title\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',3),(211,10,'order','hidden','Order',1,0,0,1,1,1,NULL,8),(212,25,'id','number','№',1,0,0,0,0,0,NULL,1),(213,25,'status','select_dropdown','Статус',1,1,1,1,0,1,'{\"default\":\"NEW\",\"options\":{\"PROCESSED\":\"Обработано\",\"NEW\":\"Новый\"}}',2),(214,25,'name','text','Имя',1,1,1,0,0,1,NULL,3),(215,25,'phone','text','Телефон',1,0,1,0,0,1,NULL,4),(216,25,'email','text','E-mail',1,0,1,0,0,1,NULL,5),(217,25,'question','text_area','Вопрос',0,1,1,0,0,1,NULL,6),(218,25,'note','rich_text_box','Заметка',0,0,1,1,0,1,NULL,7),(219,25,'created_at','timestamp','Создано',0,1,1,0,0,1,'{\"format\":\"%d %b\"}',8),(220,25,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,9),(221,14,'number','text','№ Заказа',1,0,1,1,1,1,NULL,2),(222,26,'id','text','Id',1,0,0,0,0,0,NULL,1),(223,26,'event_id','hidden','Event Id',1,0,0,1,1,1,NULL,2),(224,26,'title','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required|max:255\",\"messages\":{\"required\":\"Введите название\"}}}',5),(225,26,'flow_id','hidden','Flow Id',0,0,0,1,1,1,NULL,3),(226,26,'start_date','date','Дата начала',1,1,1,1,1,1,NULL,6),(227,26,'start_time','time','Время начала',0,1,1,1,1,1,NULL,7),(228,26,'end_time','time','Время окончания',0,1,1,1,1,1,NULL,8),(229,26,'created_at','timestamp','Создано',0,0,1,1,0,1,NULL,13),(230,26,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,14),(231,27,'id','text','Id',1,0,0,0,0,0,NULL,1),(232,27,'name','text','Название',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"unique:flows|required\",\"messages\":{\"required\":\"Введите название потока\",\"unique\":\"Поток уже существует\"}}}',2),(233,27,'deleted_at','timestamp','Удалено',0,0,1,0,0,1,'{\"format\":\"%d.%m.%Y\"}',5),(234,27,'created_at','timestamp','Создано',0,0,1,0,0,1,'{\"format\":\"%d.%m.%Y\"}',6),(235,27,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(236,26,'schedule_belongsto_flow_relationship','relationship','Поток',0,1,1,1,1,1,'{\"model\":\"App\\\\Flow\",\"table\":\"flows\",\"type\":\"belongsTo\",\"column\":\"flow_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',4),(237,26,'options','select_multiple','Бейдж',0,1,1,1,1,1,'{\"options\":{\"DRESS_CODE\":\"Дресс-код\"}}',10),(241,26,'description','rich_text_box','Описание',0,1,1,1,1,1,'{\"validation\":{\"rule\":\"max:65535\"}}',12),(242,26,'schedule_belongstomany_partner_relationship','relationship','Партнеры',0,1,1,1,1,1,'{\"model\":\"App\\\\Partner\",\"table\":\"partners\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"schedule_partners\",\"pivot\":\"1\",\"taggable\":\"0\"}',11),(243,26,'schedule_belongsto_event_relationship','relationship','Событие',0,1,1,1,1,1,'{\"model\":\"App\\\\Event\",\"table\":\"events\",\"type\":\"belongsTo\",\"column\":\"event_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',15),(244,4,'event_belongstomany_partner_relationship','relationship','Партнеры',0,1,1,1,1,1,'{\"model\":\"App\\\\Partner\",\"table\":\"partners\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"event_partners\",\"pivot\":\"1\",\"taggable\":\"0\"}',9),(246,28,'id','text','Id',1,0,0,0,0,0,NULL,1),(247,28,'status','select_dropdown','Статус',1,1,1,1,1,1,'{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"Черновик\",\"ACTIVE\":\"Опубликовано\"}}',2),(248,28,'slug','text','Ссылка',1,0,1,0,1,1,'{\"slugify\":{\"origin\":\"title\"}}',3),(249,28,'title','text','Заголовок',1,1,1,1,1,1,NULL,4),(250,28,'image','text','Image',0,1,1,1,1,1,NULL,5),(251,28,'excerpt','text_area','Краткое содержание',0,0,1,1,1,1,NULL,6),(252,28,'body','rich_text_box','Содержимое страницы',0,0,1,1,1,1,NULL,7),(253,28,'meta_description','text_area','Meta Description',0,0,1,1,1,1,NULL,8),(254,28,'meta_keywords','text','Meta Keywords',0,0,1,1,1,1,NULL,9),(255,28,'created_at','timestamp','Created At',0,1,1,1,0,1,NULL,10),(256,28,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(257,29,'id','text','Id',1,0,0,0,0,0,NULL,1),(258,29,'slug','text','Ссылка',1,0,1,1,1,1,'{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:speakers|required\",\"messages\":{\"required\":\"Введите ссылку\",\"unique\":\"Ссылка уже существует\"}}}',5),(259,29,'name','text','Имя',1,1,1,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Введите имя\"}}}',3),(260,29,'image','image','Фото',0,1,1,1,1,1,NULL,2),(261,29,'summary','text_area','Резюме',0,0,1,1,1,1,'{\"validation\":{\"rule\":\"max:65535\"}}',4),(262,29,'created_at','timestamp','Created At',0,0,0,1,0,1,NULL,6),(263,29,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,7),(265,27,'slug','text','Ссылка',1,0,1,0,1,1,'{\"slugify\":{\"origin\":\"name\"}}',4),(267,26,'schedule_belongstomany_person_relationship','relationship','Спикеры',0,1,1,1,1,1,'{\"model\":\"App\\\\Person\",\"table\":\"persons\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"schedule_persons\",\"pivot\":\"1\",\"taggable\":\"0\"}',9),(277,31,'id','text','Id',1,0,0,0,0,0,NULL,1),(278,31,'event_id','text','Event Id',1,0,0,1,1,1,NULL,2),(279,31,'person_id','text','Person Id',1,0,0,1,1,1,'{\"validation\":{\"rule\":\"required\",\"messages\":{\"required\":\"Выберите персону\"}}}',3),(280,31,'flow_id','text','Flow Id',0,0,0,1,1,1,NULL,4),(286,31,'created_at','timestamp','Created At',0,0,0,0,0,1,NULL,10),(287,31,'updated_at','timestamp','Updated At',0,0,0,0,0,0,NULL,11),(288,31,'event_person_belongsto_event_relationship','relationship','Событие',0,1,1,1,1,1,'{\"model\":\"App\\\\Event\",\"table\":\"events\",\"type\":\"belongsTo\",\"column\":\"event_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',5),(289,31,'event_person_belongsto_flow_relationship','relationship','Поток',0,1,1,1,1,1,'{\"model\":\"App\\\\Flow\",\"table\":\"flows\",\"type\":\"belongsTo\",\"column\":\"flow_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',6),(290,31,'event_person_belongsto_person_relationship','relationship','Персона',0,1,1,1,1,1,'{\"model\":\"App\\\\Person\",\"table\":\"persons\",\"type\":\"belongsTo\",\"column\":\"person_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"bills\",\"pivot\":\"0\",\"taggable\":\"0\"}',7),(291,31,'caption','text_area','Краткое описание',0,1,1,1,1,1,'{\"validation\":{\"rule\":\"max:255\"}}',9),(292,31,'position','select_dropdown','Позиция',1,1,1,1,1,1,'{\"default\":\"SPEAKER\",\"options\":{\"SPEAKER\":\"Спикер\",\"JUDGE\":\"Судья\",\"MAIN_JUDGE\":\"Главный судья\"}}',8),(293,9,'caption','text_area','Краткое описание',0,1,1,1,1,1,'{\"validation\":{\"rule\":\"max:255\"}}',4);
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_types`
--

LOCK TABLES `data_types` WRITE;
/*!40000 ALTER TABLE `data_types` DISABLE KEYS */;
INSERT INTO `data_types` VALUES (1,'users','users','User','Users','voyager-person','TCG\\Voyager\\Models\\User','TCG\\Voyager\\Policies\\UserPolicy','','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(2,'menus','menus','Menu','Menus','voyager-list','TCG\\Voyager\\Models\\Menu',NULL,'','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(3,'roles','roles','Role','Roles','voyager-lock','TCG\\Voyager\\Models\\Role',NULL,'','',1,0,NULL,'2018-05-19 17:46:11','2018-05-19 17:46:11'),(4,'events','events','Событие','События','voyager-calendar','App\\Event',NULL,'\\App\\Http\\Controllers\\Voyager\\EventController','События',1,1,'{\"order_column\":null,\"order_display_column\":null}','2018-06-04 20:22:50','2018-08-18 19:10:57'),(5,'speakers','speakers','Спикер','Спикеры','voyager-megaphone','App\\Speaker',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 09:49:59','2018-06-05 09:49:59'),(7,'speakers_contacts','speakers-contacts','Контакт','Контакты спикеров','voyager-list','App\\SpeakerContact',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 10:27:25','2018-06-05 10:27:25'),(8,'speeches','speeches','Доклад','Доклады','voyager-file-text','App\\Speech',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 10:51:30','2018-06-05 10:51:30'),(9,'partners','partners','Партнер','Партнеры и спонсоры','voyager-person','App\\Partner',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 13:07:01','2018-08-23 19:14:22'),(10,'tickets','tickets','Билет','Билеты','voyager-ticket','App\\Ticket',NULL,NULL,NULL,1,0,'{\"order_column\":\"order\",\"order_display_column\":\"flow\"}','2018-06-05 14:51:11','2018-07-14 18:53:15'),(11,'options','options','Опция','Опции билета','voyager-beer','App\\Option',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 15:25:44','2018-06-20 09:21:42'),(12,'discounts','discounts','Скидка','Скидки','voyager-pie-chart','App\\Discount',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 15:52:18','2018-06-05 15:52:18'),(13,'installments','installments','Рассрочка','Рассрочка','voyager-scissors','App\\Installment',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 16:07:40','2018-06-05 16:07:40'),(14,'orders','orders','Заказ','Заказы','voyager-documentation','App\\Order',NULL,'\\App\\Http\\Controllers\\Voyager\\OrderController',NULL,1,1,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 19:18:51','2018-06-22 11:39:25'),(15,'price_breakdowns','price-breakdowns','Составляющие цены','Составляющие цены','voyager-puzzle','App\\PriceBreakdown',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 19:32:20','2018-06-05 19:32:20'),(16,'payments','payments','Платеж','Платежи','voyager-dollar','App\\Payment',NULL,'\\App\\Http\\Controllers\\Voyager\\PaymentController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-05 21:00:06','2018-06-28 16:00:23'),(17,'cards','cards','Банковская карта','Банковские карты','voyager-credit-cards','App\\Card',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 09:39:55','2018-06-25 09:39:55'),(18,'sellers','sellers','Продавец','Продавцы','voyager-shop','App\\Seller',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 10:35:14','2018-06-25 10:35:14'),(19,'promo_codes','promo-codes','Промокод','Промокоды','voyager-paperclip','App\\PromoCode',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-25 10:47:03','2018-06-25 10:47:03'),(20,'bills','bills','Счет','Счета','voyager-bag','App\\Bill',NULL,'\\App\\Http\\Controllers\\Voyager\\BillController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-06-28 13:38:22','2018-06-28 15:59:51'),(21,'user_settings','user-settings','Настройка','Мои настройки','voyager-params','App\\UserSetting',NULL,'\\App\\Http\\Controllers\\Voyager\\UserSettingsController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-03 16:13:53','2018-07-03 16:19:51'),(22,'early_birds','early-birds','Ранняя пташка','Ранние пташки','voyager-twitter','App\\EarlyBird',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-05 12:53:20','2018-07-05 12:53:20'),(24,'ticket_options','ticket-options','Опция','Опции билета',NULL,'App\\TicketOption',NULL,'\\App\\Http\\Controllers\\Voyager\\TicketOptionController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-06 07:50:30','2018-07-06 10:36:11'),(25,'callback','callback','Обратная связь','Обратная связь','voyager-telephone','App\\Callback',NULL,'\\App\\Http\\Controllers\\Voyager\\CallbackController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-07-19 20:39:11','2018-07-20 10:10:56'),(26,'schedule','schedule','Программа','Программа',NULL,'App\\Schedule',NULL,'\\App\\Http\\Controllers\\Voyager\\ScheduleController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-08-17 20:03:05','2018-08-18 18:01:58'),(27,'flows','flows','Поток','Потоки',NULL,'App\\Flow',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-08-17 21:18:05','2018-08-17 21:18:05'),(28,'pages','pages','Страница','Страницы','voyager-file-text','App\\Page',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-08-20 10:15:30','2018-08-20 10:15:30'),(29,'persons','persons','Персона','Персоны','voyager-person','App\\Person',NULL,NULL,NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-08-21 12:35:14','2018-08-21 12:35:14'),(31,'event_persons','event-persons','Персона события','Персоны события','voyager-people','App\\EventPerson',NULL,'\\App\\Http\\Controllers\\Voyager\\EventPersonController',NULL,1,0,'{\"order_column\":null,\"order_display_column\":null}','2018-08-22 13:18:51','2018-08-22 15:10:28');
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `early_birds`
--

LOCK TABLES `early_birds` WRITE;
/*!40000 ALTER TABLE `early_birds` DISABLE KEYS */;
INSERT INTO `early_birds` VALUES (5,1,'2018-07-01 00:00:00','2018-08-31 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-08-10 19:16:12'),(6,2,'2018-07-01 00:00:00','2018-08-31 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-08-10 20:37:08'),(7,3,'2018-07-01 00:00:00','2018-08-31 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-08-10 20:37:30'),(8,4,'2018-07-01 00:00:00','2018-08-31 00:00:00',7500.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-08-10 20:37:49'),(9,5,'2018-07-01 00:00:00','2018-08-31 00:00:00',10000.00,1,1,NULL,NULL,'2018-07-15 18:26:29','2018-08-10 20:38:21'),(10,1,'2018-09-01 00:00:00','2018-09-30 00:00:00',7660.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(11,2,'2018-09-01 00:00:00','2018-09-30 00:00:00',7660.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(12,3,'2018-09-01 00:00:00','2018-09-30 00:00:00',7660.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(13,4,'2018-09-01 00:00:00','2018-09-30 00:00:00',7660.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(14,5,'2018-09-01 00:00:00','2018-09-30 00:00:00',10200.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(15,1,'2018-10-01 00:00:00','2018-10-31 00:00:00',7820.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(16,2,'2018-10-01 00:00:00','2018-10-31 00:00:00',7820.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(17,3,'2018-10-01 00:00:00','2018-10-31 00:00:00',7820.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(18,4,'2018-10-01 00:00:00','2018-10-31 00:00:00',7820.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(19,5,'2018-10-01 00:00:00','2018-10-31 00:00:00',10400.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(20,1,'2018-11-01 00:00:00','2018-11-30 00:00:00',7980.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(21,2,'2018-11-01 00:00:00','2018-11-30 00:00:00',7980.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(22,3,'2018-11-01 00:00:00','2018-11-30 00:00:00',7980.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(23,4,'2018-11-01 00:00:00','2018-11-30 00:00:00',7980.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(24,5,'2018-11-01 00:00:00','2018-11-30 00:00:00',10600.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(25,1,'2018-12-01 00:00:00','2018-12-31 00:00:00',8140.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(26,2,'2018-12-01 00:00:00','2018-12-31 00:00:00',8140.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(27,3,'2018-12-01 00:00:00','2018-12-31 00:00:00',8140.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(28,4,'2018-12-01 00:00:00','2018-12-31 00:00:00',8140.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37'),(29,5,'2018-12-01 00:00:00','2018-12-31 00:00:00',10800.00,1,1,NULL,NULL,'2018-08-10 17:32:37','2018-08-10 17:32:37');
/*!40000 ALTER TABLE `early_birds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_partners`
--

DROP TABLE IF EXISTS `event_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_partners` (
  `event_id` int(10) unsigned NOT NULL,
  `partner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`event_id`,`partner_id`),
  KEY `event_partners_partner_id_foreign` (`partner_id`),
  CONSTRAINT `event_partners_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_partners_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_partners`
--

LOCK TABLES `event_partners` WRITE;
/*!40000 ALTER TABLE `event_partners` DISABLE KEYS */;
INSERT INTO `event_partners` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19);
/*!40000 ALTER TABLE `event_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_persons`
--

DROP TABLE IF EXISTS `event_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  `flow_id` int(10) unsigned DEFAULT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` enum('SPEAKER','JUDGE','MAIN_JUDGE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SPEAKER',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_persons_event_id_foreign` (`event_id`),
  KEY `event_persons_person_id_foreign` (`person_id`),
  KEY `event_persons_flow_id_foreign` (`flow_id`),
  CONSTRAINT `event_persons_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_persons_flow_id_foreign` FOREIGN KEY (`flow_id`) REFERENCES `flows` (`id`) ON DELETE CASCADE,
  CONSTRAINT `event_persons_person_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_persons`
--

LOCK TABLES `event_persons` WRITE;
/*!40000 ALTER TABLE `event_persons` DISABLE KEYS */;
INSERT INTO `event_persons` VALUES (2,1,4,1,'','SPEAKER','2018-08-22 16:50:07','2018-08-22 16:50:07'),(3,1,5,1,'Преподаватель и практикующий подолог, один из разработчиков Закона о Подологии в Германии','SPEAKER','2018-08-22 16:50:38','2018-08-22 16:50:38'),(4,1,6,1,'Создатель и руководитель «Подологической Практики Ирины Егоровой»','SPEAKER','2018-08-22 16:51:20','2018-08-22 16:51:20'),(5,1,7,1,'','SPEAKER','2018-08-22 16:52:02','2018-08-22 16:52:02'),(6,1,8,1,'Основатель ногтевой школы Solo Art и Noel™','SPEAKER','2018-08-22 16:53:35','2018-08-22 16:53:35'),(7,1,9,1,'Основатель YS Nail Academy и YS Nail Salon','SPEAKER','2018-08-22 16:54:11','2018-08-22 16:54:11'),(8,1,1,2,'Шеф-технолог Lakme, совладелец компании Prof Cosmetic','SPEAKER','2018-08-22 16:54:46','2018-08-22 16:54:46'),(9,1,2,2,'Технолог по стилю Lakme','SPEAKER','2018-08-22 16:55:28','2018-08-22 16:55:28'),(10,1,3,2,'Шеф-колорист Lakme в Украине','SPEAKER','2018-08-22 16:56:05','2018-08-22 16:56:05'),(11,1,10,3,'Основатель A-Priori Beauty Bar и A-Priori Beauty Institute','SPEAKER','2018-08-22 17:13:37','2018-08-22 17:13:37'),(13,1,11,3,'Сооснователь ELAN™ и Международной Ассоциации Бровистов','SPEAKER','2018-08-22 17:19:21','2018-08-22 17:19:21'),(14,1,12,3,'Cтилист, визажист, парикмахер, гример и имиджмейкер. Основатель Академии макияжа Максима Гилева «MGA»','SPEAKER','2018-08-22 17:20:55','2018-08-22 17:21:54'),(15,1,13,4,'Сооснователь ELAN™ и совладелeц обучающего центра Академия карьеры салонного бизнеса «Руки-Ножницы»','SPEAKER','2018-08-22 17:23:08','2018-08-22 17:23:08'),(16,4,1,NULL,'','MAIN_JUDGE','2018-08-22 18:47:11','2018-08-22 18:47:11'),(17,4,2,NULL,'','JUDGE','2018-08-22 18:47:28','2018-08-22 18:47:28');
/*!40000 ALTER TABLE `event_persons` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'molfar-forum-2019','Molfar Beauty Forum 2019','2019-05-12 00:00:00','2019-05-16 00:00:00','Буковель','2018-06-04 20:36:00','2018-08-23 13:44:50'),(4,'dream-team','Dream Team 2019','2019-05-14 00:00:00','2019-05-15 00:00:00','Буковель','2018-08-21 13:57:00','2018-08-23 13:43:10');
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
-- Table structure for table `flows`
--

DROP TABLE IF EXISTS `flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flows` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `flows_name_unique` (`name`),
  UNIQUE KEY `flows_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flows`
--

LOCK TABLES `flows` WRITE;
/*!40000 ALTER TABLE `flows` DISABLE KEYS */;
INSERT INTO `flows` VALUES (1,'Маникюр','manicure',NULL,NULL,NULL),(2,'Парикмахерство','hairdressers',NULL,NULL,NULL),(3,'Визаж','visage',NULL,NULL,NULL),(4,'Менеджмент','management',NULL,NULL,NULL),(5,'Dream Team','dream-team',NULL,NULL,NULL),(6,'Судьи','sud-i','2018-08-21 21:27:07','2018-08-21 12:54:34','2018-08-21 21:27:07');
/*!40000 ALTER TABLE `flows` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (1,1,'Панель управления','','_self','voyager-boat','#000000',NULL,1,'2018-05-19 17:46:11','2018-06-21 12:25:07','voyager.dashboard','null'),(2,1,'Галерея','','_self','voyager-images','#000000',5,1,'2018-05-19 17:46:11','2018-06-04 20:06:11','voyager.media.index','null'),(3,1,'Пользователи','','_self','voyager-person','#000000',5,2,'2018-05-19 17:46:11','2018-06-04 20:06:11','voyager.users.index','null'),(4,1,'Роли','','_self','voyager-lock','#000000',5,3,'2018-05-19 17:46:12','2018-06-04 20:06:11','voyager.roles.index','null'),(5,1,'Инструменты','','_self','voyager-tools','#000000',NULL,6,'2018-05-19 17:46:12','2018-08-20 10:17:48',NULL,''),(6,1,'Меню','','_self','voyager-list','#000000',5,4,'2018-05-19 17:46:12','2018-08-20 10:17:55','voyager.menus.index','null'),(7,1,'База данных','','_self','voyager-data','#000000',5,7,'2018-05-19 17:46:12','2018-08-20 10:17:48','voyager.database.index','null'),(8,1,'Compass','','_self','voyager-compass',NULL,5,8,'2018-05-19 17:46:12','2018-08-20 10:17:48','voyager.compass.index',NULL),(9,1,'BREAD','','_self','voyager-bread',NULL,5,9,'2018-05-19 17:46:12','2018-08-20 10:17:48','voyager.bread.index',NULL),(10,1,'Настройки','','_self','voyager-settings','#000000',NULL,7,'2018-05-19 17:46:12','2018-08-20 10:17:48','voyager.settings.index','null'),(11,1,'Hooks','','_self','voyager-hook',NULL,5,10,'2018-05-19 17:46:12','2018-08-20 10:17:48','voyager.hooks',NULL),(12,1,'События','','_self','voyager-calendar','#000000',NULL,2,'2018-06-04 20:22:50','2018-08-09 20:06:20','voyager.events.index','null'),(15,1,'Доклады','','_self',NULL,'#000000',12,5,'2018-06-05 10:51:30','2018-08-22 11:01:50','voyager.speeches.index','null'),(16,1,'Партнеры','','_self',NULL,'#000000',12,4,'2018-06-05 13:07:01','2018-08-22 11:01:50','voyager.partners.index','null'),(17,1,'Билеты','','_self',NULL,'#000000',25,1,'2018-06-05 14:51:11','2018-08-09 20:07:00','voyager.tickets.index','null'),(18,1,'Опции','','_self',NULL,'#000000',25,2,'2018-06-05 15:25:44','2018-07-12 10:14:08','voyager.options.index','null'),(19,1,'Скидки','','_self',NULL,'#000000',25,3,'2018-06-05 15:52:19','2018-07-12 10:14:23','voyager.discounts.index','null'),(20,1,'Рассрочка','','_self',NULL,'#000000',25,4,'2018-06-05 16:07:41','2018-07-12 10:14:41','voyager.installments.index','null'),(21,1,'Заказы','','_self','voyager-documentation','#000000',NULL,4,'2018-06-05 19:18:52','2018-08-09 20:05:29','voyager.orders.index','null'),(25,1,'Билеты','','_self','voyager-bookmark','#000000',NULL,3,'2018-06-20 18:09:19','2018-08-09 20:06:02',NULL,''),(26,1,'Банковские карты','','_self',NULL,'#000000',25,5,'2018-06-25 09:39:55','2018-07-12 10:15:03','voyager.cards.index','null'),(27,1,'Продавцы','','_self',NULL,'#000000',25,6,'2018-06-25 10:35:14','2018-07-12 10:15:18','voyager.sellers.index','null'),(30,1,'Новые заказы','','_self',NULL,'#000000',29,1,'2018-06-25 16:53:30','2018-06-25 16:54:49','voyager.orders.index','{\r\n\"status\":\"new\"\r\n}'),(31,1,'Рассрочка','','_self',NULL,'#000000',29,2,'2018-06-25 16:56:39','2018-06-25 16:57:06','voyager.orders.index','{\r\n\"payment_type\":\"INSTALLMENTS\"\r\n}'),(32,1,'Мои настройки','','_self','voyager-params',NULL,5,6,'2018-07-03 16:13:53','2018-08-20 10:17:55','voyager.user-settings.index',NULL),(33,1,'Ранние пташки','','_self',NULL,'#000000',25,7,'2018-07-05 12:53:20','2018-08-19 09:09:05','voyager.early-birds.index','null'),(35,1,'Обратная связь','/home/callback','_self','voyager-telephone','#000000',NULL,5,'2018-07-19 20:39:12','2018-07-27 15:55:04',NULL,''),(37,1,'Потоки','','_self',NULL,'#000000',12,6,'2018-08-17 21:18:05','2018-08-22 11:01:50','voyager.flows.index','null'),(38,1,'Страницы','','_self','voyager-file-text',NULL,5,5,'2018-08-20 10:15:30','2018-08-20 10:17:55','voyager.pages.index',NULL),(39,1,'События','','_self',NULL,'#000000',12,1,'2018-08-20 10:18:35','2018-08-20 10:18:54','voyager.events.index',NULL),(40,1,'Персоны','','_self',NULL,'#000000',12,2,'2018-08-21 12:35:14','2018-08-21 12:40:49','voyager.persons.index','null'),(41,1,'Судьи','','_self',NULL,NULL,12,3,'2018-08-22 10:59:05','2018-08-22 11:01:50','voyager.judges.index',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2016_01_01_000000_add_voyager_user_fields',1),(4,'2016_01_01_000000_create_data_types_table',1),(5,'2016_05_19_173453_create_menu_table',1),(6,'2016_10_21_190000_create_roles_table',1),(7,'2016_10_21_190000_create_settings_table',1),(8,'2016_11_30_135954_create_permission_table',1),(9,'2016_11_30_141208_create_permission_role_table',1),(10,'2016_12_26_201236_data_types__add__server_side',1),(11,'2017_01_13_000000_add_route_to_menu_items_table',1),(12,'2017_01_14_005015_create_translations_table',1),(13,'2017_01_15_000000_make_table_name_nullable_in_permissions_table',1),(14,'2017_03_06_000000_add_controller_to_data_types_table',1),(15,'2017_04_21_000000_add_order_to_data_rows_table',1),(16,'2017_07_05_210000_add_policyname_to_data_types_table',1),(17,'2017_08_05_000000_add_group_to_settings_table',1),(18,'2017_11_26_013050_add_user_role_relationship',1),(19,'2017_11_26_015000_create_user_roles_table',1),(20,'2018_03_11_000000_add_user_settings',1),(21,'2018_03_14_000000_add_details_to_data_types_table',1),(22,'2018_03_16_000000_make_settings_value_nullable',1),(23,'2018_05_30_171335_create_sessions_table',2),(25,'2018_06_01_101943_create_events_table',3),(26,'2018_06_01_102555_create_speakers_table',3),(27,'2018_06_01_104016_create_speakers_contacts_table',4),(28,'2018_06_01_112030_create_speeches_table',5),(29,'2018_06_01_121751_create_event_speeches_table',5),(30,'2018_06_01_122315_create_partners_table',6),(32,'2018_06_01_124626_create_tickets_table',7),(33,'2018_06_01_131407_create_options_table',8),(34,'2018_06_01_132841_create_ticket_options_table',9),(35,'2018_06_01_133222_create_early_birds_table',10),(36,'2018_06_01_140026_create_orders_table',11),(37,'2018_06_01_175922_create_order_options_table',12),(38,'2018_06_01_180940_create_payments_table',13),(39,'2018_06_03_134310_create_discounts_table',14),(40,'2018_06_03_140615_create_ticket_discounts_table',15),(43,'2018_06_03_143223_create_price_breakdowns_table',18),(44,'2018_06_03_141121_create_installments_table',19),(45,'2018_06_03_142920_create_ticket_installments_table',19),(46,'2018_06_08_153159_create_pages_table',20),(47,'2018_06_19_165922_add_type_ticket_to_price_breakdowns_table',21),(48,'2018_06_19_180753_drop_price_breakdowns_table',22),(50,'2018_06_19_181201_create_price_breakdowns_table',23),(51,'2018_06_19_194947_create_bills_table',24),(56,'2018_06_24_135156_create_cards_table',26),(57,'2018_06_24_135315_create_ticket_cards_table',26),(58,'2018_06_24_131838_create_sellers_table',27),(59,'2018_06_24_134730_create_promo_codes_table',27),(60,'2018_06_25_123800_add_promocode_to_orders_table',28),(61,'2018_06_25_124127_add_seller_id_to_orders_table',29),(63,'2018_06_25_130213_add_first_payment_to_installments_table',30),(64,'2018_06_26_094416_add_card_id_to_orders_table',31),(65,'2018_06_27_080133_add_installment_id_to_orders_table',32),(66,'2018_06_27_113432_rename_first_payment_to_installments_table',33),(67,'2018_07_01_122828_create_user_settings_table',34),(68,'2018_07_01_135053_create_jobs_table',35),(69,'2018_07_05_122656_add_is_available_to_tickets_table',36),(70,'2018_07_05_123645_add_first_payment_to_installments_table',37),(71,'2018_07_06_071211_add_group_to_ticket_options_table',38),(72,'2018_07_13_153104_add_number_to_orders_table',39),(73,'2018_07_13_153444_add_order_to_tickets_table',40),(74,'2018_07_19_191920_create_callback_table',41),(76,'2018_07_25_124307_alter_status_enum_to_orders_table',42),(77,'2018_07_25_222126_create_order_logs_table',43),(78,'2018_07_26_164626_create_failed_jobs_table',44),(79,'2018_08_17_190847_create_flows_table',45),(88,'2018_08_18_130020_alter_slug_unique_to_speakers_table',47),(89,'2018_08_17_191838_create_schedule_table',48),(90,'2018_08_18_112725_create_schedule_speakers_table',48),(91,'2018_08_18_143530_create_schedule_partners_table',49),(92,'2018_08_19_092444_alter_name_unique_to_partners',50),(93,'2018_08_19_093546_alter_link_nullable_to_partners',51),(94,'2018_08_20_091056_create_event_partners_table',52),(97,'2018_08_20_190515_rename_speakers_to_persons_table',54),(98,'2018_08_20_091242_create_flow_persons_table',55),(99,'2018_08_20_191354_add_slug_to_flows_table',56),(100,'2018_08_20_192426_create_event_flows_table',57),(101,'2018_08_21_130344_rename_schedule_speakers_to_schedule_persons',58),(102,'2018_08_21_131502_rename_speaker_id_to_person_id_schedule_persons_table',59),(103,'2018_08_21_224635_create_judges_table',60),(105,'2018_08_22_125523_create_event_persons_table',61),(106,'2018_08_23_190740_add_caption_to_partners_table',62);
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
INSERT INTO `options` VALUES (1,'Общий номер','ACCOMMODATION',0.00,5,1,1,NULL,NULL,'2018-06-20 09:18:29','2018-07-06 21:21:53'),(2,'Одиночный номер','ACCOMMODATION',1500.00,999,1,1,NULL,NULL,'2018-06-20 09:22:40','2018-07-15 18:21:48'),(3,'Все лекции на потоке «Маникюр»','INCLUSIVE',NULL,65535,1,1,NULL,NULL,'2018-07-06 19:21:33','2018-07-06 19:21:33'),(4,'Завтраки и вечеринки','INCLUSIVE',NULL,65535,1,1,NULL,NULL,'2018-07-06 19:22:48','2018-07-27 19:00:29'),(5,'Все лекции на потоке «Визаж»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:29:53','2018-07-12 11:29:53'),(6,'Все лекции на потоке «Парикмахерство»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:30:47','2018-07-12 11:30:47'),(7,'Все лекции на потоке «Менеджмент»','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:31:17','2018-07-12 11:31:17'),(8,'Все лекции и семинары','INCLUSIVE',0.00,0,1,1,NULL,NULL,'2018-07-12 11:31:59','2018-07-12 11:31:59');
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
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partners_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partners`
--

LOCK TABLES `partners` WRITE;
/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'C-lab','[{\"download_link\":\"partners\\/August2018\\/i1YpQbs96jozgt1lYEEb.svg\",\"original_name\":\"c-lab.svg\"}]',NULL,'https://c-lab.store/'),(2,'A Priori','[{\"download_link\":\"partners\\/August2018\\/oKpPiaHMe7g4L1OPuvoe.svg\",\"original_name\":\"apriori.svg\"}]',NULL,'https://apriori.od.ua/'),(3,'Adore','[{\"download_link\":\"partners\\/August2018\\/awdR3ggxyf2rkfGGibqJ.svg\",\"original_name\":\"adore.svg\"}]',NULL,'http://www.adore-professional.com.ua/'),(4,'Ирина Егорова','[{\"download_link\":\"partners\\/August2018\\/CJmQ3DtZ3NLzwgf5nTJH.svg\",\"original_name\":\"egorova.svg\"}]',NULL,'https://podolog.dp.ua/'),(5,'Elan','[{\"download_link\":\"partners\\/August2018\\/kea16LT7z1UfZxRcXrJo.svg\",\"original_name\":\"elan.svg\"}]',NULL,'https://elanofficial.com/'),(6,'Hairgum','[{\"download_link\":\"partners\\/August2018\\/R0gy3rmDhTgY3ndHkliv.svg\",\"original_name\":\"hairgum.svg\"}]',NULL,'https://www.instagram.com/hairgum_crew_ua/'),(7,'Анна Кравченко','[{\"download_link\":\"partners\\/August2018\\/JiFeIixZTalk0DQGsTOn.svg\",\"original_name\":\"kravchenko.svg\"}]',NULL,'https://kravchenko-anna.com/'),(8,'Lakme','[{\"download_link\":\"partners\\/August2018\\/vZxZQlKPC6DsC8AW9p5c.svg\",\"original_name\":\"lakme.svg\"}]',NULL,'https://www.facebook.com/lakmeteamua/'),(9,'Максим Гилёв','[{\"download_link\":\"partners\\/August2018\\/6gnymgZbdbRRgh86Gi9b.svg\",\"original_name\":\"maxim-gilyov.svg\"}]',NULL,'https://www.instagram.com/maxim_gilyov/'),(10,'Nouvelle','[{\"download_link\":\"partners\\/August2018\\/0IMvh45MmJ8xqn1DeIU6.svg\",\"original_name\":\"nouvelle.svg\"}]',NULL,'http://nouvelle.net.ua/'),(11,'Orising','[{\"download_link\":\"partners\\/August2018\\/Rfg2TB5kv3eiaFb5v74s.svg\",\"original_name\":\"orising.svg\"}]',NULL,'http://orising.com.ua/'),(12,'Permanent Makeup Beauty Academy','[{\"download_link\":\"partners\\/August2018\\/9dRT8CC3ZNa2cveH43nv.svg\",\"original_name\":\"pmu.svg\"}]',NULL,NULL),(13,'Prof Cosmetic','[{\"download_link\":\"partners\\/August2018\\/PvmVk4X7PXrP0mf5tdxn.svg\",\"original_name\":\"prof-cosmetic.svg\"}]',NULL,'http://profcosmetic.if.ua/'),(14,'Руки-Ножницы','[{\"download_link\":\"partners\\/August2018\\/iVQ7onr0PEbL9bdqIIxC.svg\",\"original_name\":\"ruki-nozhnicy.svg\"}]',NULL,'https://ruki-nozhnitsi.com.ua/'),(15,'Учебный центр Ксении Сакелари','[{\"download_link\":\"partners\\/August2018\\/YOSd3hk0sqt01badILQB.svg\",\"original_name\":\"sakelari.svg\"}]',NULL,'http://sakelary.com/'),(16,'SNB','[{\"download_link\":\"partners\\/August2018\\/H1u9y7SxRAHnLn2xPoP5.svg\",\"original_name\":\"snb.svg\"}]',NULL,'http://snb.bg/'),(17,'Solo Art','[{\"download_link\":\"partners\\/August2018\\/ShJs7kfefdy0MebiRhH4.svg\",\"original_name\":\"solo-art.svg\"}]',NULL,'https://vk.com/club90949398'),(18,'Yuliya Stadnik','[{\"download_link\":\"partners\\/August2018\\/PqJwNLZ3W0n2R09u5Xbr.svg\",\"original_name\":\"stadnik.svg\"}]',NULL,'http://ysnailacademy.com/'),(19,'Voynova Style','[{\"download_link\":\"partners\\/August2018\\/xVp1hXGYPabcDsSiIA37.svg\",\"original_name\":\"voynova.svg\"}]',NULL,'https://www.voynovastyle.com/');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `permission_role` VALUES (1,1),(1,4),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(52,4),(53,1),(54,1),(54,4),(55,1),(55,4),(56,1),(57,1),(57,4),(58,1),(59,1),(59,4),(60,1),(60,4),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(67,4),(68,1),(69,1),(69,4),(70,1),(70,4),(71,1),(72,1),(72,3),(72,4),(73,1),(73,3),(73,4),(74,1),(74,4),(76,1),(82,1),(82,4),(83,1),(83,4),(84,1),(84,4),(85,1),(85,4),(86,1),(87,1),(87,4),(88,1),(88,4),(89,1),(89,4),(90,1),(90,4),(91,1),(91,4),(92,1),(92,4),(93,1),(93,4),(94,1),(94,4),(95,1),(95,4),(96,1),(96,4),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(102,4),(103,1),(103,4),(104,1),(104,4),(105,1),(105,4),(106,1),(106,4),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(112,4),(113,1),(113,4),(114,1),(114,4),(115,1),(115,4),(116,1),(117,1),(117,4),(118,1),(119,1),(119,4),(120,1),(120,4),(121,1),(122,1),(122,4),(124,1),(124,4),(126,1),(126,4),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(152,1),(153,1),(154,1),(155,1),(156,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'browse_admin',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(2,'browse_bread',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(3,'browse_database',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(4,'browse_media',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(5,'browse_compass',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(6,'browse_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(7,'read_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(8,'edit_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(9,'add_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(10,'delete_menus','menus','2018-05-19 17:46:12','2018-05-19 17:46:12'),(11,'browse_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(12,'read_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(13,'edit_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(14,'add_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(15,'delete_roles','roles','2018-05-19 17:46:12','2018-05-19 17:46:12'),(16,'browse_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(17,'read_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(18,'edit_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(19,'add_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(20,'delete_users','users','2018-05-19 17:46:12','2018-05-19 17:46:12'),(21,'browse_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(22,'read_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(23,'edit_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(24,'add_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(25,'delete_settings','settings','2018-05-19 17:46:12','2018-05-19 17:46:12'),(26,'browse_hooks',NULL,'2018-05-19 17:46:12','2018-05-19 17:46:12'),(27,'browse_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(28,'read_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(29,'edit_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(30,'add_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(31,'delete_events','events','2018-06-04 20:22:50','2018-06-04 20:22:50'),(32,'browse_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(33,'read_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(34,'edit_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(35,'add_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(36,'delete_speakers','speakers','2018-06-05 09:49:59','2018-06-05 09:49:59'),(37,'browse_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(38,'read_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(39,'edit_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(40,'add_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(41,'delete_speakers_contacts','speakers_contacts','2018-06-05 10:27:25','2018-06-05 10:27:25'),(42,'browse_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(43,'read_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(44,'edit_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(45,'add_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(46,'delete_speeches','speeches','2018-06-05 10:51:30','2018-06-05 10:51:30'),(47,'browse_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(48,'read_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(49,'edit_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(50,'add_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(51,'delete_partners','partners','2018-06-05 13:07:01','2018-06-05 13:07:01'),(52,'browse_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(53,'read_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(54,'edit_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(55,'add_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(56,'delete_tickets','tickets','2018-06-05 14:51:11','2018-06-05 14:51:11'),(57,'browse_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(58,'read_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(59,'edit_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(60,'add_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(61,'delete_options','options','2018-06-05 15:25:44','2018-06-05 15:25:44'),(62,'browse_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(63,'read_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(64,'edit_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(65,'add_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(66,'delete_discounts','discounts','2018-06-05 15:52:19','2018-06-05 15:52:19'),(67,'browse_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(68,'read_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(69,'edit_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(70,'add_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(71,'delete_installments','installments','2018-06-05 16:07:41','2018-06-05 16:07:41'),(72,'browse_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(73,'read_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(74,'edit_orders','orders','2018-06-05 19:18:51','2018-06-05 19:18:51'),(76,'delete_orders','orders','2018-06-05 19:18:52','2018-06-05 19:18:52'),(82,'browse_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(83,'read_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(84,'edit_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(85,'add_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(86,'delete_payments','payments','2018-06-05 21:00:07','2018-06-05 21:00:07'),(87,'browse_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(88,'read_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(89,'edit_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(90,'add_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(91,'delete_cards','cards','2018-06-25 09:39:55','2018-06-25 09:39:55'),(92,'browse_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(93,'read_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(94,'edit_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(95,'add_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(96,'delete_sellers','sellers','2018-06-25 10:35:14','2018-06-25 10:35:14'),(97,'browse_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(98,'read_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(99,'edit_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(100,'add_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(101,'delete_promo_codes','promo_codes','2018-06-25 10:47:03','2018-06-25 10:47:03'),(102,'browse_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(103,'read_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(104,'edit_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(105,'add_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(106,'delete_bills','bills','2018-06-28 13:38:22','2018-06-28 13:38:22'),(107,'browse_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(108,'read_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(109,'edit_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(110,'add_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(111,'delete_user_settings','user_settings','2018-07-03 16:13:53','2018-07-03 16:13:53'),(112,'browse_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(113,'read_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(114,'edit_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(115,'add_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(116,'delete_early_birds','early_birds','2018-07-05 12:53:20','2018-07-05 12:53:20'),(117,'browse_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(118,'read_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(119,'edit_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(120,'add_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(121,'delete_ticket_options','ticket_options','2018-07-06 07:50:30','2018-07-06 07:50:30'),(122,'browse_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(123,'read_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(124,'edit_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(126,'delete_callback','callback','2018-07-19 20:39:12','2018-07-19 20:39:12'),(127,'browse_schedule','schedule','2018-08-17 20:03:05','2018-08-17 20:03:05'),(128,'read_schedule','schedule','2018-08-17 20:03:05','2018-08-17 20:03:05'),(129,'edit_schedule','schedule','2018-08-17 20:03:05','2018-08-17 20:03:05'),(130,'add_schedule','schedule','2018-08-17 20:03:05','2018-08-17 20:03:05'),(131,'delete_schedule','schedule','2018-08-17 20:03:05','2018-08-17 20:03:05'),(132,'browse_flows','flows','2018-08-17 21:18:05','2018-08-17 21:18:05'),(133,'read_flows','flows','2018-08-17 21:18:05','2018-08-17 21:18:05'),(134,'edit_flows','flows','2018-08-17 21:18:05','2018-08-17 21:18:05'),(135,'add_flows','flows','2018-08-17 21:18:05','2018-08-17 21:18:05'),(136,'delete_flows','flows','2018-08-17 21:18:05','2018-08-17 21:18:05'),(137,'browse_pages','pages','2018-08-20 10:15:30','2018-08-20 10:15:30'),(138,'read_pages','pages','2018-08-20 10:15:30','2018-08-20 10:15:30'),(139,'edit_pages','pages','2018-08-20 10:15:30','2018-08-20 10:15:30'),(140,'add_pages','pages','2018-08-20 10:15:30','2018-08-20 10:15:30'),(141,'delete_pages','pages','2018-08-20 10:15:30','2018-08-20 10:15:30'),(142,'browse_persons','persons','2018-08-21 12:35:14','2018-08-21 12:35:14'),(143,'read_persons','persons','2018-08-21 12:35:14','2018-08-21 12:35:14'),(144,'edit_persons','persons','2018-08-21 12:35:14','2018-08-21 12:35:14'),(145,'add_persons','persons','2018-08-21 12:35:14','2018-08-21 12:35:14'),(146,'delete_persons','persons','2018-08-21 12:35:14','2018-08-21 12:35:14'),(152,'browse_event_persons','event_persons','2018-08-22 13:18:52','2018-08-22 13:18:52'),(153,'read_event_persons','event_persons','2018-08-22 13:18:52','2018-08-22 13:18:52'),(154,'edit_event_persons','event_persons','2018-08-22 13:18:52','2018-08-22 13:18:52'),(155,'add_event_persons','event_persons','2018-08-22 13:18:52','2018-08-22 13:18:52'),(156,'delete_event_persons','event_persons','2018-08-22 13:18:52','2018-08-22 13:18:52');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persons`
--

DROP TABLE IF EXISTS `persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `speakers_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persons`
--

LOCK TABLES `persons` WRITE;
/*!40000 ALTER TABLE `persons` DISABLE KEYS */;
INSERT INTO `persons` VALUES (1,'sergej-kormakov','Сергей Кормаков','persons/August2018/TTfYZpaXDEjffZV1rkLv.jpg','Шеф-технолог Lakme, совладелец компании Prof Cosmetic','2018-06-05 09:54:00','2018-08-21 18:58:51'),(2,'ol-ga-zagorovskaya','Ольга Загоровская','persons/August2018/hSf4b0hbY17kIqTHp7RW.jpg','Технолог по стилю Lakme','2018-06-05 12:43:00','2018-08-21 18:58:19'),(3,'nadezhda-svishuk','Надежда Свищук','persons/August2018/NKwqyS1r04rCup1tmsVG.jpg','Шеф-колорист Lakme в Украине','2018-06-05 12:44:00','2018-08-21 18:57:24'),(4,'viktoriya-matveeva','Виктория Матвеева','persons/August2018/TDq9iiewqv7c7dxsBnAg.jpg','','2018-08-18 12:54:00','2018-08-21 18:59:15'),(5,'diter-baumann','Дитер Бауманн','persons/August2018/2WrPji5RCKySEKjYhcYb.jpg','Преподаватель и практикующий подолог, один из разработчиков Закона о Подологии в Германии','2018-08-18 12:54:00','2018-08-21 18:59:43'),(6,'irina-egorova','Ирина Егорова','persons/August2018/UEIvd1qHO3c5hx1eBiYj.jpg','Создатель и руководитель «Подологической Практики Ирины Егоровой»','2018-08-18 12:55:00','2018-08-21 19:00:34'),(7,'kseniya-sakelari','Ксения Сакелари','persons/August2018/TnZMzuWyZE7aLZf95nV9.jpg','','2018-08-18 13:02:00','2018-08-21 19:03:09'),(8,'tat-yana-solov-yova','Татьяна Соловьёва','persons/August2018/XsLHPYRBqwq0VwUElX0L.jpg','Основатель ногтевой школы Solo Art и Noel™','2018-08-18 13:03:00','2018-08-21 19:03:49'),(9,'yuliya-stadnik','Юлия Стадник','persons/August2018/7zeWviy6iX1v3p66SgUz.jpg','Основатель YS Nail Academy и YS Nail Salon','2018-08-18 13:03:00','2018-08-21 19:04:21'),(10,'alyona-antonova','Алёна Антонова','persons/August2018/1lXoI46D4u2GNvqf847v.jpg','Основатель A-Priori Beauty Bar и A-Priori Beauty Institute','2018-08-18 13:03:00','2018-08-21 19:05:09'),(11,'anna-kravchenko','Анна Кравченко','persons/August2018/cVvQdq54UBCzdbgR79SI.jpg','Сооснователь ELAN™ и Международной Ассоциации Бровистов','2018-08-18 13:04:00','2018-08-21 19:05:36'),(12,'maksim-gilyov','Максим Гилёв','persons/August2018/j3cRTMZhmPeMf75txLMZ.jpg','Cтилист, визажист, парикмахер, гример и имиджмейкер. Основатель Академии макияжа Максима Гилева «MGA»','2018-08-18 13:04:00','2018-08-21 19:06:05'),(13,'elena-kurchina','Елена Курчина','persons/August2018/DtC0gDzgPANaeBpGhmoQ.jpg','Сооснователь ELAN™ и совладелeц обучающего центра Академия карьеры салонного бизнеса «Руки-Ножницы»','2018-08-18 13:05:00','2018-08-21 19:06:34'),(14,'bogdan-rafal-skij','Богдан Рафальский',NULL,'','2018-08-19 10:53:25','2018-08-19 10:53:25'),(15,'il-ya-yalovenko','Илья Яловенко',NULL,'','2018-08-19 10:53:38','2018-08-19 10:53:38'),(16,'inga-kaval-chinske','Инга Кавальчинске',NULL,'','2018-08-19 14:55:17','2018-08-19 14:55:17'),(17,'ol-ga-kolesnik','Ольга Колесник',NULL,'','2018-08-19 15:06:18','2018-08-19 15:06:18'),(18,'komanda-tehnologov-snb-ukraina','Команда технологов SNB Украина',NULL,'','2018-08-19 16:08:12','2018-08-19 16:08:12');
/*!40000 ALTER TABLE `persons` ENABLE KEYS */;
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
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flow_id` int(10) unsigned DEFAULT NULL,
  `start_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `options` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedule_flow_id_foreign` (`flow_id`),
  KEY `schedule_event_id_foreign` (`event_id`),
  CONSTRAINT `schedule_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedule_flow_id_foreign` FOREIGN KEY (`flow_id`) REFERENCES `flows` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (4,1,'Заезд и раcселение',NULL,'2019-05-12','15:00:00','17:00:00',NULL,'','2018-08-19 10:45:21','2018-08-19 10:45:21'),(5,1,'Официальное открытие',NULL,'2019-05-12','18:00:00','18:30:00',NULL,'','2018-08-19 10:46:00','2018-08-20 09:19:48'),(6,1,'Карпатская вечеринка',NULL,'2019-05-12','19:00:00',NULL,'[\"DRESS_CODE\"]','Дресс-код: национальная одежда','2018-08-19 10:47:17','2018-08-19 10:47:17'),(68,1,'Завтраки',NULL,'2019-05-16','07:00:00','10:00:00',NULL,'','2018-08-19 15:09:51','2018-08-19 15:09:51'),(69,1,'Выезд',NULL,'2019-05-16','12:00:00',NULL,NULL,'','2018-08-19 15:10:16','2018-08-19 15:10:16'),(70,1,'Завтраки',2,'2019-05-13','07:00:00','10:00:00',NULL,'','2018-08-21 14:27:42','2018-08-21 14:27:42'),(71,1,'Cеминар от компании Hairgum',2,'2019-05-13','11:00:00','14:00:00',NULL,'','2018-08-21 14:29:00','2018-08-21 14:30:00'),(72,1,'Перерыв',2,'2019-05-13','14:00:00','15:00:00',NULL,'','2018-08-21 14:30:41','2018-08-21 14:30:41'),(73,1,'Будет объявлено позже',2,'2019-05-13','15:00:00','18:00:00',NULL,'','2018-08-21 14:31:31','2018-08-21 14:31:31'),(74,1,'Вечернее шоу от Voynova Style',2,'2019-05-13','20:00:00',NULL,NULL,'','2018-08-21 14:32:16','2018-08-21 14:32:16'),(75,1,'Завтраки',1,'2019-05-13','07:00:00','10:00:00',NULL,'','2018-08-21 14:33:04','2018-08-21 14:33:04'),(76,1,'Трендовые дизайны маникюра: весна-лето 2019',1,'2019-05-13','11:00:00','13:00:00',NULL,'','2018-08-21 14:33:49','2018-08-21 14:33:49'),(77,1,'Перерыв',1,'2019-05-13','13:00:00','13:30:00',NULL,'','2018-08-21 14:35:15','2018-08-21 14:35:15'),(78,1,'Cеминар от Yuliya Stadnik Nail Academy',1,'2019-05-13','13:30:00','15:30:00',NULL,'','2018-08-21 14:36:20','2018-08-21 14:36:20'),(79,1,'Перерыв',1,'2019-05-13','15:30:00','16:00:00',NULL,'','2018-08-21 14:43:00','2018-08-21 14:43:00'),(80,1,'Cеминар от компании SNB',1,'2019-05-13','16:00:00','18:00:00',NULL,'','2018-08-21 14:46:15','2018-08-21 14:46:15'),(81,1,' Вечернее шоу от Voynova Style',1,'2019-05-13','20:00:00',NULL,NULL,'','2018-08-21 14:47:09','2018-08-21 14:47:09'),(82,1,'Завтраки',3,'2019-05-13','07:00:00','10:00:00',NULL,'','2018-08-24 09:50:47','2018-08-24 09:50:47'),(83,1,'Cеминар от компании Elan',3,'2019-05-13','11:00:00','13:00:00',NULL,'','2018-08-24 09:51:00','2018-08-24 09:53:10'),(84,1,'Перерыв',3,'2019-05-13','13:00:00','13:30:00',NULL,'','2018-08-24 09:54:02','2018-08-24 09:54:02'),(85,1,'Аэрограф в макияже',3,'2019-05-13','13:30:00','15:30:00',NULL,'','2018-08-24 09:55:08','2018-08-24 09:55:08'),(86,1,'Перерыв',3,'2019-05-13','15:30:00','16:00:00',NULL,'','2018-08-24 09:55:41','2018-08-24 09:55:41'),(87,1,'Текстурный макияж, применение различного инструментария и продуктов для получения креативных эффектов',3,'2019-05-13','16:00:00','18:00:00',NULL,'','2018-08-24 09:57:00','2018-08-24 09:58:59'),(88,1,'Вечернее шоу от Voynova Style',3,'2019-05-13','20:00:00',NULL,NULL,'','2018-08-24 09:57:00','2018-08-24 09:58:23'),(89,1,'Завтраки',4,'2019-05-13','07:00:00','10:00:00',NULL,'','2018-08-24 10:00:00','2018-08-24 10:00:00'),(90,1,'Cеминар от компании Prof Cosmetic',4,'2019-05-13','11:00:00','13:00:00',NULL,'','2018-08-24 10:08:49','2018-08-24 10:08:49'),(91,1,'Перерыв',4,'2019-05-13','13:00:00','13:30:00',NULL,'','2018-08-24 10:09:52','2018-08-24 10:09:52'),(92,1,'Будет объявлено позже',4,'2019-05-13','13:30:00','15:30:00',NULL,'','2018-08-24 10:11:37','2018-08-24 10:11:37'),(93,1,'Перерыв',4,'2019-05-13','15:30:00','16:00:00',NULL,'','2018-08-24 10:12:08','2018-08-24 10:12:08'),(94,1,'Будет объявлено позже',4,'2019-05-13','16:00:00','18:00:00',NULL,'','2018-08-24 10:12:44','2018-08-24 10:12:44'),(95,1,' Вечернее шоу от Voynova Style',4,'2019-05-13','20:00:00',NULL,NULL,'','2018-08-24 10:13:29','2018-08-24 10:13:29'),(96,1,'Регистрация команд',5,'2019-05-14','08:00:00','08:20:00',NULL,'','2018-08-24 10:14:49','2018-08-24 10:14:49'),(97,1,'Этап «Маникюр»',5,'2019-05-14','08:30:00','10:00:00',NULL,'','2018-08-24 10:15:52','2018-08-24 10:15:52'),(98,1,'Оценка судей',5,'2019-05-14','10:00:00','11:00:00',NULL,'','2018-08-24 10:16:22','2018-08-24 10:16:22'),(99,1,'Этап «Визаж»',5,'2019-05-14','11:00:00','12:00:00',NULL,'','2018-08-24 10:17:56','2018-08-24 10:17:56'),(100,1,'Оценка судей',5,'2019-05-14','12:00:00','13:00:00',NULL,'','2018-08-24 10:19:15','2018-08-24 10:19:15'),(101,1,'Этап «Причёска»',5,'2019-05-14','13:00:00','14:00:00',NULL,'','2018-08-24 10:21:06','2018-08-24 10:21:06'),(102,1,'Оценка судей',5,'2019-05-14','14:00:00','14:30:00',NULL,'','2018-08-24 10:21:37','2018-08-24 10:21:37'),(103,1,'Финальное дефиле',5,'2019-05-14','14:00:00','15:30:00',NULL,'','2018-08-24 10:22:51','2018-08-24 10:22:51'),(104,1,'Вечернее шоу',5,'2019-05-14','20:00:00',NULL,NULL,'','2018-08-24 10:23:16','2018-08-24 10:23:16'),(105,1,'Завтраки',2,'2019-05-15','07:00:00','10:00:00',NULL,'','2018-08-24 10:24:42','2018-08-24 10:24:42'),(106,1,'Cеминар от компании C-lab',2,'2019-05-15','11:00:00','14:00:00',NULL,'','2018-08-24 10:25:20','2018-08-24 10:25:20'),(107,1,'Перерыв',2,'2019-05-15','14:00:00','15:00:00',NULL,'','2018-08-24 10:25:59','2018-08-24 10:25:59'),(108,1,'Cеминар от компании Lakme',2,'2019-05-15','15:00:00','18:00:00',NULL,'','2018-08-24 10:26:32','2018-08-24 10:26:32'),(109,1,'Награждение победителей Dream Team. Коктейльная вечеринка',2,'2019-05-15','20:00:00',NULL,NULL,'','2018-08-24 10:27:00','2018-08-24 10:27:00'),(110,1,'Завтраки',1,'2019-05-15','07:00:00','10:00:00',NULL,'','2018-08-24 11:29:41','2018-08-24 11:29:41'),(111,1,'Семинар от школы Ксении Сакелари',1,'2019-05-15','11:00:00','13:00:00',NULL,'','2018-08-24 11:30:35','2018-08-24 11:30:35'),(112,1,'Перерыв',1,'2019-05-15','13:00:00','13:30:00',NULL,'','2018-08-24 11:31:21','2018-08-24 11:31:21'),(113,1,'Подология. Принципы работы в подологической обработке стопы. Различия с эстетическим педикюром',1,'2019-05-15','13:30:00','15:30:00',NULL,'','2018-08-24 11:32:31','2018-08-24 11:32:31'),(114,1,'Перерыв',1,'2019-05-15','15:30:00','16:00:00',NULL,'','2018-08-24 11:33:03','2018-08-24 11:33:03'),(115,1,'Китайская роспись гелями',1,'2019-05-15','16:00:00','18:00:00',NULL,'','2018-08-24 11:33:57','2018-08-24 11:33:57'),(116,1,'Награждение победителей Dream Team. Коктейльная вечеринка',1,'2019-05-15','20:00:00',NULL,NULL,'','2018-08-24 11:34:29','2018-08-24 11:34:29'),(117,1,'Завтраки',3,'2019-05-15','07:00:00','10:00:00',NULL,'','2018-08-24 11:35:07','2018-08-24 11:35:07'),(118,1,'Семинар от Permanent Makeup Beauty Academy',3,'2019-05-15','11:00:00','13:00:00',NULL,'','2018-08-24 11:35:59','2018-08-24 11:35:59'),(119,1,'Перерыв',3,'2019-05-13','13:00:00','13:30:00',NULL,'','2018-08-24 11:36:42','2018-08-24 11:36:42'),(120,1,'Семинар от школы визажа Максима Гилёва',3,'2019-05-15','13:30:00','15:30:00',NULL,'','2018-08-24 11:37:41','2018-08-24 11:37:41'),(121,1,'Перерыв',3,'2019-05-15','15:30:00','16:00:00',NULL,'','2018-08-24 11:38:10','2018-08-24 11:38:10'),(122,1,'Семинар от компании Elan',3,'2019-05-15','16:00:00','18:00:00',NULL,'','2018-08-24 11:38:52','2018-08-24 11:38:52'),(123,1,'Награждение победителей Dream Team. Коктейльная вечеринка',3,'2019-05-15','20:00:00',NULL,NULL,'','2018-08-24 11:39:23','2018-08-24 11:39:23'),(124,1,'Завтраки',4,'2019-05-15','07:00:00','10:00:00',NULL,'','2018-08-24 11:40:13','2018-08-24 11:40:13'),(125,1,'Cеминар от Елены Курчиной',4,'2019-05-15','11:00:00','13:00:00',NULL,'','2018-08-24 11:40:59','2018-08-24 11:40:59'),(126,1,'Перерыв',4,'2019-05-15','13:00:00','13:30:00',NULL,'','2018-08-24 11:41:28','2018-08-24 11:41:28'),(127,1,'Семинар от Ольги Колесник',4,'2019-05-15','13:30:00','15:30:00',NULL,'','2018-08-24 11:42:08','2018-08-24 11:42:08'),(128,1,'Перерыв',4,'2019-05-15','15:30:00','16:00:00',NULL,'','2018-08-24 11:42:39','2018-08-24 11:42:39'),(129,1,'Будет объявлено позже',4,'2019-05-15','16:00:00','18:00:00',NULL,'','2018-08-24 11:43:14','2018-08-24 11:43:14'),(130,1,'Награждение победителей Dream Team. Коктейльная вечеринка',4,'2019-05-15','20:00:00',NULL,NULL,'','2018-08-24 11:43:41','2018-08-24 11:43:41');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_partners`
--

DROP TABLE IF EXISTS `schedule_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_partners` (
  `schedule_id` int(10) unsigned NOT NULL,
  `partner_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`schedule_id`,`partner_id`),
  KEY `schedule_partners_partner_id_foreign` (`partner_id`),
  CONSTRAINT `schedule_partners_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedule_partners_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_partners`
--

LOCK TABLES `schedule_partners` WRITE;
/*!40000 ALTER TABLE `schedule_partners` DISABLE KEYS */;
INSERT INTO `schedule_partners` VALUES (106,1),(85,2),(76,3),(113,4),(83,5),(122,5),(71,6),(108,8),(87,9),(120,9),(118,12),(90,13),(125,14),(127,14),(111,15),(80,16),(115,17),(78,18),(74,19),(81,19),(88,19),(95,19);
/*!40000 ALTER TABLE `schedule_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_persons`
--

DROP TABLE IF EXISTS `schedule_persons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_persons` (
  `schedule_id` int(10) unsigned NOT NULL,
  `person_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`schedule_id`,`person_id`),
  KEY `schedule_speakers_speaker_id_foreign` (`person_id`),
  CONSTRAINT `schedule_speakers_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`) ON DELETE CASCADE,
  CONSTRAINT `schedule_speakers_speaker_id_foreign` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_persons`
--

LOCK TABLES `schedule_persons` WRITE;
/*!40000 ALTER TABLE `schedule_persons` DISABLE KEYS */;
INSERT INTO `schedule_persons` VALUES (90,1),(76,4),(113,5),(113,6),(111,7),(115,8),(78,9),(85,10),(83,11),(122,11),(87,12),(120,12),(125,13),(71,14),(71,15),(118,16),(127,17),(80,18);
/*!40000 ALTER TABLE `schedule_persons` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('gitWsXlJqTJU63QYnJJYVVcXZHcA5r3nED8efLh9',NULL,'192.168.10.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36 OPR/54.0.2952.71','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjFRTmxFZGpFWmdUSlo0R213bDhXVVB5V1d0b0hUMHpVU1FwaEFzQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHA6Ly9tb2xmYXIudGVzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1535100737);
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
  CONSTRAINT `speakers_contacts_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE
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
  CONSTRAINT `speeches_speaker_id_foreign` FOREIGN KEY (`speaker_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE
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
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
INSERT INTO `translations` VALUES (1,'data_types','display_name_singular',4,'en','Event','2018-06-04 20:32:35','2018-06-04 20:39:55'),(2,'data_types','display_name_plural',4,'en','Events','2018-06-04 20:32:36','2018-06-04 20:39:55'),(5,'data_types','display_name_singular',5,'en','Спикер','2018-06-05 09:51:43','2018-06-05 09:51:43'),(6,'data_types','display_name_plural',5,'en','Спикеры','2018-06-05 09:51:43','2018-06-05 09:51:43'),(7,'data_types','display_name_singular',7,'en','Контакт','2018-06-05 10:30:54','2018-06-05 10:30:54'),(8,'data_types','display_name_plural',7,'en','Контакты спикеров','2018-06-05 10:30:54','2018-06-05 10:30:54'),(9,'data_types','display_name_singular',8,'en','Доклад','2018-06-05 10:53:08','2018-06-05 10:53:08'),(10,'data_types','display_name_plural',8,'en','Доклады','2018-06-05 10:53:08','2018-06-05 10:53:08'),(11,'events','name',1,'en','Molfar Beauty Forum ‘19','2018-06-05 12:50:12','2018-07-25 12:23:34'),(12,'events','place',1,'en','Буковель','2018-06-05 12:50:12','2018-06-05 12:50:12'),(13,'data_types','display_name_singular',9,'en','Партнер','2018-06-05 13:17:30','2018-06-05 13:17:30'),(14,'data_types','display_name_plural',9,'en','Партнеры','2018-06-05 13:17:30','2018-06-05 13:17:30'),(17,'speeches','name',3,'en','About managment','2018-06-05 13:25:09','2018-06-05 13:25:09'),(18,'speeches','preview',3,'en','','2018-06-05 13:25:09','2018-06-05 13:25:09'),(19,'speeches','content',3,'en','<p>что-то такое</p>','2018-06-05 13:25:09','2018-06-05 13:25:09'),(20,'speeches','name',2,'en','About hair','2018-06-05 13:25:54','2018-06-05 13:25:54'),(21,'speeches','preview',2,'en','','2018-06-05 13:25:54','2018-06-05 13:25:54'),(22,'speeches','content',2,'en','<p>Нужно уложить так</p>','2018-06-05 13:25:54','2018-06-05 13:25:54'),(23,'speeches','name',1,'en','How to make manicure','2018-06-05 13:26:38','2018-06-05 13:26:38'),(24,'speeches','preview',1,'en','','2018-06-05 13:26:38','2018-06-05 13:26:38'),(25,'speeches','content',1,'en','<p>Бум</p>','2018-06-05 13:26:39','2018-06-05 13:26:39'),(26,'speakers','name',3,'en','Evgeniy Krasnoper','2018-06-05 13:32:58','2018-06-05 13:32:58'),(27,'speakers','summary',3,'en','Learn management ','2018-06-05 13:32:58','2018-06-05 13:32:58'),(28,'menu_items','title',17,'en','','2018-06-05 14:52:39','2018-06-05 14:52:39'),(29,'menu_items','title',12,'en','','2018-06-05 14:53:55','2018-06-05 14:53:55'),(30,'data_types','display_name_singular',10,'en','Билет','2018-06-05 15:00:04','2018-06-05 15:00:04'),(31,'data_types','display_name_plural',10,'en','Билеты','2018-06-05 15:00:04','2018-06-05 15:00:04'),(32,'data_types','display_name_singular',11,'en','Опция','2018-06-05 15:29:11','2018-06-05 15:29:11'),(33,'data_types','display_name_plural',11,'en','Опции билета','2018-06-05 15:29:11','2018-06-05 15:29:11'),(34,'data_types','display_name_singular',13,'en','Рассрочка','2018-06-05 16:09:03','2018-06-05 16:09:03'),(35,'data_types','display_name_plural',13,'en','Рассрочка','2018-06-05 16:09:03','2018-06-05 16:09:03'),(36,'data_types','display_name_singular',12,'en','Скидка','2018-06-05 16:12:08','2018-06-05 16:12:08'),(37,'data_types','display_name_plural',12,'en','Скидки','2018-06-05 16:12:08','2018-06-05 16:12:08'),(38,'data_types','display_name_singular',14,'en','Заказ','2018-06-05 19:20:46','2018-06-05 19:20:46'),(39,'data_types','display_name_plural',14,'en','Заказы','2018-06-05 19:20:46','2018-06-05 19:20:46'),(40,'data_types','display_name_singular',15,'en','Составляющие цены','2018-06-05 20:48:13','2018-06-05 20:48:13'),(41,'data_types','display_name_plural',15,'en','Составляющие цены','2018-06-05 20:48:13','2018-06-05 20:48:13'),(42,'data_types','display_name_singular',16,'en','Платеж','2018-06-05 21:02:55','2018-06-05 21:02:55'),(43,'data_types','display_name_plural',16,'en','Платежи','2018-06-05 21:02:55','2018-06-05 21:02:55'),(44,'menu_items','title',21,'en','','2018-06-05 21:06:45','2018-06-05 21:06:45'),(46,'menu_items','title',18,'en','','2018-06-05 21:24:55','2018-06-05 21:24:55'),(47,'tickets','flow',1,'en','','2018-06-07 11:25:06','2018-06-07 11:25:06'),(49,'discounts','name',1,'en','','2018-06-20 08:46:40','2018-06-20 08:46:40'),(50,'discounts','description',1,'en','','2018-06-20 08:46:40','2018-06-20 08:46:40'),(51,'discounts','name',2,'en','','2018-06-20 08:48:03','2018-06-20 08:48:03'),(52,'discounts','description',2,'en','','2018-06-20 08:48:03','2018-06-20 08:48:03'),(53,'discounts','name',3,'en','','2018-06-20 08:50:40','2018-06-20 08:50:40'),(54,'discounts','description',3,'en','','2018-06-20 08:50:40','2018-06-20 08:50:40'),(55,'options','name',1,'en','','2018-06-20 09:18:29','2018-06-20 09:18:29'),(56,'options','name',2,'en','','2018-06-20 09:22:40','2018-06-20 09:22:40'),(57,'installments','name',1,'en','','2018-06-20 15:54:34','2018-06-20 15:54:34'),(58,'installments','description',1,'en','','2018-06-20 15:54:34','2018-06-20 15:54:34'),(59,'menu_items','title',1,'en','','2018-06-20 18:08:06','2018-06-21 09:33:53'),(60,'menu_items','title',25,'en','','2018-06-20 18:09:19','2018-06-20 18:09:19'),(61,'menu_items','title',26,'en','','2018-06-20 18:12:20','2018-06-20 18:12:20'),(62,'menu_items','title',26,'ru','','2018-06-20 18:15:37','2018-06-20 18:15:37'),(64,'data_types','display_name_singular',17,'en','Банковская карта','2018-06-25 10:02:55','2018-06-25 10:02:55'),(65,'data_types','display_name_plural',17,'en','Банковские карты','2018-06-25 10:02:55','2018-06-25 10:02:55'),(66,'data_types','display_name_singular',18,'en','Продавец','2018-06-25 10:36:42','2018-06-25 10:36:42'),(67,'data_types','display_name_plural',18,'en','Продавцы','2018-06-25 10:36:42','2018-06-25 10:36:42'),(68,'sellers','name',1,'en','SNB','2018-06-25 10:40:36','2018-07-16 12:39:01'),(69,'data_types','display_name_singular',19,'en','Промокод','2018-06-25 10:48:11','2018-06-25 10:48:11'),(70,'data_types','display_name_plural',19,'en','Промокоды','2018-06-25 10:48:11','2018-06-25 10:48:11'),(71,'sellers','name',2,'en','Hairgum','2018-06-25 15:20:14','2018-07-16 12:39:37'),(72,'sellers','name',3,'en','Lakme','2018-06-25 15:20:47','2018-07-16 12:39:21'),(74,'menu_items','title',30,'en','','2018-06-25 16:53:30','2018-06-25 16:53:30'),(75,'menu_items','title',31,'en','','2018-06-25 16:56:39','2018-06-25 16:56:39'),(76,'data_types','display_name_singular',20,'en','Счет','2018-06-28 15:59:51','2018-06-28 15:59:51'),(77,'data_types','display_name_plural',20,'en','Счета','2018-06-28 15:59:51','2018-06-28 15:59:51'),(78,'tickets','flow',3,'en','','2018-06-30 10:13:54','2018-06-30 10:13:54'),(79,'data_types','display_name_singular',21,'en','Настройка','2018-07-03 16:19:51','2018-07-03 16:19:51'),(80,'data_types','display_name_plural',21,'en','Мои настройки','2018-07-03 16:19:51','2018-07-03 16:19:51'),(81,'data_types','display_name_singular',22,'en','Ранняя пташка','2018-07-05 17:27:22','2018-07-05 17:27:22'),(82,'data_types','display_name_plural',22,'en','Ранние пташки','2018-07-05 17:27:22','2018-07-05 17:27:22'),(83,'data_types','display_name_singular',24,'en','Ticket Option','2018-07-06 07:52:15','2018-07-06 07:52:15'),(84,'data_types','display_name_plural',24,'en','Ticket Options','2018-07-06 07:52:15','2018-07-06 07:52:15'),(85,'options','name',3,'en','','2018-07-06 19:21:33','2018-07-06 19:21:33'),(86,'options','name',4,'en','','2018-07-06 19:22:48','2018-07-06 19:22:48'),(87,'tickets','flow',2,'en','','2018-07-10 10:51:37','2018-07-12 11:51:23'),(88,'tickets','flow',4,'en','','2018-07-11 22:16:33','2018-07-12 11:53:44'),(89,'menu_items','title',19,'en','Скидки','2018-07-12 10:14:23','2018-07-12 10:14:23'),(90,'menu_items','title',20,'en','Рассрочка','2018-07-12 10:14:41','2018-07-12 10:14:41'),(91,'menu_items','title',27,'en','Продавцы','2018-07-12 10:15:18','2018-07-12 10:15:18'),(93,'menu_items','title',33,'en','Ранние пташки','2018-07-12 10:15:48','2018-07-12 10:15:48'),(94,'options','name',5,'en','','2018-07-12 11:29:53','2018-07-12 11:29:53'),(95,'options','name',6,'en','','2018-07-12 11:30:47','2018-07-12 11:30:47'),(96,'options','name',7,'en','','2018-07-12 11:31:17','2018-07-12 11:31:17'),(97,'options','name',8,'en','','2018-07-12 11:31:59','2018-07-12 11:31:59'),(98,'tickets','flow',5,'en','','2018-07-12 11:54:45','2018-07-12 11:54:45'),(99,'sellers','name',4,'en','','2018-07-16 12:40:10','2018-07-16 12:40:10'),(100,'sellers','name',5,'en','Prof-cosmetic','2018-07-16 12:55:33','2018-07-16 12:55:33'),(101,'sellers','name',6,'en','','2018-07-16 12:56:35','2018-07-16 12:56:35'),(102,'sellers','name',7,'en','','2018-07-16 12:57:29','2018-07-16 12:57:29'),(103,'sellers','name',8,'en','','2018-07-16 12:57:51','2018-07-16 12:57:51'),(104,'sellers','name',9,'en','','2018-07-16 12:58:48','2018-07-16 12:58:48'),(105,'sellers','name',10,'en','','2018-07-16 12:59:15','2018-07-16 12:59:15'),(106,'sellers','name',11,'en','','2018-07-16 12:59:53','2018-07-16 12:59:53'),(107,'sellers','name',12,'en','','2018-07-16 13:00:22','2018-07-16 13:00:22'),(108,'data_types','display_name_singular',25,'en','Обратная связь','2018-07-19 23:15:44','2018-07-19 23:15:44'),(109,'data_types','display_name_plural',25,'en','Обратная связь','2018-07-19 23:15:44','2018-07-19 23:15:44'),(110,'menu_items','title',35,'en','Обратная связь','2018-07-20 10:17:20','2018-07-20 10:17:20'),(113,'flows','name',1,'en','','2018-08-17 21:18:36','2018-08-17 21:18:36'),(114,'flows','name',2,'en','','2018-08-17 21:19:30','2018-08-17 21:19:30'),(115,'data_types','display_name_singular',26,'en','Программа','2018-08-17 21:25:52','2018-08-17 21:25:52'),(116,'data_types','display_name_plural',26,'en','Программа','2018-08-17 21:25:52','2018-08-17 21:25:52'),(117,'data_types','display_name_singular',27,'en','Поток','2018-08-18 10:44:13','2018-08-18 10:44:13'),(118,'data_types','display_name_plural',27,'en','Потоки','2018-08-18 10:44:13','2018-08-18 10:44:13'),(119,'flows','name',3,'en','','2018-08-18 10:44:58','2018-08-18 10:44:58'),(121,'partners','name',1,'en','','2018-08-18 10:53:23','2018-08-18 10:53:23'),(122,'partners','name',2,'en','A Priori','2018-08-18 10:54:21','2018-08-18 11:57:01'),(123,'partners','name',3,'en','Adore','2018-08-18 11:01:52','2018-08-18 11:55:56'),(124,'speakers','name',2,'en','Мисс Мария','2018-08-18 12:53:09','2018-08-18 12:53:09'),(125,'speakers','summary',2,'en','Делаю маникюр','2018-08-18 12:53:09','2018-08-18 12:53:09'),(126,'speakers','name',1,'en','Олег Дергачев','2018-08-18 12:53:47','2018-08-18 12:53:47'),(127,'speakers','summary',1,'en','Мастер стрижки','2018-08-18 12:53:47','2018-08-18 12:53:47'),(128,'speakers','name',4,'en','','2018-08-18 12:54:07','2018-08-18 12:54:07'),(129,'speakers','summary',4,'en','','2018-08-18 12:54:07','2018-08-18 12:54:07'),(130,'speakers','name',5,'en','','2018-08-18 12:54:52','2018-08-18 12:54:52'),(131,'speakers','summary',5,'en','','2018-08-18 12:54:52','2018-08-18 12:54:52'),(132,'speakers','name',6,'en','','2018-08-18 12:55:28','2018-08-18 12:55:28'),(133,'speakers','summary',6,'en','','2018-08-18 12:55:28','2018-08-18 12:55:28'),(134,'speakers','name',7,'en','','2018-08-18 13:02:53','2018-08-18 13:02:53'),(135,'speakers','summary',7,'en','','2018-08-18 13:02:53','2018-08-18 13:02:53'),(136,'speakers','name',8,'en','','2018-08-18 13:03:14','2018-08-18 13:03:14'),(137,'speakers','summary',8,'en','','2018-08-18 13:03:14','2018-08-18 13:03:14'),(138,'speakers','name',9,'en','','2018-08-18 13:03:33','2018-08-18 13:03:33'),(139,'speakers','summary',9,'en','','2018-08-18 13:03:33','2018-08-18 13:03:33'),(140,'speakers','name',10,'en','','2018-08-18 13:03:52','2018-08-18 13:03:52'),(141,'speakers','summary',10,'en','','2018-08-18 13:03:52','2018-08-18 13:03:52'),(142,'speakers','name',11,'en','','2018-08-18 13:04:19','2018-08-18 13:04:19'),(143,'speakers','summary',11,'en','','2018-08-18 13:04:19','2018-08-18 13:04:19'),(144,'speakers','name',12,'en','','2018-08-18 13:04:45','2018-08-18 13:04:45'),(145,'speakers','summary',12,'en','','2018-08-18 13:04:45','2018-08-18 13:04:45'),(146,'speakers','name',13,'en','','2018-08-18 13:05:09','2018-08-18 13:05:09'),(147,'speakers','summary',13,'en','','2018-08-18 13:05:09','2018-08-18 13:05:09'),(154,'menu_items','title',37,'en','Потоки','2018-08-19 09:10:21','2018-08-19 09:10:21'),(155,'flows','name',4,'en','','2018-08-19 09:10:59','2018-08-19 09:10:59'),(156,'partners','name',4,'en','','2018-08-19 09:18:05','2018-08-19 09:18:05'),(157,'partners','name',5,'en','Elan','2018-08-19 09:18:56','2018-08-19 09:18:56'),(158,'partners','name',6,'en','','2018-08-19 09:20:15','2018-08-19 09:20:15'),(159,'partners','name',7,'en','','2018-08-19 09:21:05','2018-08-19 09:21:05'),(160,'partners','name',8,'en','','2018-08-19 09:21:49','2018-08-19 09:21:49'),(161,'partners','name',9,'en','','2018-08-19 09:31:44','2018-08-19 09:31:44'),(162,'partners','name',10,'en','','2018-08-19 09:32:42','2018-08-19 09:32:42'),(163,'partners','name',11,'en','','2018-08-19 09:33:42','2018-08-19 09:33:42'),(164,'partners','name',12,'en','','2018-08-19 10:37:13','2018-08-19 10:37:13'),(165,'partners','name',13,'en','','2018-08-19 10:37:53','2018-08-19 10:37:53'),(166,'partners','name',14,'en','','2018-08-19 10:38:35','2018-08-19 10:38:35'),(167,'partners','name',15,'en','','2018-08-19 10:39:17','2018-08-19 10:39:17'),(168,'partners','name',16,'en','','2018-08-19 10:40:00','2018-08-19 10:40:00'),(169,'partners','name',17,'en','','2018-08-19 10:40:39','2018-08-19 10:40:39'),(170,'partners','name',18,'en','','2018-08-19 10:41:29','2018-08-19 10:41:29'),(171,'partners','name',19,'en','','2018-08-19 10:42:24','2018-08-19 10:42:24'),(172,'schedule','title',4,'en','','2018-08-19 10:45:21','2018-08-19 10:45:21'),(173,'schedule','description',4,'en','','2018-08-19 10:45:21','2018-08-19 10:45:21'),(174,'schedule','title',5,'en','','2018-08-19 10:46:01','2018-08-19 10:46:01'),(175,'schedule','description',5,'en','','2018-08-19 10:46:01','2018-08-19 10:46:01'),(176,'schedule','title',6,'en','','2018-08-19 10:47:17','2018-08-19 10:47:17'),(177,'schedule','description',6,'en','','2018-08-19 10:47:17','2018-08-19 10:47:17'),(178,'schedule','title',7,'en','','2018-08-19 10:48:58','2018-08-19 10:48:58'),(179,'schedule','description',7,'en','','2018-08-19 10:48:58','2018-08-19 10:48:58'),(180,'speakers','name',14,'en','','2018-08-19 10:53:25','2018-08-19 10:53:25'),(181,'speakers','summary',14,'en','','2018-08-19 10:53:25','2018-08-19 10:53:25'),(182,'speakers','name',15,'en','','2018-08-19 10:53:38','2018-08-19 10:53:38'),(183,'speakers','summary',15,'en','','2018-08-19 10:53:38','2018-08-19 10:53:38'),(184,'schedule','title',8,'en','','2018-08-19 10:55:14','2018-08-19 10:55:14'),(185,'schedule','description',8,'en','','2018-08-19 10:55:14','2018-08-19 10:55:14'),(186,'schedule','title',9,'en','','2018-08-19 10:56:33','2018-08-19 10:56:33'),(187,'schedule','description',9,'en','','2018-08-19 10:56:33','2018-08-19 10:56:33'),(188,'schedule','title',10,'en','','2018-08-19 10:57:55','2018-08-19 10:57:55'),(189,'schedule','description',10,'en','','2018-08-19 10:57:55','2018-08-19 10:57:55'),(190,'schedule','title',11,'en','','2018-08-19 10:58:57','2018-08-19 10:58:57'),(191,'schedule','description',11,'en','','2018-08-19 10:58:57','2018-08-19 10:58:57'),(192,'schedule','title',12,'en','','2018-08-19 11:00:19','2018-08-19 11:00:19'),(193,'schedule','description',12,'en','','2018-08-19 11:00:19','2018-08-19 11:00:19'),(194,'schedule','title',13,'en','','2018-08-19 11:01:55','2018-08-19 11:01:55'),(195,'schedule','description',13,'en','','2018-08-19 11:01:55','2018-08-19 11:01:55'),(196,'schedule','title',14,'en','','2018-08-19 11:06:20','2018-08-19 11:06:20'),(197,'schedule','description',14,'en','','2018-08-19 11:06:20','2018-08-19 11:06:20'),(198,'schedule','title',15,'en','','2018-08-19 11:08:03','2018-08-19 11:08:03'),(199,'schedule','description',15,'en','','2018-08-19 11:08:03','2018-08-19 11:08:03'),(200,'schedule','title',16,'en','','2018-08-19 11:09:10','2018-08-19 11:09:10'),(201,'schedule','description',16,'en','','2018-08-19 11:09:10','2018-08-19 11:09:10'),(202,'schedule','title',17,'en','','2018-08-19 11:10:21','2018-08-19 11:10:21'),(203,'schedule','description',17,'en','','2018-08-19 11:10:21','2018-08-19 11:10:21'),(204,'schedule','title',18,'en','','2018-08-19 11:11:34','2018-08-19 11:11:34'),(205,'schedule','description',18,'en','','2018-08-19 11:11:34','2018-08-19 11:11:34'),(206,'schedule','title',19,'en','','2018-08-19 11:12:49','2018-08-19 11:12:49'),(207,'schedule','description',19,'en','','2018-08-19 11:12:49','2018-08-19 11:12:49'),(208,'schedule','title',20,'en','','2018-08-19 11:14:15','2018-08-19 11:14:15'),(209,'schedule','description',20,'en','','2018-08-19 11:14:15','2018-08-19 11:14:15'),(210,'schedule','title',21,'en','','2018-08-19 11:15:15','2018-08-19 11:15:15'),(211,'schedule','description',21,'en','','2018-08-19 11:15:15','2018-08-19 11:15:15'),(212,'schedule','title',22,'en','','2018-08-19 11:16:58','2018-08-19 11:16:58'),(213,'schedule','description',22,'en','','2018-08-19 11:16:58','2018-08-19 11:16:58'),(214,'schedule','title',23,'en','','2018-08-19 11:17:43','2018-08-19 11:17:43'),(215,'schedule','description',23,'en','','2018-08-19 11:17:43','2018-08-19 11:17:43'),(216,'schedule','title',24,'en','','2018-08-19 11:19:13','2018-08-19 11:19:13'),(217,'schedule','description',24,'en','','2018-08-19 11:19:13','2018-08-19 11:19:13'),(218,'schedule','title',25,'en','','2018-08-19 11:20:40','2018-08-19 11:20:40'),(219,'schedule','description',25,'en','','2018-08-19 11:20:40','2018-08-19 11:20:40'),(220,'schedule','title',26,'en','','2018-08-19 11:21:27','2018-08-19 11:21:27'),(221,'schedule','description',26,'en','','2018-08-19 11:21:27','2018-08-19 11:21:27'),(222,'schedule','title',27,'en','','2018-08-19 11:22:30','2018-08-19 11:22:30'),(223,'schedule','description',27,'en','','2018-08-19 11:22:30','2018-08-19 11:22:30'),(224,'schedule','title',28,'en','','2018-08-19 11:23:39','2018-08-19 11:23:39'),(225,'schedule','description',28,'en','','2018-08-19 11:23:39','2018-08-19 11:23:39'),(226,'schedule','title',29,'en','','2018-08-19 11:24:35','2018-08-19 11:24:35'),(227,'schedule','description',29,'en','','2018-08-19 11:24:35','2018-08-19 11:24:35'),(228,'schedule','title',30,'en','','2018-08-19 11:25:30','2018-08-19 11:25:30'),(229,'schedule','description',30,'en','','2018-08-19 11:25:30','2018-08-19 11:25:30'),(230,'schedule','title',31,'en','','2018-08-19 11:26:21','2018-08-19 11:26:21'),(231,'schedule','description',31,'en','','2018-08-19 11:26:21','2018-08-19 11:26:21'),(232,'schedule','title',32,'en','','2018-08-19 11:27:07','2018-08-19 11:27:07'),(233,'schedule','description',32,'en','','2018-08-19 11:27:07','2018-08-19 11:27:07'),(234,'flows','name',5,'en','','2018-08-19 11:28:16','2018-08-19 11:28:16'),(235,'schedule','title',33,'en','','2018-08-19 11:29:03','2018-08-19 11:29:03'),(236,'schedule','description',33,'en','','2018-08-19 11:29:03','2018-08-19 11:29:03'),(237,'schedule','title',34,'en','','2018-08-19 11:32:24','2018-08-19 11:32:24'),(238,'schedule','description',34,'en','','2018-08-19 11:32:24','2018-08-19 11:32:24'),(239,'schedule','title',35,'en','','2018-08-19 14:34:15','2018-08-19 14:34:15'),(240,'schedule','description',35,'en','','2018-08-19 14:34:15','2018-08-19 14:34:15'),(241,'schedule','title',36,'en','','2018-08-19 14:34:49','2018-08-19 14:34:49'),(242,'schedule','description',36,'en','','2018-08-19 14:34:49','2018-08-19 14:34:49'),(243,'schedule','title',37,'en','','2018-08-19 14:35:31','2018-08-19 14:35:31'),(244,'schedule','description',37,'en','','2018-08-19 14:35:31','2018-08-19 14:35:31'),(245,'schedule','title',38,'en','','2018-08-19 14:36:16','2018-08-19 14:36:16'),(246,'schedule','description',38,'en','','2018-08-19 14:36:16','2018-08-19 14:36:16'),(247,'schedule','title',39,'en','','2018-08-19 14:37:03','2018-08-19 14:37:03'),(248,'schedule','description',39,'en','','2018-08-19 14:37:03','2018-08-19 14:37:03'),(249,'schedule','title',40,'en','','2018-08-19 14:37:45','2018-08-19 14:37:45'),(250,'schedule','description',40,'en','','2018-08-19 14:37:45','2018-08-19 14:37:45'),(251,'schedule','title',41,'en','','2018-08-19 14:38:57','2018-08-19 14:38:57'),(252,'schedule','description',41,'en','','2018-08-19 14:38:57','2018-08-19 14:38:57'),(253,'schedule','title',42,'en','','2018-08-19 14:40:32','2018-08-19 14:40:32'),(254,'schedule','description',42,'en','','2018-08-19 14:40:32','2018-08-19 14:40:32'),(255,'schedule','title',43,'en','','2018-08-19 14:41:27','2018-08-19 14:41:27'),(256,'schedule','description',43,'en','','2018-08-19 14:41:27','2018-08-19 14:41:27'),(257,'schedule','title',44,'en','','2018-08-19 14:43:09','2018-08-19 14:43:09'),(258,'schedule','description',44,'en','','2018-08-19 14:43:09','2018-08-19 14:43:09'),(259,'schedule','title',45,'en','','2018-08-19 14:44:44','2018-08-19 14:44:44'),(260,'schedule','description',45,'en','','2018-08-19 14:44:44','2018-08-19 14:44:44'),(261,'schedule','title',46,'en','','2018-08-19 14:45:35','2018-08-19 14:45:35'),(262,'schedule','description',46,'en','','2018-08-19 14:45:35','2018-08-19 14:45:35'),(263,'schedule','title',47,'en','','2018-08-19 14:46:29','2018-08-19 14:46:29'),(264,'schedule','description',47,'en','','2018-08-19 14:46:29','2018-08-19 14:46:29'),(265,'schedule','title',48,'en','','2018-08-19 14:47:43','2018-08-19 14:47:43'),(266,'schedule','description',48,'en','','2018-08-19 14:47:43','2018-08-19 14:47:43'),(267,'schedule','title',49,'en','','2018-08-19 14:48:52','2018-08-19 14:48:52'),(268,'schedule','description',49,'en','','2018-08-19 14:48:52','2018-08-19 14:48:52'),(269,'schedule','title',50,'en','','2018-08-19 14:50:19','2018-08-19 14:50:19'),(270,'schedule','description',50,'en','','2018-08-19 14:50:19','2018-08-19 14:50:19'),(271,'schedule','title',51,'en','','2018-08-19 14:50:57','2018-08-19 14:50:57'),(272,'schedule','description',51,'en','','2018-08-19 14:50:57','2018-08-19 14:50:57'),(273,'schedule','title',52,'en','','2018-08-19 14:52:01','2018-08-19 14:52:01'),(274,'schedule','description',52,'en','','2018-08-19 14:52:01','2018-08-19 14:52:01'),(275,'schedule','title',53,'en','','2018-08-19 14:52:30','2018-08-19 14:52:30'),(276,'schedule','description',53,'en','','2018-08-19 14:52:30','2018-08-19 14:52:30'),(277,'schedule','title',54,'en','','2018-08-19 14:53:22','2018-08-19 14:53:22'),(278,'schedule','description',54,'en','','2018-08-19 14:53:22','2018-08-19 14:53:22'),(279,'speakers','name',16,'en','','2018-08-19 14:55:17','2018-08-19 14:55:17'),(280,'speakers','summary',16,'en','','2018-08-19 14:55:17','2018-08-19 14:55:17'),(281,'schedule','title',55,'en','','2018-08-19 14:56:58','2018-08-19 14:56:58'),(282,'schedule','description',55,'en','','2018-08-19 14:56:58','2018-08-19 14:56:58'),(283,'schedule','title',56,'en','','2018-08-19 14:57:35','2018-08-19 14:57:35'),(284,'schedule','description',56,'en','','2018-08-19 14:57:35','2018-08-19 14:57:35'),(285,'schedule','title',57,'en','','2018-08-19 14:59:57','2018-08-19 14:59:57'),(286,'schedule','description',57,'en','','2018-08-19 14:59:57','2018-08-19 14:59:57'),(287,'schedule','title',58,'en','','2018-08-19 15:01:24','2018-08-19 15:01:24'),(288,'schedule','description',58,'en','','2018-08-19 15:01:24','2018-08-19 15:01:24'),(289,'schedule','title',59,'en','','2018-08-19 15:02:38','2018-08-19 15:02:38'),(290,'schedule','description',59,'en','','2018-08-19 15:02:38','2018-08-19 15:02:38'),(291,'schedule','title',60,'en','','2018-08-19 15:03:20','2018-08-19 15:03:20'),(292,'schedule','description',60,'en','','2018-08-19 15:03:20','2018-08-19 15:03:20'),(293,'schedule','title',61,'en','','2018-08-19 15:04:00','2018-08-19 15:04:00'),(294,'schedule','description',61,'en','','2018-08-19 15:04:00','2018-08-19 15:04:00'),(295,'schedule','title',62,'en','','2018-08-19 15:05:00','2018-08-19 15:05:00'),(296,'schedule','description',62,'en','','2018-08-19 15:05:00','2018-08-19 15:05:00'),(297,'schedule','title',63,'en','','2018-08-19 15:05:38','2018-08-19 15:05:38'),(298,'schedule','description',63,'en','','2018-08-19 15:05:38','2018-08-19 15:05:38'),(299,'speakers','name',17,'en','','2018-08-19 15:06:18','2018-08-19 15:06:18'),(300,'speakers','summary',17,'en','','2018-08-19 15:06:18','2018-08-19 15:06:18'),(301,'schedule','title',64,'en','','2018-08-19 15:07:16','2018-08-19 15:07:16'),(302,'schedule','description',64,'en','','2018-08-19 15:07:16','2018-08-19 15:07:16'),(303,'schedule','title',65,'en','','2018-08-19 15:07:49','2018-08-19 15:07:49'),(304,'schedule','description',65,'en','','2018-08-19 15:07:49','2018-08-19 15:07:49'),(305,'schedule','title',66,'en','','2018-08-19 15:08:25','2018-08-19 15:08:25'),(306,'schedule','description',66,'en','','2018-08-19 15:08:25','2018-08-19 15:08:25'),(307,'schedule','title',67,'en','','2018-08-19 15:09:07','2018-08-19 15:09:07'),(308,'schedule','description',67,'en','','2018-08-19 15:09:07','2018-08-19 15:09:07'),(309,'schedule','title',68,'en','','2018-08-19 15:09:51','2018-08-19 15:09:51'),(310,'schedule','description',68,'en','','2018-08-19 15:09:51','2018-08-19 15:09:51'),(311,'schedule','title',69,'en','','2018-08-19 15:10:16','2018-08-19 15:10:16'),(312,'schedule','description',69,'en','','2018-08-19 15:10:16','2018-08-19 15:10:16'),(313,'speakers','name',18,'en','','2018-08-19 16:08:12','2018-08-19 16:08:12'),(314,'speakers','summary',18,'en','','2018-08-19 16:08:12','2018-08-19 16:08:12'),(315,'menu_items','title',39,'en','','2018-08-20 10:18:35','2018-08-20 10:18:35'),(318,'menu_items','title',15,'en','Доклады','2018-08-20 10:21:44','2018-08-20 10:21:44'),(319,'menu_items','title',16,'en','Партнеры','2018-08-20 10:24:52','2018-08-20 10:24:52'),(320,'menu_items','title',40,'en','Персоны','2018-08-21 12:40:49','2018-08-21 12:40:49'),(321,'menu_items','title',40,'uk','Персоны','2018-08-21 12:40:49','2018-08-21 12:40:49'),(322,'data_types','display_name_singular',27,'uk','Поток','2018-08-21 12:51:29','2018-08-21 12:51:29'),(323,'data_types','display_name_plural',27,'uk','Потоки','2018-08-21 12:51:29','2018-08-21 12:51:29'),(326,'flows','name',1,'uk','Маникюр','2018-08-21 12:55:49','2018-08-21 12:55:49'),(327,'flows','name',2,'uk','Парикмахерство','2018-08-21 12:57:18','2018-08-21 12:57:18'),(328,'data_types','display_name_singular',4,'uk','Событие','2018-08-21 13:18:53','2018-08-21 13:18:53'),(329,'data_types','display_name_plural',4,'uk','События','2018-08-21 13:18:53','2018-08-21 13:18:53'),(330,'data_types','display_name_singular',26,'uk','Программа','2018-08-21 13:21:04','2018-08-21 13:21:04'),(331,'data_types','display_name_plural',26,'uk','Программа','2018-08-21 13:21:04','2018-08-21 13:21:04'),(332,'events','name',4,'en','','2018-08-21 13:57:49','2018-08-21 13:57:49'),(333,'events','name',4,'uk','','2018-08-21 13:57:49','2018-08-21 13:57:49'),(334,'events','place',4,'en','','2018-08-21 13:57:49','2018-08-21 13:57:49'),(335,'events','place',4,'uk','','2018-08-21 13:57:49','2018-08-21 13:57:49'),(336,'partners','name',10,'uk','Nouvelle','2018-08-21 14:25:11','2018-08-21 14:25:11'),(337,'schedule','title',70,'en','','2018-08-21 14:27:42','2018-08-21 14:27:42'),(338,'schedule','title',70,'uk','','2018-08-21 14:27:42','2018-08-21 14:27:42'),(339,'schedule','description',70,'en','','2018-08-21 14:27:42','2018-08-21 14:27:42'),(340,'schedule','description',70,'uk','','2018-08-21 14:27:42','2018-08-21 14:27:42'),(341,'schedule','title',71,'en','','2018-08-21 14:29:14','2018-08-21 14:29:14'),(342,'schedule','title',71,'uk','','2018-08-21 14:29:14','2018-08-21 14:29:14'),(343,'schedule','description',71,'en','','2018-08-21 14:29:14','2018-08-21 14:29:14'),(344,'schedule','description',71,'uk','','2018-08-21 14:29:14','2018-08-21 14:29:14'),(345,'schedule','title',72,'en','','2018-08-21 14:30:41','2018-08-21 14:30:41'),(346,'schedule','title',72,'uk','','2018-08-21 14:30:41','2018-08-21 14:30:41'),(347,'schedule','description',72,'en','','2018-08-21 14:30:41','2018-08-21 14:30:41'),(348,'schedule','description',72,'uk','','2018-08-21 14:30:41','2018-08-21 14:30:41'),(349,'schedule','title',73,'en','','2018-08-21 14:31:31','2018-08-21 14:31:31'),(350,'schedule','title',73,'uk','','2018-08-21 14:31:31','2018-08-21 14:31:31'),(351,'schedule','description',73,'en','','2018-08-21 14:31:31','2018-08-21 14:31:31'),(352,'schedule','description',73,'uk','','2018-08-21 14:31:31','2018-08-21 14:31:31'),(353,'schedule','title',74,'en','','2018-08-21 14:32:16','2018-08-21 14:32:16'),(354,'schedule','title',74,'uk','','2018-08-21 14:32:16','2018-08-21 14:32:16'),(355,'schedule','description',74,'en','','2018-08-21 14:32:16','2018-08-21 14:32:16'),(356,'schedule','description',74,'uk','','2018-08-21 14:32:16','2018-08-21 14:32:16'),(357,'schedule','title',75,'en','','2018-08-21 14:33:04','2018-08-21 14:33:04'),(358,'schedule','title',75,'uk','','2018-08-21 14:33:04','2018-08-21 14:33:04'),(359,'schedule','description',75,'en','','2018-08-21 14:33:04','2018-08-21 14:33:04'),(360,'schedule','description',75,'uk','','2018-08-21 14:33:04','2018-08-21 14:33:04'),(361,'schedule','title',76,'en','','2018-08-21 14:33:49','2018-08-21 14:33:49'),(362,'schedule','title',76,'uk','','2018-08-21 14:33:49','2018-08-21 14:33:49'),(363,'schedule','description',76,'en','','2018-08-21 14:33:49','2018-08-21 14:33:49'),(364,'schedule','description',76,'uk','','2018-08-21 14:33:49','2018-08-21 14:33:49'),(365,'schedule','title',77,'en','','2018-08-21 14:35:15','2018-08-21 14:35:15'),(366,'schedule','title',77,'uk','','2018-08-21 14:35:15','2018-08-21 14:35:15'),(367,'schedule','description',77,'en','','2018-08-21 14:35:15','2018-08-21 14:35:15'),(368,'schedule','description',77,'uk','','2018-08-21 14:35:15','2018-08-21 14:35:15'),(369,'schedule','title',78,'en','','2018-08-21 14:36:20','2018-08-21 14:36:20'),(370,'schedule','title',78,'uk','','2018-08-21 14:36:20','2018-08-21 14:36:20'),(371,'schedule','description',78,'en','','2018-08-21 14:36:20','2018-08-21 14:36:20'),(372,'schedule','description',78,'uk','','2018-08-21 14:36:20','2018-08-21 14:36:20'),(373,'schedule','title',79,'en','','2018-08-21 14:43:00','2018-08-21 14:43:00'),(374,'schedule','title',79,'uk','','2018-08-21 14:43:00','2018-08-21 14:43:00'),(375,'schedule','description',79,'en','','2018-08-21 14:43:00','2018-08-21 14:43:00'),(376,'schedule','description',79,'uk','','2018-08-21 14:43:00','2018-08-21 14:43:00'),(377,'schedule','title',80,'en','','2018-08-21 14:46:15','2018-08-21 14:46:15'),(378,'schedule','title',80,'uk','','2018-08-21 14:46:15','2018-08-21 14:46:15'),(379,'schedule','description',80,'en','','2018-08-21 14:46:15','2018-08-21 14:46:15'),(380,'schedule','description',80,'uk','','2018-08-21 14:46:15','2018-08-21 14:46:15'),(381,'schedule','title',81,'en','','2018-08-21 14:47:09','2018-08-21 14:47:09'),(382,'schedule','title',81,'uk','','2018-08-21 14:47:09','2018-08-21 14:47:09'),(383,'schedule','description',81,'en','','2018-08-21 14:47:09','2018-08-21 14:47:09'),(384,'schedule','description',81,'uk','','2018-08-21 14:47:09','2018-08-21 14:47:09'),(385,'events','name',1,'uk','Molfar Beauty Forum ‘19','2018-08-21 14:51:50','2018-08-21 14:51:50'),(386,'events','place',1,'uk','Буковель','2018-08-21 14:51:50','2018-08-21 14:51:50'),(387,'persons','name',4,'en','Виктория Матвеева','2018-08-21 18:39:18','2018-08-21 18:39:18'),(388,'persons','name',4,'uk','Виктория Матвеева','2018-08-21 18:39:18','2018-08-21 18:39:18'),(389,'persons','summary',4,'en','','2018-08-21 18:39:18','2018-08-21 18:39:18'),(390,'persons','summary',4,'uk','','2018-08-21 18:39:18','2018-08-21 18:39:18'),(391,'flows','name',3,'uk','Визаж','2018-08-21 18:55:14','2018-08-21 18:55:14'),(392,'flows','name',4,'uk','Менеджмент','2018-08-21 18:55:39','2018-08-21 18:55:39'),(393,'persons','name',3,'en','Надежда Свищук','2018-08-21 18:57:24','2018-08-21 18:57:24'),(394,'persons','name',3,'uk','Надежда Свищук','2018-08-21 18:57:24','2018-08-21 18:57:24'),(395,'persons','summary',3,'en','','2018-08-21 18:57:24','2018-08-21 18:57:24'),(396,'persons','summary',3,'uk','','2018-08-21 18:57:24','2018-08-21 18:57:24'),(397,'persons','name',2,'en','Ольга Загоровская','2018-08-21 18:58:19','2018-08-21 18:58:19'),(398,'persons','name',2,'uk','Ольга Загоровская','2018-08-21 18:58:19','2018-08-21 18:58:19'),(399,'persons','summary',2,'en','Делаю маникюр','2018-08-21 18:58:19','2018-08-21 18:58:19'),(400,'persons','summary',2,'uk','Делаю маникюр','2018-08-21 18:58:19','2018-08-21 18:58:19'),(401,'persons','name',1,'en','Сергей Кормаков','2018-08-21 18:58:51','2018-08-21 18:58:51'),(402,'persons','name',1,'uk','Сергей Кормаков','2018-08-21 18:58:51','2018-08-21 18:58:51'),(403,'persons','summary',1,'en','','2018-08-21 18:58:51','2018-08-21 18:58:51'),(404,'persons','summary',1,'uk','','2018-08-21 18:58:51','2018-08-21 18:58:51'),(405,'persons','name',5,'en','Дитер Бауманн','2018-08-21 18:59:43','2018-08-21 18:59:43'),(406,'persons','name',5,'uk','Дитер Бауманн','2018-08-21 18:59:43','2018-08-21 18:59:43'),(407,'persons','summary',5,'en','Преподаватель и практикующий подолог, один из разработчиков Закона о Подологии в Германии','2018-08-21 18:59:43','2018-08-21 18:59:43'),(408,'persons','summary',5,'uk','Преподаватель и практикующий подолог, один из разработчиков Закона о Подологии в Германии','2018-08-21 18:59:43','2018-08-21 18:59:43'),(409,'persons','name',6,'en','Ирина Егорова','2018-08-21 19:00:34','2018-08-21 19:00:34'),(410,'persons','name',6,'uk','Ирина Егорова','2018-08-21 19:00:34','2018-08-21 19:00:34'),(411,'persons','summary',6,'en','','2018-08-21 19:00:34','2018-08-21 19:00:34'),(412,'persons','summary',6,'uk','','2018-08-21 19:00:34','2018-08-21 19:00:34'),(413,'persons','name',7,'en','Ксения Сакелари','2018-08-21 19:03:09','2018-08-21 19:03:09'),(414,'persons','name',7,'uk','Ксения Сакелари','2018-08-21 19:03:09','2018-08-21 19:03:09'),(415,'persons','summary',7,'en','','2018-08-21 19:03:09','2018-08-21 19:03:09'),(416,'persons','summary',7,'uk','','2018-08-21 19:03:09','2018-08-21 19:03:09'),(417,'persons','name',8,'en','Татьяна Соловьёва','2018-08-21 19:03:49','2018-08-21 19:03:49'),(418,'persons','name',8,'uk','Татьяна Соловьёва','2018-08-21 19:03:49','2018-08-21 19:03:49'),(419,'persons','summary',8,'en','','2018-08-21 19:03:49','2018-08-21 19:03:49'),(420,'persons','summary',8,'uk','','2018-08-21 19:03:49','2018-08-21 19:03:49'),(421,'persons','name',9,'en','Юлия Стадник','2018-08-21 19:04:21','2018-08-21 19:04:21'),(422,'persons','name',9,'uk','Юлия Стадник','2018-08-21 19:04:21','2018-08-21 19:04:21'),(423,'persons','summary',9,'en','','2018-08-21 19:04:21','2018-08-21 19:04:21'),(424,'persons','summary',9,'uk','','2018-08-21 19:04:21','2018-08-21 19:04:21'),(425,'persons','name',10,'en','Алёна Антонова','2018-08-21 19:04:47','2018-08-21 19:04:47'),(426,'persons','name',10,'uk','Алёна Антонова','2018-08-21 19:04:47','2018-08-21 19:04:47'),(427,'persons','summary',10,'en','','2018-08-21 19:04:47','2018-08-21 19:04:47'),(428,'persons','summary',10,'uk','','2018-08-21 19:04:47','2018-08-21 19:04:47'),(429,'persons','name',11,'en','Анна Кравченко','2018-08-21 19:05:36','2018-08-21 19:05:36'),(430,'persons','name',11,'uk','Анна Кравченко','2018-08-21 19:05:36','2018-08-21 19:05:36'),(431,'persons','summary',11,'en','','2018-08-21 19:05:36','2018-08-21 19:05:36'),(432,'persons','summary',11,'uk','','2018-08-21 19:05:36','2018-08-21 19:05:36'),(433,'persons','name',12,'en','Максим Гилёв','2018-08-21 19:06:05','2018-08-21 19:06:05'),(434,'persons','name',12,'uk','Максим Гилёв','2018-08-21 19:06:05','2018-08-21 19:06:05'),(435,'persons','summary',12,'en','','2018-08-21 19:06:05','2018-08-21 19:06:05'),(436,'persons','summary',12,'uk','','2018-08-21 19:06:05','2018-08-21 19:06:05'),(437,'persons','name',13,'en','Елена Курчина','2018-08-21 19:06:34','2018-08-21 19:06:34'),(438,'persons','name',13,'uk','Елена Курчина','2018-08-21 19:06:34','2018-08-21 19:06:34'),(439,'persons','summary',13,'en','','2018-08-21 19:06:34','2018-08-21 19:06:34'),(440,'persons','summary',13,'uk','','2018-08-21 19:06:34','2018-08-21 19:06:34'),(445,'data_types','display_name_singular',31,'en','Персона события','2018-08-22 14:57:44','2018-08-22 14:57:44'),(446,'data_types','display_name_singular',31,'uk','Персона события','2018-08-22 14:57:44','2018-08-22 14:57:44'),(447,'data_types','display_name_plural',31,'en','Персоны события','2018-08-22 14:57:44','2018-08-22 14:57:44'),(448,'data_types','display_name_plural',31,'uk','Персоны события','2018-08-22 14:57:44','2018-08-22 14:57:44'),(449,'event_persons','speaker_caption',1,'en','','2018-08-22 15:17:24','2018-08-22 15:17:24'),(450,'event_persons','speaker_caption',1,'uk','','2018-08-22 15:17:24','2018-08-22 15:17:24'),(451,'event_persons','judge_caption',1,'en','','2018-08-22 15:17:24','2018-08-22 15:17:24'),(452,'event_persons','judge_caption',1,'uk','','2018-08-22 15:17:24','2018-08-22 15:17:24'),(457,'event_persons','speaker_caption',3,'en','','2018-08-22 16:05:24','2018-08-22 16:05:24'),(458,'event_persons','speaker_caption',3,'uk','','2018-08-22 16:05:24','2018-08-22 16:05:24'),(459,'event_persons','judge_caption',3,'en','','2018-08-22 16:05:24','2018-08-22 16:05:24'),(460,'event_persons','judge_caption',3,'uk','','2018-08-22 16:05:24','2018-08-22 16:05:24'),(461,'event_persons','speaker_caption',4,'en','','2018-08-22 16:09:47','2018-08-22 16:09:47'),(462,'event_persons','speaker_caption',4,'uk','','2018-08-22 16:09:47','2018-08-22 16:09:47'),(463,'event_persons','judge_caption',4,'en','','2018-08-22 16:09:47','2018-08-22 16:09:47'),(464,'event_persons','judge_caption',4,'uk','','2018-08-22 16:09:47','2018-08-22 16:09:47'),(465,'event_persons','speaker_caption',5,'en','','2018-08-22 16:10:46','2018-08-22 16:10:46'),(466,'event_persons','speaker_caption',5,'uk','','2018-08-22 16:10:46','2018-08-22 16:10:46'),(467,'event_persons','judge_caption',5,'en','','2018-08-22 16:10:46','2018-08-22 16:10:46'),(468,'event_persons','judge_caption',5,'uk','','2018-08-22 16:10:46','2018-08-22 16:10:46'),(469,'event_persons','speaker_caption',6,'en','','2018-08-22 16:11:30','2018-08-22 16:11:30'),(470,'event_persons','speaker_caption',6,'uk','','2018-08-22 16:11:30','2018-08-22 16:11:30'),(471,'event_persons','judge_caption',6,'en','','2018-08-22 16:11:30','2018-08-22 16:11:30'),(472,'event_persons','judge_caption',6,'uk','','2018-08-22 16:11:30','2018-08-22 16:11:30'),(473,'event_persons','speaker_caption',7,'en','','2018-08-22 16:12:09','2018-08-22 16:12:09'),(474,'event_persons','speaker_caption',7,'uk','','2018-08-22 16:12:09','2018-08-22 16:12:09'),(475,'event_persons','judge_caption',7,'en','','2018-08-22 16:12:09','2018-08-22 16:12:09'),(476,'event_persons','judge_caption',7,'uk','','2018-08-22 16:12:09','2018-08-22 16:12:09'),(479,'event_persons','caption',2,'en','','2018-08-22 16:50:07','2018-08-22 16:50:07'),(480,'event_persons','caption',2,'uk','','2018-08-22 16:50:07','2018-08-22 16:50:07'),(481,'event_persons','caption',3,'en','','2018-08-22 16:50:38','2018-08-22 16:50:38'),(482,'event_persons','caption',3,'uk','','2018-08-22 16:50:38','2018-08-22 16:50:38'),(483,'event_persons','caption',4,'en','','2018-08-22 16:51:20','2018-08-22 16:51:20'),(484,'event_persons','caption',4,'uk','','2018-08-22 16:51:20','2018-08-22 16:51:20'),(485,'event_persons','caption',5,'en','','2018-08-22 16:52:02','2018-08-22 16:52:02'),(486,'event_persons','caption',5,'uk','','2018-08-22 16:52:02','2018-08-22 16:52:02'),(487,'event_persons','caption',6,'en','','2018-08-22 16:53:35','2018-08-22 16:53:35'),(488,'event_persons','caption',6,'uk','','2018-08-22 16:53:35','2018-08-22 16:53:35'),(489,'event_persons','caption',7,'en','','2018-08-22 16:54:11','2018-08-22 16:54:11'),(490,'event_persons','caption',7,'uk','','2018-08-22 16:54:11','2018-08-22 16:54:11'),(491,'event_persons','caption',8,'en','','2018-08-22 16:54:46','2018-08-22 16:54:46'),(492,'event_persons','caption',8,'uk','','2018-08-22 16:54:46','2018-08-22 16:54:46'),(493,'event_persons','caption',9,'en','','2018-08-22 16:55:28','2018-08-22 16:55:28'),(494,'event_persons','caption',9,'uk','','2018-08-22 16:55:28','2018-08-22 16:55:28'),(495,'event_persons','caption',10,'en','','2018-08-22 16:56:05','2018-08-22 16:56:05'),(496,'event_persons','caption',10,'uk','','2018-08-22 16:56:05','2018-08-22 16:56:05'),(497,'event_persons','caption',11,'en','','2018-08-22 17:13:37','2018-08-22 17:13:37'),(498,'event_persons','caption',11,'uk','','2018-08-22 17:13:37','2018-08-22 17:13:37'),(501,'event_persons','caption',13,'en','','2018-08-22 17:19:21','2018-08-22 17:19:21'),(502,'event_persons','caption',13,'uk','','2018-08-22 17:19:21','2018-08-22 17:19:21'),(503,'event_persons','caption',14,'en','','2018-08-22 17:20:55','2018-08-22 17:20:55'),(504,'event_persons','caption',14,'uk','','2018-08-22 17:20:55','2018-08-22 17:20:55'),(505,'event_persons','caption',15,'en','','2018-08-22 17:23:08','2018-08-22 17:23:08'),(506,'event_persons','caption',15,'uk','','2018-08-22 17:23:08','2018-08-22 17:23:08'),(507,'event_persons','caption',16,'en','','2018-08-22 18:47:11','2018-08-22 18:47:11'),(508,'event_persons','caption',16,'uk','','2018-08-22 18:47:11','2018-08-22 18:47:11'),(509,'event_persons','caption',17,'en','','2018-08-22 18:47:28','2018-08-22 18:47:28'),(510,'event_persons','caption',17,'uk','','2018-08-22 18:47:28','2018-08-22 18:47:28'),(511,'data_types','display_name_singular',9,'uk','Партнер','2018-08-23 19:14:23','2018-08-23 19:14:23'),(512,'data_types','display_name_plural',9,'uk','Партнеры','2018-08-23 19:14:23','2018-08-23 19:14:23'),(513,'schedule','title',82,'en','','2018-08-24 09:50:47','2018-08-24 09:50:47'),(514,'schedule','title',82,'uk','','2018-08-24 09:50:47','2018-08-24 09:50:47'),(515,'schedule','description',82,'en','','2018-08-24 09:50:47','2018-08-24 09:50:47'),(516,'schedule','description',82,'uk','','2018-08-24 09:50:47','2018-08-24 09:50:47'),(517,'schedule','title',83,'en','','2018-08-24 09:51:54','2018-08-24 09:51:54'),(518,'schedule','title',83,'uk','','2018-08-24 09:51:54','2018-08-24 09:51:54'),(519,'schedule','description',83,'en','','2018-08-24 09:51:54','2018-08-24 09:51:54'),(520,'schedule','description',83,'uk','','2018-08-24 09:51:54','2018-08-24 09:51:54'),(521,'schedule','title',84,'en','','2018-08-24 09:54:02','2018-08-24 09:54:02'),(522,'schedule','title',84,'uk','','2018-08-24 09:54:02','2018-08-24 09:54:02'),(523,'schedule','description',84,'en','','2018-08-24 09:54:02','2018-08-24 09:54:02'),(524,'schedule','description',84,'uk','','2018-08-24 09:54:02','2018-08-24 09:54:02'),(525,'schedule','title',85,'en','','2018-08-24 09:55:08','2018-08-24 09:55:08'),(526,'schedule','title',85,'uk','','2018-08-24 09:55:08','2018-08-24 09:55:08'),(527,'schedule','description',85,'en','','2018-08-24 09:55:08','2018-08-24 09:55:08'),(528,'schedule','description',85,'uk','','2018-08-24 09:55:08','2018-08-24 09:55:08'),(529,'schedule','title',86,'en','','2018-08-24 09:55:41','2018-08-24 09:55:41'),(530,'schedule','title',86,'uk','','2018-08-24 09:55:41','2018-08-24 09:55:41'),(531,'schedule','description',86,'en','','2018-08-24 09:55:41','2018-08-24 09:55:41'),(532,'schedule','description',86,'uk','','2018-08-24 09:55:41','2018-08-24 09:55:41'),(533,'schedule','title',87,'en','','2018-08-24 09:57:03','2018-08-24 09:57:03'),(534,'schedule','title',87,'uk','','2018-08-24 09:57:03','2018-08-24 09:57:03'),(535,'schedule','description',87,'en','','2018-08-24 09:57:03','2018-08-24 09:57:03'),(536,'schedule','description',87,'uk','','2018-08-24 09:57:03','2018-08-24 09:57:03'),(537,'schedule','title',88,'en','','2018-08-24 09:57:47','2018-08-24 09:57:47'),(538,'schedule','title',88,'uk','','2018-08-24 09:57:47','2018-08-24 09:57:47'),(539,'schedule','description',88,'en','','2018-08-24 09:57:47','2018-08-24 09:57:47'),(540,'schedule','description',88,'uk','','2018-08-24 09:57:47','2018-08-24 09:57:47'),(541,'schedule','title',89,'en','','2018-08-24 10:00:00','2018-08-24 10:00:00'),(542,'schedule','title',89,'uk','','2018-08-24 10:00:00','2018-08-24 10:00:00'),(543,'schedule','description',89,'en','','2018-08-24 10:00:00','2018-08-24 10:00:00'),(544,'schedule','description',89,'uk','','2018-08-24 10:00:00','2018-08-24 10:00:00'),(545,'schedule','title',90,'en','','2018-08-24 10:08:49','2018-08-24 10:08:49'),(546,'schedule','title',90,'uk','','2018-08-24 10:08:49','2018-08-24 10:08:49'),(547,'schedule','description',90,'en','','2018-08-24 10:08:49','2018-08-24 10:08:49'),(548,'schedule','description',90,'uk','','2018-08-24 10:08:49','2018-08-24 10:08:49'),(549,'schedule','title',91,'en','','2018-08-24 10:09:52','2018-08-24 10:09:52'),(550,'schedule','title',91,'uk','','2018-08-24 10:09:52','2018-08-24 10:09:52'),(551,'schedule','description',91,'en','','2018-08-24 10:09:52','2018-08-24 10:09:52'),(552,'schedule','description',91,'uk','','2018-08-24 10:09:53','2018-08-24 10:09:53'),(553,'schedule','title',92,'en','','2018-08-24 10:11:37','2018-08-24 10:11:37'),(554,'schedule','title',92,'uk','','2018-08-24 10:11:37','2018-08-24 10:11:37'),(555,'schedule','description',92,'en','','2018-08-24 10:11:37','2018-08-24 10:11:37'),(556,'schedule','description',92,'uk','','2018-08-24 10:11:37','2018-08-24 10:11:37'),(557,'schedule','title',93,'en','','2018-08-24 10:12:08','2018-08-24 10:12:08'),(558,'schedule','title',93,'uk','','2018-08-24 10:12:08','2018-08-24 10:12:08'),(559,'schedule','description',93,'en','','2018-08-24 10:12:08','2018-08-24 10:12:08'),(560,'schedule','description',93,'uk','','2018-08-24 10:12:08','2018-08-24 10:12:08'),(561,'schedule','title',94,'en','','2018-08-24 10:12:44','2018-08-24 10:12:44'),(562,'schedule','title',94,'uk','','2018-08-24 10:12:44','2018-08-24 10:12:44'),(563,'schedule','description',94,'en','','2018-08-24 10:12:44','2018-08-24 10:12:44'),(564,'schedule','description',94,'uk','','2018-08-24 10:12:44','2018-08-24 10:12:44'),(565,'schedule','title',95,'en','','2018-08-24 10:13:29','2018-08-24 10:13:29'),(566,'schedule','title',95,'uk','','2018-08-24 10:13:29','2018-08-24 10:13:29'),(567,'schedule','description',95,'en','','2018-08-24 10:13:29','2018-08-24 10:13:29'),(568,'schedule','description',95,'uk','','2018-08-24 10:13:29','2018-08-24 10:13:29'),(569,'schedule','title',96,'en','','2018-08-24 10:14:49','2018-08-24 10:14:49'),(570,'schedule','title',96,'uk','','2018-08-24 10:14:49','2018-08-24 10:14:49'),(571,'schedule','description',96,'en','','2018-08-24 10:14:49','2018-08-24 10:14:49'),(572,'schedule','description',96,'uk','','2018-08-24 10:14:49','2018-08-24 10:14:49'),(573,'schedule','title',97,'en','','2018-08-24 10:15:52','2018-08-24 10:15:52'),(574,'schedule','title',97,'uk','','2018-08-24 10:15:52','2018-08-24 10:15:52'),(575,'schedule','description',97,'en','','2018-08-24 10:15:52','2018-08-24 10:15:52'),(576,'schedule','description',97,'uk','','2018-08-24 10:15:52','2018-08-24 10:15:52'),(577,'schedule','title',98,'en','','2018-08-24 10:16:23','2018-08-24 10:16:23'),(578,'schedule','title',98,'uk','','2018-08-24 10:16:23','2018-08-24 10:16:23'),(579,'schedule','description',98,'en','','2018-08-24 10:16:23','2018-08-24 10:16:23'),(580,'schedule','description',98,'uk','','2018-08-24 10:16:23','2018-08-24 10:16:23'),(581,'schedule','title',99,'en','','2018-08-24 10:17:56','2018-08-24 10:17:56'),(582,'schedule','title',99,'uk','','2018-08-24 10:17:56','2018-08-24 10:17:56'),(583,'schedule','description',99,'en','','2018-08-24 10:17:56','2018-08-24 10:17:56'),(584,'schedule','description',99,'uk','','2018-08-24 10:17:56','2018-08-24 10:17:56'),(585,'schedule','title',100,'en','','2018-08-24 10:19:15','2018-08-24 10:19:15'),(586,'schedule','title',100,'uk','','2018-08-24 10:19:15','2018-08-24 10:19:15'),(587,'schedule','description',100,'en','','2018-08-24 10:19:15','2018-08-24 10:19:15'),(588,'schedule','description',100,'uk','','2018-08-24 10:19:15','2018-08-24 10:19:15'),(589,'schedule','title',101,'en','','2018-08-24 10:21:06','2018-08-24 10:21:06'),(590,'schedule','title',101,'uk','','2018-08-24 10:21:06','2018-08-24 10:21:06'),(591,'schedule','description',101,'en','','2018-08-24 10:21:06','2018-08-24 10:21:06'),(592,'schedule','description',101,'uk','','2018-08-24 10:21:06','2018-08-24 10:21:06'),(593,'schedule','title',102,'en','','2018-08-24 10:21:37','2018-08-24 10:21:37'),(594,'schedule','title',102,'uk','','2018-08-24 10:21:37','2018-08-24 10:21:37'),(595,'schedule','description',102,'en','','2018-08-24 10:21:37','2018-08-24 10:21:37'),(596,'schedule','description',102,'uk','','2018-08-24 10:21:37','2018-08-24 10:21:37'),(597,'schedule','title',103,'en','','2018-08-24 10:22:51','2018-08-24 10:22:51'),(598,'schedule','title',103,'uk','','2018-08-24 10:22:51','2018-08-24 10:22:51'),(599,'schedule','description',103,'en','','2018-08-24 10:22:51','2018-08-24 10:22:51'),(600,'schedule','description',103,'uk','','2018-08-24 10:22:51','2018-08-24 10:22:51'),(601,'schedule','title',104,'en','','2018-08-24 10:23:16','2018-08-24 10:23:16'),(602,'schedule','title',104,'uk','','2018-08-24 10:23:16','2018-08-24 10:23:16'),(603,'schedule','description',104,'en','','2018-08-24 10:23:16','2018-08-24 10:23:16'),(604,'schedule','description',104,'uk','','2018-08-24 10:23:16','2018-08-24 10:23:16'),(605,'schedule','title',105,'en','','2018-08-24 10:24:42','2018-08-24 10:24:42'),(606,'schedule','title',105,'uk','','2018-08-24 10:24:42','2018-08-24 10:24:42'),(607,'schedule','description',105,'en','','2018-08-24 10:24:42','2018-08-24 10:24:42'),(608,'schedule','description',105,'uk','','2018-08-24 10:24:42','2018-08-24 10:24:42'),(609,'schedule','title',106,'en','','2018-08-24 10:25:20','2018-08-24 10:25:20'),(610,'schedule','title',106,'uk','','2018-08-24 10:25:20','2018-08-24 10:25:20'),(611,'schedule','description',106,'en','','2018-08-24 10:25:20','2018-08-24 10:25:20'),(612,'schedule','description',106,'uk','','2018-08-24 10:25:20','2018-08-24 10:25:20'),(613,'schedule','title',107,'en','','2018-08-24 10:25:59','2018-08-24 10:25:59'),(614,'schedule','title',107,'uk','','2018-08-24 10:25:59','2018-08-24 10:25:59'),(615,'schedule','description',107,'en','','2018-08-24 10:25:59','2018-08-24 10:25:59'),(616,'schedule','description',107,'uk','','2018-08-24 10:25:59','2018-08-24 10:25:59'),(617,'schedule','title',108,'en','','2018-08-24 10:26:32','2018-08-24 10:26:32'),(618,'schedule','title',108,'uk','','2018-08-24 10:26:32','2018-08-24 10:26:32'),(619,'schedule','description',108,'en','','2018-08-24 10:26:32','2018-08-24 10:26:32'),(620,'schedule','description',108,'uk','','2018-08-24 10:26:32','2018-08-24 10:26:32'),(621,'schedule','title',109,'en','','2018-08-24 10:27:00','2018-08-24 10:27:00'),(622,'schedule','title',109,'uk','','2018-08-24 10:27:00','2018-08-24 10:27:00'),(623,'schedule','description',109,'en','','2018-08-24 10:27:00','2018-08-24 10:27:00'),(624,'schedule','description',109,'uk','','2018-08-24 10:27:00','2018-08-24 10:27:00'),(625,'schedule','title',110,'en','','2018-08-24 11:29:41','2018-08-24 11:29:41'),(626,'schedule','title',110,'uk','','2018-08-24 11:29:41','2018-08-24 11:29:41'),(627,'schedule','description',110,'en','','2018-08-24 11:29:41','2018-08-24 11:29:41'),(628,'schedule','description',110,'uk','','2018-08-24 11:29:41','2018-08-24 11:29:41'),(629,'schedule','title',111,'en','','2018-08-24 11:30:35','2018-08-24 11:30:35'),(630,'schedule','title',111,'uk','','2018-08-24 11:30:35','2018-08-24 11:30:35'),(631,'schedule','description',111,'en','','2018-08-24 11:30:35','2018-08-24 11:30:35'),(632,'schedule','description',111,'uk','','2018-08-24 11:30:35','2018-08-24 11:30:35'),(633,'schedule','title',112,'en','','2018-08-24 11:31:21','2018-08-24 11:31:21'),(634,'schedule','title',112,'uk','','2018-08-24 11:31:21','2018-08-24 11:31:21'),(635,'schedule','description',112,'en','','2018-08-24 11:31:21','2018-08-24 11:31:21'),(636,'schedule','description',112,'uk','','2018-08-24 11:31:21','2018-08-24 11:31:21'),(637,'schedule','title',113,'en','','2018-08-24 11:32:31','2018-08-24 11:32:31'),(638,'schedule','title',113,'uk','','2018-08-24 11:32:31','2018-08-24 11:32:31'),(639,'schedule','description',113,'en','','2018-08-24 11:32:31','2018-08-24 11:32:31'),(640,'schedule','description',113,'uk','','2018-08-24 11:32:31','2018-08-24 11:32:31'),(641,'schedule','title',114,'en','','2018-08-24 11:33:03','2018-08-24 11:33:03'),(642,'schedule','title',114,'uk','','2018-08-24 11:33:03','2018-08-24 11:33:03'),(643,'schedule','description',114,'en','','2018-08-24 11:33:03','2018-08-24 11:33:03'),(644,'schedule','description',114,'uk','','2018-08-24 11:33:03','2018-08-24 11:33:03'),(645,'schedule','title',115,'en','','2018-08-24 11:33:57','2018-08-24 11:33:57'),(646,'schedule','title',115,'uk','','2018-08-24 11:33:57','2018-08-24 11:33:57'),(647,'schedule','description',115,'en','','2018-08-24 11:33:57','2018-08-24 11:33:57'),(648,'schedule','description',115,'uk','','2018-08-24 11:33:57','2018-08-24 11:33:57'),(649,'schedule','title',116,'en','','2018-08-24 11:34:29','2018-08-24 11:34:29'),(650,'schedule','title',116,'uk','','2018-08-24 11:34:29','2018-08-24 11:34:29'),(651,'schedule','description',116,'en','','2018-08-24 11:34:29','2018-08-24 11:34:29'),(652,'schedule','description',116,'uk','','2018-08-24 11:34:29','2018-08-24 11:34:29'),(653,'schedule','title',117,'en','','2018-08-24 11:35:07','2018-08-24 11:35:07'),(654,'schedule','title',117,'uk','','2018-08-24 11:35:07','2018-08-24 11:35:07'),(655,'schedule','description',117,'en','','2018-08-24 11:35:07','2018-08-24 11:35:07'),(656,'schedule','description',117,'uk','','2018-08-24 11:35:07','2018-08-24 11:35:07'),(657,'schedule','title',118,'en','','2018-08-24 11:35:59','2018-08-24 11:35:59'),(658,'schedule','title',118,'uk','','2018-08-24 11:35:59','2018-08-24 11:35:59'),(659,'schedule','description',118,'en','','2018-08-24 11:35:59','2018-08-24 11:35:59'),(660,'schedule','description',118,'uk','','2018-08-24 11:35:59','2018-08-24 11:35:59'),(661,'schedule','title',119,'en','','2018-08-24 11:36:42','2018-08-24 11:36:42'),(662,'schedule','title',119,'uk','','2018-08-24 11:36:42','2018-08-24 11:36:42'),(663,'schedule','description',119,'en','','2018-08-24 11:36:42','2018-08-24 11:36:42'),(664,'schedule','description',119,'uk','','2018-08-24 11:36:42','2018-08-24 11:36:42'),(665,'schedule','title',120,'en','','2018-08-24 11:37:41','2018-08-24 11:37:41'),(666,'schedule','title',120,'uk','','2018-08-24 11:37:41','2018-08-24 11:37:41'),(667,'schedule','description',120,'en','','2018-08-24 11:37:41','2018-08-24 11:37:41'),(668,'schedule','description',120,'uk','','2018-08-24 11:37:41','2018-08-24 11:37:41'),(669,'schedule','title',121,'en','','2018-08-24 11:38:10','2018-08-24 11:38:10'),(670,'schedule','title',121,'uk','','2018-08-24 11:38:10','2018-08-24 11:38:10'),(671,'schedule','description',121,'en','','2018-08-24 11:38:10','2018-08-24 11:38:10'),(672,'schedule','description',121,'uk','','2018-08-24 11:38:10','2018-08-24 11:38:10'),(673,'schedule','title',122,'en','','2018-08-24 11:38:52','2018-08-24 11:38:52'),(674,'schedule','title',122,'uk','','2018-08-24 11:38:52','2018-08-24 11:38:52'),(675,'schedule','description',122,'en','','2018-08-24 11:38:52','2018-08-24 11:38:52'),(676,'schedule','description',122,'uk','','2018-08-24 11:38:52','2018-08-24 11:38:52'),(677,'schedule','title',123,'en','','2018-08-24 11:39:23','2018-08-24 11:39:23'),(678,'schedule','title',123,'uk','','2018-08-24 11:39:23','2018-08-24 11:39:23'),(679,'schedule','description',123,'en','','2018-08-24 11:39:23','2018-08-24 11:39:23'),(680,'schedule','description',123,'uk','','2018-08-24 11:39:23','2018-08-24 11:39:23'),(681,'schedule','title',124,'en','','2018-08-24 11:40:13','2018-08-24 11:40:13'),(682,'schedule','title',124,'uk','','2018-08-24 11:40:13','2018-08-24 11:40:13'),(683,'schedule','description',124,'en','','2018-08-24 11:40:13','2018-08-24 11:40:13'),(684,'schedule','description',124,'uk','','2018-08-24 11:40:13','2018-08-24 11:40:13'),(685,'schedule','title',125,'en','','2018-08-24 11:40:59','2018-08-24 11:40:59'),(686,'schedule','title',125,'uk','','2018-08-24 11:40:59','2018-08-24 11:40:59'),(687,'schedule','description',125,'en','','2018-08-24 11:40:59','2018-08-24 11:40:59'),(688,'schedule','description',125,'uk','','2018-08-24 11:40:59','2018-08-24 11:40:59'),(689,'schedule','title',126,'en','','2018-08-24 11:41:28','2018-08-24 11:41:28'),(690,'schedule','title',126,'uk','','2018-08-24 11:41:28','2018-08-24 11:41:28'),(691,'schedule','description',126,'en','','2018-08-24 11:41:28','2018-08-24 11:41:28'),(692,'schedule','description',126,'uk','','2018-08-24 11:41:28','2018-08-24 11:41:28'),(693,'schedule','title',127,'en','','2018-08-24 11:42:08','2018-08-24 11:42:08'),(694,'schedule','title',127,'uk','','2018-08-24 11:42:08','2018-08-24 11:42:08'),(695,'schedule','description',127,'en','','2018-08-24 11:42:08','2018-08-24 11:42:08'),(696,'schedule','description',127,'uk','','2018-08-24 11:42:08','2018-08-24 11:42:08'),(697,'schedule','title',128,'en','','2018-08-24 11:42:39','2018-08-24 11:42:39'),(698,'schedule','title',128,'uk','','2018-08-24 11:42:39','2018-08-24 11:42:39'),(699,'schedule','description',128,'en','','2018-08-24 11:42:39','2018-08-24 11:42:39'),(700,'schedule','description',128,'uk','','2018-08-24 11:42:39','2018-08-24 11:42:39'),(701,'schedule','title',129,'en','','2018-08-24 11:43:14','2018-08-24 11:43:14'),(702,'schedule','title',129,'uk','','2018-08-24 11:43:14','2018-08-24 11:43:14'),(703,'schedule','description',129,'en','','2018-08-24 11:43:14','2018-08-24 11:43:14'),(704,'schedule','description',129,'uk','','2018-08-24 11:43:14','2018-08-24 11:43:14'),(705,'schedule','title',130,'en','','2018-08-24 11:43:41','2018-08-24 11:43:41'),(706,'schedule','title',130,'uk','','2018-08-24 11:43:41','2018-08-24 11:43:41'),(707,'schedule','description',130,'en','','2018-08-24 11:43:41','2018-08-24 11:43:41'),(708,'schedule','description',130,'uk','','2018-08-24 11:43:41','2018-08-24 11:43:41');
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

-- Dump completed on 2018-08-24 11:53:46
