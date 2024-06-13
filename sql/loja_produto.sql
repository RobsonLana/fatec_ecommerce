-- loja.produto definition

CREATE TABLE `produto` (
  `codigo_prod` varchar(20) NOT NULL,
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
