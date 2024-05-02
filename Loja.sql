SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE loja ;


USE loja ;

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `categoria` (`id`, `nome`) VALUES
(2, 'Decoração'),
(3, 'Vestuário'),
(6, 'Utensilio de cozinha');


CREATE TABLE `cliente` (
  `cpf_cnpj_cli` varchar(18) NOT NULL,
  `nome_cli` varchar(50) DEFAULT NULL,
  `numero_cli` varchar(10) DEFAULT NULL,
  `bairro_cli` varchar(10) DEFAULT NULL,
  `cidade_cli` varchar(20) DEFAULT NULL,
  `cep_cli` varchar(10) DEFAULT NULL,
  `estado_cli` varchar(2) DEFAULT NULL,
  `endereco_cli` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `compra` (
  `numero_compra` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `valor_comissao` decimal(10,2) DEFAULT NULL,
  `valor_transporte` decimal(10,2) DEFAULT NULL,
  `cpf_cnpj_vend` varchar(18) DEFAULT NULL,
  `cpf_cnpj_trans` varchar(18) DEFAULT NULL,
  `cpf_cnpj_cli` varchar(18) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `imagem` (
  `codigo_img` int(11) NOT NULL,
  `codigo_prod` varchar(10) DEFAULT NULL,
  `nome_arquivo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `itemcompra` (
  `numero_compra` int(11) DEFAULT NULL,
  `codigo_prod` varchar(10) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `quantidade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `produto` (
  `codigo_prod` varchar(10) NOT NULL,
  `nome_pro` varchar(50) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  `quantidade` decimal(5,2) DEFAULT NULL,
  `peso` varchar(10) DEFAULT NULL,
  `dimensoes` varchar(15) DEFAULT NULL,
  `unidade_Venda` varchar(3) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `transportadora` (
  `cpf_cnpj_trans` varchar(18) NOT NULL,
  `nome_trans` varchar(50) DEFAULT NULL,
  `endereco_trans` varchar(50) DEFAULT NULL,
  `numero_trans` varchar(10) DEFAULT NULL,
  `bairro_trans` varchar(10) DEFAULT NULL,
  `cidade_trans` varchar(5) DEFAULT NULL,
  `estado_trans` varchar(2) DEFAULT NULL,
  `cep_trans` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `vendedor` (
  `cpf_cnpj_vend` varchar(18) NOT NULL,
  `nome_vend` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cpf_cnpj_cli`);


ALTER TABLE `compra`
  ADD PRIMARY KEY (`numero_compra`),
  ADD KEY `cpf_cnpj_vend` (`cpf_cnpj_vend`),
  ADD KEY `cpf_cnpj_cli` (`cpf_cnpj_cli`),
  ADD KEY `cpf_cnpj_trans` (`cpf_cnpj_trans`);


ALTER TABLE `imagem`
  ADD PRIMARY KEY (`codigo_img`),
  ADD KEY `codigo_prod` (`codigo_prod`);


ALTER TABLE `itemcompra`
  ADD KEY `numero_compra` (`numero_compra`),
  ADD KEY `codigo_prod` (`codigo_prod`);


ALTER TABLE `produto`
  ADD PRIMARY KEY (`codigo_prod`),
  ADD KEY `id` (`id`);


ALTER TABLE `transportadora`
  ADD PRIMARY KEY (`cpf_cnpj_trans`);


ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`cpf_cnpj_vend`);


ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

 
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`cpf_cnpj_vend`) REFERENCES `vendedor` (`cpf_cnpj_vend`),
  ADD CONSTRAINT `compra_ibfk_2` FOREIGN KEY (`cpf_cnpj_cli`) REFERENCES `cliente` (`cpf_cnpj_cli`),
  ADD CONSTRAINT `compra_ibfk_3` FOREIGN KEY (`cpf_cnpj_trans`) REFERENCES `transportadora` (`cpf_cnpj_trans`);


ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`);


ALTER TABLE `itemcompra`
  ADD CONSTRAINT `ItemCompra_ibfk_1` FOREIGN KEY (`numero_compra`) REFERENCES `compra` (`numero_compra`),
  ADD CONSTRAINT `ItemCompra_ibfk_2` FOREIGN KEY (`codigo_prod`) REFERENCES `produto` (`codigo_prod`);


ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`id`) REFERENCES `categoria` (`id`);

