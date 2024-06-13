-- loja.imagem definition

CREATE TABLE `imagem` (
  `codigo_img` int NOT NULL AUTO_INCREMENT,
  `codigo_prod` varchar(20) DEFAULT NULL,
  `nome_arquivo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigo_img`),
  KEY `codigo_prod` (`codigo_prod`),
  CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
