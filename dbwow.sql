-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Maio-2025 às 17:54
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbwow`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelos`
--

CREATE TABLE `modelos` (
  `id_modelo` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `modelos`
--

INSERT INTO `modelos` (`id_modelo`, `nome`) VALUES
(1, 'Urbanglide'),
(2, 'iScooter'),
(3, 'Segway'),
(4, 'Xiaomi');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoutilizador`
--

CREATE TABLE `tipoutilizador` (
  `id_tipo` int(11) NOT NULL,
  `descricao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tipoutilizador`
--

INSERT INTO `tipoutilizador` (`id_tipo`, `descricao`) VALUES
(1, 'administrador'),
(2, 'comum');

-- --------------------------------------------------------

--
-- Estrutura da tabela `trotinetes`
--

CREATE TABLE `trotinetes` (
  `id_trotinete` int(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `preco` float NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_modelo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `pass` text NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Índices para tabela `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Índices para tabela `trotinetes`
--
ALTER TABLE `trotinetes`
  ADD PRIMARY KEY (`id_trotinete`),
  ADD KEY `id_modelo` (`id_modelo`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD KEY `tipo` (`tipo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `trotinetes`
--
ALTER TABLE `trotinetes`
  MODIFY `id_trotinete` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `trotinetes`
--
ALTER TABLE `trotinetes`
  ADD CONSTRAINT `trotinetes_ibfk_1` FOREIGN KEY (`id_modelo`) REFERENCES `modelos` (`id_modelo`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `utilizadores_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipoutilizador` (`id_tipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
