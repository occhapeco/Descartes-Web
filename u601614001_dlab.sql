
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 16/10/2016 às 13:35:43
-- Versão do Servidor: 10.0.20-MariaDB
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u601614001_dlab`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `master`
--

CREATE TABLE IF NOT EXISTS `master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);


-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE IF NOT EXISTS `agendamento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(10) unsigned DEFAULT NULL,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `data_agendamento` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `aceito` tinyint(1) DEFAULT NULL,
  `realizado` tinyint(1) DEFAULT NULL,
  `endereco_id` int(10) unsigned DEFAULT NULL,
  `justificativa` varchar(200) NULL,
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `endereco_id` (`endereco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `agendamento`
--

INSERT INTO `agendamento` (`id`, `empresa_id`, `usuario_id`, `data_agendamento`, `horario`, `aceito`, `realizado`, `endereco_id`, `justificativa`) VALUES
(51, 2, 24, '2016-10-12', '12:00:00', 1, 1, 20, NULL),
(53, 2, 24, '2016-09-04', '11:00:00', 1, 1, 20, NULL),
(56, 2, 24, '2016-10-25', '11:00:00', 1, 1, 20, NULL),
(54, 2, 24, '2016-10-01', '11:00:00', 0, 1, 20, "Atraso na coleta"),
(55, 2, 24, '2016-10-29', '11:00:00', 1, 0, 20, NULL),
(52, 2, 24, '2016-10-01', '11:00:00', 0, 0, 20, NULL),
(50, 2, 24, '2016-10-03', '11:00:00', 1, 0, 20, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento_has_tipo_lixo`
--

CREATE TABLE IF NOT EXISTS `agendamento_has_tipo_lixo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_lixo_id` int(10) unsigned DEFAULT NULL,
  `agendamento_id` int(10) unsigned DEFAULT NULL,
  `quantidade` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_lixo_id` (`tipo_lixo_id`),
  KEY `agendamento_id` (`agendamento_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Extraindo dados da tabela `agendamento_has_tipo_lixo`
--

INSERT INTO `agendamento_has_tipo_lixo` (`id`, `tipo_lixo_id`, `agendamento_id`, `quantidade`) VALUES
(76, 7, 50, 652),
(75, 5, 50, 652),
(74, 2, 50, 652),
(78, 5, 51, 12),
(77, 23, 51, 12),
(58, 3, 39, 45),
(57, 2, 39, 45),
(56, 1, 39, 45),
(55, 2, 38, 25),
(54, 1, 38, 25),
(53, 5, 37, 456),
(52, 4, 37, 456),
(51, 2, 36, 562),
(50, 1, 36, 562),
(43, 4, 33, 20),
(42, 3, 33, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `razao_social` varchar(40) DEFAULT NULL,
  `nome_fantasia` varchar(40) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id`, `razao_social`, `nome_fantasia`, `cnpj`, `senha`, `email`) VALUES
(2, 'Batata', 'Batata Frita', '456123654521', '8467b174e821587c4a0545fd8e57204a398c66d4', 'batata@batata');

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rua` varchar(40) DEFAULT NULL,
  `num` int(6) DEFAULT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `bairro` varchar(40) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `pais` varchar(20) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id`, `rua`, `num`, `complemento`, `cep`, `bairro`, `uf`, `cidade`, `pais`, `latitude`, `longitude`) VALUES
(26, 'Avenida José Medeiros Viêira', 222, '2222', '88306800', 'Eldorado', 'Sa', 'Itajaí', 'Brasil', -26.950504372188, -48.629693984985),
(22, 'getulio vargas', 250, 'E', '89809000', 'centro', 'ch', '', 'brasil', -27.1069807, -52.6138909),
(7, 'Pombos', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', -27.0949378, -52.67517220000002),
(28, 'cristo redentor', 466, 'd', '89803150', 'sao cristovao', 'sc', 'chapeco', 'brasil', -27.0909202, -52.6282188),
(30, 'Rua Jaguatiric', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', 0, 0),
(23, 'Avenida Getúlio Dorneles Vargas', 25, 'E', '89805186', 'Belvedere', 'Sa', 'Chapecó', 'Brasil', -27.087288710935, -52.618846893311),
(29, 'Rua Jaguatirica', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', 0, 0),
(13, 'cristo redentor', 466, 'D', '89803150', 'São cristóvão', 'SC', 'Chapecó', 'Brasil', -27.0909202, -52.62821880000001),
(18, 'Rua  Cristo Redentor', 466, 'D', '89803150', 'São Cristóvão', 'SC', 'Chapecó', 'Brasil', -27.0909202, -52.62821880000001),
(20, 'Avenida Paulista', 2, 'Apt. 4', '1234567', 'Bela Vista', 'SP', 'São Paulo', 'Brasil', -27.0909202, -52.62821880000001),
(31, 'Rua Jaguatirica', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', 0, 0),
(32, 'Rua Jaguatirica', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', -27.0939279, -52.6739075),
(33, 'Rua Jaguatirica', 45, 'E', '89809000', 'Efapi', 'SC', 'Chapecó', 'Brasil', -27.0939279, -52.6739075),
(34, '15 de nobembri', 34, '', '98400000', 'oi', 'sc', 'chapeco', 'bRASIL', -27.0948501, -52.63302490000001);

-- --------------------------------------------------------

--
-- Estrutura da tabela `notificacao`
--

CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `destino` tinyint(1) DEFAULT NULL,
  `visualizado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Extraindo dados da tabela `notificacao`
--

INSERT INTO `notificacao` (`id`, `usuario_id`, `empresa_id`, `tipo`, `destino`, `visualizado`) VALUES
(25, 24, 2, 1, 0, 0),
(24, 24, 2, 1, 0, 0),
(23, 24, 2, 2, 1, 0),
(22, 24, 2, 2, 1, 0),
(21, 24, 0, 2, 1, 0),
(45, 24, 2, 0, 0, 0),
(28, 24, 2, 2, 1, 0),
(29, 24, 2, 3, 1, 0),
(30, 24, 2, 3, 1, 0),
(31, 24, 2, 3, 1, 0),
(32, 24, 2, 2, 1, 0),
(33, 24, 2, 2, 1, 0),
(34, 24, 2, 3, 1, 0),
(35, 24, 2, 1, 0, 0),
(36, 24, 2, 2, 1, 0),
(37, 24, 2, 2, 1, 0),
(38, 24, 2, 3, 1, 0),
(39, 24, 2, 2, 1, 0),
(40, 24, 2, 2, 1, 0),
(41, 24, 2, 1, 0, 0),
(42, 24, 2, 0, 0, 0),
(44, 24, 2, 2, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ponto`
--

CREATE TABLE IF NOT EXISTS `ponto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(10) unsigned DEFAULT NULL,
  `atendimento_ini` time DEFAULT NULL,
  `atendimento_fim` time DEFAULT NULL,
  `observacao` varchar(250) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  `endereco_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `empresa_id` (`empresa_id`),
  KEY `endereco_id` (`endereco_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `ponto`
--

INSERT INTO `ponto` (`id`, `empresa_id`, `atendimento_ini`, `atendimento_fim`, `observacao`, `telefone`, `endereco_id`) VALUES
(10, 2, '12:00:00', '12:00:00', 'Batata', '49 9999-9999', 29),
(6, 2, '23:32:00', '02:56:00', 'É muito legal', '49 9898-9898', 23),
(9, 2, '08:00:00', '12:00:00', 'oi', '33 4422-1122', 26),
(11, 2, '12:00:00', '12:00:00', 'aaaaaa', '44 4444-4444', 30),
(12, 2, '12:00:00', '12:00:00', '4444444', '44 4444-4444', 31),
(13, 2, '12:00:00', '12:00:00', 'ssssssss', '44 4444-4444', 32),
(14, 2, '12:00:00', '12:00:00', 'aaaa', '44 4444-4444', 33);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_lixo`
--

CREATE TABLE IF NOT EXISTS `tipo_lixo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) DEFAULT NULL,
  `nome_eng` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Extraindo dados da tabela `tipo_lixo`
--

INSERT INTO `tipo_lixo` (`id`, `nome`, `nome_eng`) VALUES
(1, 'Plástico','Plastic'),
(2, 'Metal','Metal'),
(3, 'Vidro','Glass'),
(4, 'Eletrônico','Electronic'),
(5, 'Borracha','Rubbee'),
(10, 'Madeira','Wood'),
(7, 'Hospitalar','Hospital'),
(8, 'Radioativo','Radioactive'),
(9, 'Tóxico','Toxic'),
(17, 'Óleo (lubrificante)','Lubricating Oil'),
(16, 'Orgânico','Organic'),
(13, 'Isopor','Styrofoam'),
(15, 'Corrosivo','Corrosive'),
(18, 'Óleo (cozinha)','Kitchen Oil'),
(19, 'Baterias e pilhas','Batteries'),
(20, 'Alvenaria (entulho)','Rubble'),
(21, 'Lâmpadas','Lamps'),
(22, 'Fiação elétrica','Electrical wiring'),
(23, 'Aviamento','Threads(Strings)'),
(24, 'Botijão de gás','Gas cylinder'),
(26, 'Toner','Toner'),
(27, 'Químico (em geral)','Chemical (General)'),
(28, 'Ferragem','Metal hardware');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_lixo_has_ponto`
--

CREATE TABLE IF NOT EXISTS `tipo_lixo_has_ponto` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_lixo_id` int(10) unsigned DEFAULT NULL,
  `ponto_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_lixo_id` (`tipo_lixo_id`),
  KEY `ponto_id` (`ponto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Extraindo dados da tabela `tipo_lixo_has_ponto`
--

INSERT INTO `tipo_lixo_has_ponto` (`id`, `tipo_lixo_id`, `ponto_id`) VALUES
(55, 18, 10),
(54, 15, 10),
(53, 13, 10),
(52, 16, 10),
(51, 17, 10),
(50, 9, 10),
(43, 2, 10),
(49, 8, 10),
(42, 1, 10),
(41, 23, 9),
(40, 5, 9),
(39, 3, 9),
(48, 7, 10),
(47, 10, 10),
(46, 5, 10),
(45, 4, 10),
(44, 3, 10),
(28, 27, 6),
(27, 19, 6),
(26, 15, 6),
(25, 9, 6),
(24, 8, 6),
(56, 19, 10),
(57, 20, 10),
(58, 21, 10),
(59, 22, 10),
(60, 23, 10),
(61, 24, 10),
(62, 26, 10),
(63, 27, 10),
(64, 28, 10),
(65, 1, 11),
(66, 3, 11),
(67, 1, 12),
(68, 3, 12),
(69, 1, 13),
(70, 3, 13),
(71, 1, 14),
(72, 3, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `telefone` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `cpf`, `telefone`) VALUES
(27, 'Katharyne Oliveira ', 'katharynebeatryz@gmail.com', '71d98a1753bc49c5dd2ecfd10da62d09ab76ab7b', '05884774435', '82987217599'),
(26, 'wagner', 'wagner@oi.com', '8cb2237d0679ca88db6464eac60da96345513964', '02598156080', '5533221144'),
(25, 'Andrew Malta', 'andrewsaxx@gmail.com', 'b348abb335f4e54649b53f95d3ac4371390bce58', '44768438830', '4998259128'),
(24, 'José ', 'oie@oie', '06f58c80bb949467a59aeeb0fd54cdb28070290b', '44768438830', '4555443322');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_has_endereco`
--

CREATE TABLE IF NOT EXISTS `usuario_has_endereco` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `endereco_id` int(10) unsigned DEFAULT NULL,
  `nome` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `endereco_id` (`endereco_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `usuario_has_endereco`
--

INSERT INTO `usuario_has_endereco` (`id`, `usuario_id`, `endereco_id`, `nome`) VALUES
(1, 1, 7, 'Casa das pamonha'),
(16, 24, 28, 'praça'),
(17, 26, 34, 'oi'),
(7, 1, 13, 'oiem'),
(12, 7, 18, 'Batata'),
(13, 24, 20, 'Casa'),
(14, 24, 22, 'diva');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
