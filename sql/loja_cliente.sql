-- loja.cliente definition

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
