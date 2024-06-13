-- loja.compra definition

CREATE TABLE `compra` (
  `numero_compra` varchar(20) NOT NULL,
  `data` date DEFAULT NULL,
  `valor_comissao` decimal(10,2) DEFAULT NULL,
  `valor_transporte` decimal(10,2) DEFAULT NULL,
  `cpf_cnpj_vend` varchar(18) DEFAULT NULL,
  `cpf_cnpj_trans` varchar(18) DEFAULT NULL,
  `cpf_cnpj_cli` varchar(18) DEFAULT NULL,
  `valor_total` float DEFAULT NULL,
  `total_itens` int DEFAULT NULL,
  `sub_total` float DEFAULT NULL,
  PRIMARY KEY (`numero_compra`),
  KEY `cpf_cnpj_vend` (`cpf_cnpj_vend`),
  KEY `cpf_cnpj_cli` (`cpf_cnpj_cli`),
  KEY `cpf_cnpj_trans` (`cpf_cnpj_trans`),
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cpf_cnpj_vend`) REFERENCES `vendedor` (`cpf_cnpj_vend`),
  CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`cpf_cnpj_cli`) REFERENCES `cliente` (`cpf_cnpj_cli`),
  CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`cpf_cnpj_trans`) REFERENCES `transportadora` (`cpf_cnpj_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
