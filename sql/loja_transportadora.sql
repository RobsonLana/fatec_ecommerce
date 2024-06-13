-- loja.transportadora definition

CREATE TABLE `transportadora` (
  `cpf_cnpj_trans` varchar(18) NOT NULL,
  `nome_trans` varchar(50) DEFAULT NULL,
  `endereco_trans` varchar(50) DEFAULT NULL,
  `numero_trans` varchar(10) DEFAULT NULL,
  `bairro_trans` varchar(10) DEFAULT NULL,
  `cidade_trans` varchar(5) DEFAULT NULL,
  `estado_trans` varchar(2) DEFAULT NULL,
  `cep_trans` varchar(10) DEFAULT NULL,
  `valor_transporte` float DEFAULT NULL,
  PRIMARY KEY (`cpf_cnpj_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
