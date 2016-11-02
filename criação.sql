
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

#############################################################################################################

CREATE TABLE IF NOT EXISTS master (
  id int(10) unsigned NOT NULL  AUTO_INCREMENT,
  nome varchar(30) NOT NULL,
  email varchar(40) NOT NULL,
  senha varchar(50) NOT NULL,
  PRIMARY KEY (id)
);

#############################################################################################################

CREATE TABLE IF NOT EXISTS tipo_lixo (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome varchar(20) NOT NULL,
  nome_eng varchar(20) NOT NULL
) AUTO_INCREMENT=29 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS usuario (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome varchar(30) NOT NULL,
  email varchar(40) NOT NULL UNIQUE KEY,
  senha varchar(50) NOT NULL,
  cpf varchar(11) NOT NULL UNIQUE KEY,
  telefone varchar(25) NOT NULL
) AUTO_INCREMENT=28 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS empresa (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  razao_social varchar(40) NOT NULL,
  nome_fantasia varchar(40) NOT NULL,
  cnpj varchar(14) NULL,
  senha varchar(50) NOT NULL,
  email varchar(50) NOT NULL UNIQUE KEY
) AUTO_INCREMENT=3 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS endereco (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  rua varchar(40) NOT NULL,
  num int(6) NOT NULL,
  complemento varchar(20) NULL,
  cep varchar(8) NOT NULL,
  bairro varchar(40) NOT NULL,
  uf varchar(2) NOT NULL,
  cidade varchar(40) NOT NULL,
  pais varchar(20) NOT NULL,
  latitude double NOT NULL,
  longitude double NOT NULL
) AUTO_INCREMENT=35 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS agendamento (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  empresa_id int(10) unsigned NOT NULL,
  usuario_id int(10) unsigned NOT NULL,
  data_agendamento date NOT NULL,
  horario time NOT NULL,
  aceito tinyint(1) NOT NULL,
  realizado tinyint(1) NOT NULL,
  endereco_id int(10) unsigned NOT NULL,
  justificativa varchar(200) NULL,
  FOREIGN KEY (empresa_id) REFERENCES empresa(id),
  FOREIGN KEY (usuario_id) REFERENCES usuario(id),
  FOREIGN KEY (endereco_id) REFERENCES endereco(id)
) AUTO_INCREMENT=57 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS agendamento_has_tipo_lixo (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo_lixo_id int(10) unsigned NOT NULL,
  agendamento_id int(10) unsigned NOT NULL,
  quantidade double NOT NULL,
  FOREIGN KEY (tipo_lixo_id) REFERENCES tipo_lixo(id),
  FOREIGN KEY (agendamento_id) REFERENCES agendamento(id)
) AUTO_INCREMENT=79 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS notificacao (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  usuario_id int(10) unsigned NOT NULL,
  empresa_id int(10) unsigned NOT NULL,
  tipo int(11) NOT NULL,
  destino tinyint(1) NOT NULL,
  visualizado tinyint(1) NOT NULL,
  FOREIGN KEY (empresa_id) REFERENCES empresa(id),
  FOREIGN KEY (usuario_id) REFERENCES usuario(id)
) AUTO_INCREMENT=46 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS ponto (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  empresa_id int(10) unsigned NOT NULL,
  atendimento_ini time NOT NULL,
  atendimento_fim time NOT NULL,
  observacao varchar(250) NULL,
  telefone varchar(25) NOT NULL,
  endereco_id int(10) unsigned NOT NULL,
  FOREIGN KEY (empresa_id) REFERENCES empresa(id),
  FOREIGN KEY (endereco_id) REFERENCES endereco(id)
) AUTO_INCREMENT=15 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS tipo_lixo_has_ponto (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo_lixo_id int(10) unsigned NULL,
  ponto_id int(10) unsigned NULL,
  FOREIGN KEY (tipo_lixo_id) REFERENCES tipo_lixo(id),
  FOREIGN KEY (ponto_id) REFERENCES ponto(id)
) AUTO_INCREMENT=73 ;

#############################################################################################################

CREATE TABLE IF NOT EXISTS usuario_has_endereco (
  id int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  usuario_id int(10) unsigned NOT NULL,
  endereco_id int(10) unsigned NOT NULL,
  nome varchar(20) NOT NULL,
  FOREIGN KEY (endereco_id) REFERENCES endereco(id),
  FOREIGN KEY (usuario_id) REFERENCES usuario(id)
) AUTO_INCREMENT=18 ;

