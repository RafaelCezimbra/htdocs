-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 23/04/2024 às 19:17
-- Versão do servidor: 5.7.39
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cpphp_ex`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Consultas`
--

CREATE TABLE `Consultas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `acoes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `Projetos`
--

CREATE TABLE `Projetos` (
  `id_projeto` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data_criacao` date DEFAULT NULL,
  `tecnologia_associada` varchar(255) DEFAULT NULL,
  `imagem` blob,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `Projetos`
--

INSERT INTO `Projetos` (`id_projeto`, `user_id`, `data_criacao`, `tecnologia_associada`, `imagem`, `status`) VALUES
(1, 1, '2024-04-23', 'html', NULL, 'Concluído'),
(2, 1, '2024-05-07', 'MySQL', 0x696d6167656e732f77656c636f6d652e706e67, 'marcado'),
(3, 1, '2024-04-23', 'Foto', 0x696d6167656e732f706578656c732d636872697374696e612d6d6f72696c6c6f2d313138313332352e6a7067, 'em_progresso'),
(4, 1, '2024-04-23', 'Foto', 0x696d6167656e732f706578656c732d636872697374696e612d6d6f72696c6c6f2d313138313332352e6a7067, 'em_progresso'),
(5, 1, '2024-04-23', 'Foto', 0x696d6167656e732f706578656c732d636872697374696e612d6d6f72696c6c6f2d313138313332352e6a7067, 'em_progresso'),
(6, 1, '2024-04-23', 'html', 0x696d6167656e732f77656c636f6d652e706e67, 'marcado'),
(7, 1, '2024-04-23', 'html', 0x696d6167656e732f77656c636f6d652e706e67, 'marcado'),
(8, 1, '2024-04-23', 'html', 0x696d6167656e732f77656c636f6d652e706e67, 'marcado'),
(9, 1, '2024-04-23', 'html', 0x696d6167656e732f706572736f6e612e6a7067, 'em_progresso'),
(10, 1, '2024-04-23', 'html', 0x696d6167656e732f706572736f6e612e6a7067, 'em_progresso'),
(11, 1, '2024-04-23', 'html', 0x696d6167656e732f706572736f6e612e6a7067, 'em_progresso'),
(12, 1, '2024-04-23', 'html', 0x696d6167656e732f61646d696e2e6a7067, 'em_progresso'),
(13, 1, '2024-04-23', 'html', 0x696d6167656e732f61646d696e2e6a7067, 'em_progresso');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Utilizadores`
--

CREATE TABLE `Utilizadores` (
  `user_id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `Utilizadores`
--

INSERT INTO `Utilizadores` (`user_id`, `nome`, `apelido`, `user_name`, `email`, `password`, `user_type`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin.com', 'admin1234', 'administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Consultas`
--
ALTER TABLE `Consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `Projetos`
--
ALTER TABLE `Projetos`
  ADD PRIMARY KEY (`id_projeto`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `Utilizadores`
--
ALTER TABLE `Utilizadores`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Consultas`
--
ALTER TABLE `Consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `Projetos`
--
ALTER TABLE `Projetos`
  MODIFY `id_projeto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `Utilizadores`
--
ALTER TABLE `Utilizadores`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Consultas`
--
ALTER TABLE `Consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Utilizadores` (`user_id`);

--
-- Restrições para tabelas `Projetos`
--
ALTER TABLE `Projetos`
  ADD CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Utilizadores` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
