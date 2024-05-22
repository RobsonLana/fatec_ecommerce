-- MariaDB dump 10.19-11.3.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: loja
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES
(1,'Hardware'),
(2,'Decoração'),
(3,'Vestuário'),
(6,'Utensilio de cozinha');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `cpf_cnpj_cli` varchar(18) NOT NULL,
  `nome_cli` varchar(50) DEFAULT NULL,
  `numero_cli` varchar(10) DEFAULT NULL,
  `bairro_cli` varchar(10) DEFAULT NULL,
  `cidade_cli` varchar(20) DEFAULT NULL,
  `cep_cli` varchar(10) DEFAULT NULL,
  `estado_cli` varchar(2) DEFAULT NULL,
  `endereco_cli` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj_cli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES
('12345678901','Robson Lana','1','Pq. E.','Bragança Paulista','12922070','SP','Rua aleatória'),
('98765432109','Giovanni','2','Pq F.','Bragança Paulista','12922000','SP','Rua complicada');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compra` (
  `numero_compra` int NOT NULL,
  `data` date DEFAULT NULL,
  `valor_comissao` decimal(10,2) DEFAULT NULL,
  `valor_transporte` decimal(10,2) DEFAULT NULL,
  `cpf_cnpj_vend` varchar(18) DEFAULT NULL,
  `cpf_cnpj_trans` varchar(18) DEFAULT NULL,
  `cpf_cnpj_cli` varchar(18) DEFAULT NULL,
  PRIMARY KEY (`numero_compra`),
  KEY `cpf_cnpj_vend` (`cpf_cnpj_vend`),
  KEY `cpf_cnpj_cli` (`cpf_cnpj_cli`),
  KEY `cpf_cnpj_trans` (`cpf_cnpj_trans`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cpf_cnpj_vend`) REFERENCES `vendedor` (`cpf_cnpj_vend`),
  CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`cpf_cnpj_cli`) REFERENCES `cliente` (`cpf_cnpj_cli`),
  CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`cpf_cnpj_trans`) REFERENCES `transportadora` (`cpf_cnpj_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagem`
--

DROP TABLE IF EXISTS `imagem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagem` (
  `codigo_img` int NOT NULL,
  `codigo_prod` varchar(10) DEFAULT NULL,
  `nome_arquivo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigo_img`),
  KEY `codigo_prod` (`codigo_prod`),
  CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagem`
--

LOCK TABLES `imagem` WRITE;
/*!40000 ALTER TABLE `imagem` DISABLE KEYS */;
INSERT INTO `imagem` VALUES
(0,'2','2_0.webp'),
(1,'1','1_0.webp'),
(2,'3','3_0.jpg'),
(3,'4','4_0.jpg'),
(4,'5','5_0.jpg');
/*!40000 ALTER TABLE `imagem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemcompra`
--

DROP TABLE IF EXISTS `itemcompra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `itemcompra` (
  `numero_compra` int DEFAULT NULL,
  `codigo_prod` varchar(10) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `quantidade` decimal(5,2) DEFAULT NULL,
  KEY `numero_compra` (`numero_compra`),
  KEY `codigo_prod` (`codigo_prod`),
  CONSTRAINT `ItemCompra_ibfk_1` FOREIGN KEY (`numero_compra`) REFERENCES `compra` (`numero_compra`),
  CONSTRAINT `ItemCompra_ibfk_2` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itemcompra`
--

LOCK TABLES `itemcompra` WRITE;
/*!40000 ALTER TABLE `itemcompra` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemcompra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `codigo_prod` varchar(10) NOT NULL,
  `nome_pro` varchar(50) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `quantidade` decimal(5,2) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `dimensoes` varchar(15) DEFAULT NULL,
  `unidade_Venda` varchar(3) DEFAULT NULL,
  `id` int NOT NULL,
  PRIMARY KEY (`codigo_prod`),
  KEY `id` (`id`),
  CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES
('1','Lustre','Lustre de mesa',50.30,80.00,NULL,NULL,NULL,2),
('2','Vaso de Vidro','Vaso de vidro para flores',60.00,15.00,NULL,NULL,NULL,2),
('3','Mouse','Mouse USB',35.99,120.00,NULL,NULL,NULL,1),
('4','Pendrive','Pendrive 64GB',20.00,200.00,NULL,NULL,NULL,1),
('5','Headset','Fone de ouvido Bluetooth com plug P2 e carregamento miniUSB.<br>Arco de metal resistente e reajustável.<br>Cor preta; até 4 horas de bateria.',150.00,30.00,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transportadora`
--

DROP TABLE IF EXISTS `transportadora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transportadora` (
  `cpf_cnpj_trans` varchar(18) NOT NULL,
  `nome_trans` varchar(50) DEFAULT NULL,
  `endereco_trans` varchar(50) DEFAULT NULL,
  `numero_trans` varchar(10) DEFAULT NULL,
  `bairro_trans` varchar(10) DEFAULT NULL,
  `cidade_trans` varchar(5) DEFAULT NULL,
  `estado_trans` varchar(2) DEFAULT NULL,
  `cep_trans` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transportadora`
--

LOCK TABLES `transportadora` WRITE;
/*!40000 ALTER TABLE `transportadora` DISABLE KEYS */;
INSERT INTO `transportadora` VALUES
('25044072000161','Ponto AB','Rua La Na Zona','123','C. Redondo','SP','SP','12345678'),
('42462278000120','Garago Fast','Rua Logo Alí','321','V. Belezas','SP','SP','1234588');
/*!40000 ALTER TABLE `transportadora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendedor`
--

DROP TABLE IF EXISTS `vendedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendedor` (
  `cpf_cnpj_vend` varchar(18) NOT NULL,
  `nome_vend` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj_vend`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendedor`
--

LOCK TABLES `vendedor` WRITE;
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
INSERT INTO `vendedor` VALUES
('12345678901234','Computer Max'),
('98765432109876','Decorex');
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'loja'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-22 17:52:40
