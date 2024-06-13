-- loja.vendedor definition

CREATE TABLE `vendedor` (
  `cpf_cnpj_vend` varchar(18) NOT NULL,
  `nome_vend` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj_vend`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
