-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Set 10, 2014 as 10:41 PM
-- Versão do Servidor: 5.1.44
-- Versão do PHP: 5.3.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `painel_administrativo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_configuracao`
--

DROP TABLE IF EXISTS `sys_configuracao`;
CREATE TABLE IF NOT EXISTS `sys_configuracao` (
  `nome` varchar(100) NOT NULL,
  `valor` text,
  PRIMARY KEY (`nome`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sys_configuracao`
--

INSERT INTO `sys_configuracao` (`nome`, `valor`) VALUES
('EMAIL_CONTATO', ''),
('EMAIL_PASSWORD', ''),
('EMAIL_PORT', '587'),
('EMAIL_SMTP', ''),
('EMAIL_USERNAME', ''),
('PAGSEGURO_EMAIL', NULL),
('PAGSEGURO_TOKEN', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sys_mensagem`
--

DROP TABLE IF EXISTS `sys_mensagem`;
CREATE TABLE IF NOT EXISTS `sys_mensagem` (
  `id` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `nome` varchar(500) NOT NULL DEFAULT '',
  `tipo` enum('notify','success','warning','error','info','danger') NOT NULL DEFAULT 'notify',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `sys_mensagem`
--

INSERT INTO `sys_mensagem` (`id`, `nome`, `tipo`) VALUES
(00001, 'Houve um erro, por favor contactar o administrador', 'warning'),
(00002, 'Operação não pode ser concluída', 'warning'),
(00003, 'Login realizado com sucesso!', 'success'),
(00004, 'Login e senha incorretos', 'danger'),
(00005, 'Logout realizado com sucesso', 'success'),
(00006, 'Login e Senha são obrigatórios', 'danger'),
(00007, 'Informação não encontrada ou não existe', 'danger'),
(00008, 'Exclusão realizada com sucesso', 'success'),
(00009, 'Dados foram salvos com sucesso', 'success'),
(00010, 'Você deve estar logado para acessar está área', 'warning'),
(00011, 'Os campos %CAMPOS% são obrigatórios', 'danger'),
(00012, 'Login informado não existe', 'danger'),
(00014, 'Login não encontrado', 'danger'),
(00027, 'Por favor informe seu login de acesso!', 'warning'),
(00028, 'Enviamos um e-mail para o e-mail cadastrado!', 'success'),
(00029, 'Login não encontrado ou não existe!', 'danger'),
(00030, 'Houve um erro, por favor tente novamente', 'danger');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usu_grupo_usuario`
--

DROP TABLE IF EXISTS `usu_grupo_usuario`;
CREATE TABLE IF NOT EXISTS `usu_grupo_usuario` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL DEFAULT '',
  `deletado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usu_grupo_usuario`
--

INSERT INTO `usu_grupo_usuario` (`id`, `nome`, `deletado`) VALUES
(1, 'Administrador', 0),
(2, 'Comum', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usu_log`
--

DROP TABLE IF EXISTS `usu_log`;
CREATE TABLE IF NOT EXISTS `usu_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `acesso` varchar(255) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `descricao` text,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `usu_log`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `usu_metodo`
--

DROP TABLE IF EXISTS `usu_metodo`;
CREATE TABLE IF NOT EXISTS `usu_metodo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `modulo` varchar(45) NOT NULL,
  `classe` varchar(45) NOT NULL DEFAULT '',
  `metodo` varchar(45) NOT NULL DEFAULT '',
  `area` varchar(50) NOT NULL DEFAULT '',
  `apelido` varchar(50) NOT NULL DEFAULT '',
  `privado` tinyint(1) NOT NULL DEFAULT '0',
  `default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Extraindo dados da tabela `usu_metodo`
--

INSERT INTO `usu_metodo` (`id`, `modulo`, `classe`, `metodo`, `area`, `apelido`, `privado`, `default`) VALUES
(1, 'painel', 'main', 'index', 'Home', 'Visualizar', 1, 1),
(2, 'painel', 'main', 'login', '', '', 0, 0),
(3, 'painel', 'main', 'dologin', '', '', 0, 0),
(4, 'painel', 'main', 'page_not_found', '', '', 0, 0),
(7, 'painel', 'main', 'logout', '', '', 0, 0),
(8, 'painel', 'main', 'sempermissao', '', '', 0, 0),
(9, 'painel', 'log', 'index', 'Log', 'Visualizar', 1, 0),
(11, 'painel', 'usuario', 'index', 'Usuário', 'Visualizar', 1, 0),
(14, 'painel', 'usuario', 'alterar', 'Usuário', 'Alterar', 1, 0),
(16, 'painel', 'usuario', 'remover', 'Usuário', 'Remover', 1, 0),
(17, 'painel', 'usuario', 'adicionar', 'Usuário', 'Adicionar', 1, 0),
(20, 'painel', 'usuario', 'meus_dados', 'Usuário', 'Meus Dados', 1, 1),
(48, 'painel', 'grupo_usuario', 'index', 'Grupo de Usuário', 'Visualizar', 1, 0),
(49, 'painel', 'permissoes', 'index', 'Permissões', 'Visualizar', 1, 0),
(50, 'painel', 'configuracao', 'index', 'Configuração', 'Visualizar', 1, 0),
(52, 'painel', 'grupo_usuario', 'adicionar', 'Grupo de Usuário', 'Adicionar', 1, 0),
(54, 'painel', 'grupo_usuario', 'alterar', 'Grupo de Usuário', 'Alterar', 1, 0),
(55, 'painel', 'grupo_usuario', 'remover', 'Grupo de Usuário', 'Remover', 1, 0),
(60, 'painel', 'main', 'recupera_senha', '', '', 0, 0),
(67, 'painel', 'main', '404', '', '', 0, 0),
(71, 'painel', 'main', 'painel_nav', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usu_permissoes`
--

DROP TABLE IF EXISTS `usu_permissoes`;
CREATE TABLE IF NOT EXISTS `usu_permissoes` (
  `id_metodo` int(10) unsigned NOT NULL,
  `id_grupo_usuario` int(10) NOT NULL,
  PRIMARY KEY (`id_grupo_usuario`,`id_metodo`),
  KEY `id_metodo` (`id_metodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usu_permissoes`
--

INSERT INTO `usu_permissoes` (`id_metodo`, `id_grupo_usuario`) VALUES
(1, 1),
(1, 2),
(9, 1),
(11, 1),
(14, 1),
(16, 1),
(17, 1),
(20, 1),
(20, 2),
(48, 1),
(49, 1),
(50, 1),
(52, 1),
(54, 1),
(55, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usu_usuario`
--

DROP TABLE IF EXISTS `usu_usuario`;
CREATE TABLE IF NOT EXISTS `usu_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo_usuario` int(10) NOT NULL,
  `nome` varchar(200) NOT NULL DEFAULT '',
  `login` varchar(100) NOT NULL DEFAULT '',
  `senha` varchar(200) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `ativo` tinyint(1) DEFAULT '1',
  `deletado` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_grupo` (`id_grupo_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usu_usuario`
--

INSERT INTO `usu_usuario` (`id`, `id_grupo_usuario`, `nome`, `login`, `senha`, `email`, `ativo`, `deletado`, `data_cadastro`) VALUES
(1, 1, 'Administrador', 'admin', 'q61dzSNl+CDJP82xebqi+/PJDgMXfSUUkSCw/xI9CegjxMSoSfUoTmB5GWnbpHn9Zc5JybKSNRE1zvI16e7D0g==', 'my@email.com', 1, 0, '2013-07-04 22:25:58');

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `usu_log`
--
ALTER TABLE `usu_log`
  ADD CONSTRAINT `usu_log_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usu_usuario` (`id`);

--
-- Restrições para a tabela `usu_permissoes`
--
ALTER TABLE `usu_permissoes`
  ADD CONSTRAINT `usu_permissoes_ibfk_1` FOREIGN KEY (`id_metodo`) REFERENCES `usu_metodo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usu_permissoes_ibfk_2` FOREIGN KEY (`id_grupo_usuario`) REFERENCES `usu_grupo_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `usu_usuario`
--
ALTER TABLE `usu_usuario`
  ADD CONSTRAINT `usuario_grupo` FOREIGN KEY (`id_grupo_usuario`) REFERENCES `usu_grupo_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
