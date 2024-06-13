-- loja.itemcompra definition

CREATE TABLE `itemcompra` (
  `numero_compra` varchar(20) DEFAULT NULL,
  `codigo_prod` varchar(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `quantidade` decimal(5,2) DEFAULT NULL,
  KEY `numero_compra` (`numero_compra`),
  KEY `codigo_prod` (`codigo_prod`),
  CONSTRAINT `itemcompra_ibfk_1` FOREIGN KEY (`numero_compra`) REFERENCES `compra` (`numero_compra`),
  CONSTRAINT `ItemCompra_ibfk_2` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
