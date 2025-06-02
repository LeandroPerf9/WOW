-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Jun-2025 às 17:55
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
CREATE DATABASE IF NOT EXISTS `dbwow` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbwow`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelos`
--
-- Criação: 19-Maio-2025 às 15:38
--

DROP TABLE IF EXISTS `modelos`;
CREATE TABLE `modelos` (
  `id_marca` int(11) NOT NULL,
  `marca` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `modelos`:
--

--
-- Extraindo dados da tabela `modelos`
--

INSERT INTO `modelos` (`id_marca`, `marca`) VALUES
(1, 'Urbanglide'),
(2, 'iScooter'),
(3, 'Segway'),
(4, 'Xiaomi');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoutilizador`
--
-- Criação: 09-Maio-2025 às 11:59
--

DROP TABLE IF EXISTS `tipoutilizador`;
CREATE TABLE `tipoutilizador` (
  `id_tipo` int(11) NOT NULL,
  `descricao` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `tipoutilizador`:
--

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
-- Criação: 19-Maio-2025 às 15:39
-- Última actualização: 19-Maio-2025 às 15:15
--

DROP TABLE IF EXISTS `trotinetes`;
CREATE TABLE `trotinetes` (
  `id_trotinete` int(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `preco` float NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `trotinetes`:
--   `id_marca`
--       `modelos` -> `id_marca`
--

--
-- Extraindo dados da tabela `trotinetes`
--

INSERT INTO `trotinetes` (`id_trotinete`, `modelo`, `descricao`, `preco`, `imagem`, `id_marca`) VALUES
(1, 'Urbanglide', 'Com um design moderno, ideais para deslocações urbanas. São leves, fáceis de transportar e combinam conforto com eficiência. Perfeitas para quem procura uma alternativa prática, económica e ecológica para o dia a dia na cidade.', 329.9, 'IMAGENS\\urbanglide.jpg', 1),
(2, 'iScooter', 'Versatilidade e bom desempenho a um preço acessível. Com modelos robustos e autonomia confiável, são ideais tanto para iniciantes como para utilizadores frequentes. Pensadas para oferecer segurança e praticidade, sendo  ideal para deslocações diárias.', 299, 'IMAGENS\\iScooter.jpg', 2),
(3, 'Segway', 'Sinónimo de tecnologia de ponta e inovação em mobilidade elétrica. As suas trotinetes oferecem estabilidade avançada, sistemas inteligentes de travagem e construção premium. Ideais para quem valoriza desempenho, segurança e uma experiência de condução mai', 249, 'IMAGENS\\Segway2.jpg', 3),
(4, 'Xiaomi', 'Design minimalista e funcional, com trotinetes leves e fáceis de transportar. São ideais para trajetos urbanos curtos, combinando boa autonomia com simplicidade de uso. A estrutura mais leve facilita o manuseio, tornando-as perfeitas para quem valoriza po', 419, 'IMAGENS\\xiaomi.jpg', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--
-- Criação: 09-Maio-2025 às 12:01
-- Última actualização: 02-Jun-2025 às 15:50
--

DROP TABLE IF EXISTS `utilizadores`;
CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `pass` text NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELACIONAMENTOS PARA TABELAS `utilizadores`:
--   `tipo`
--       `tipoutilizador` -> `id_tipo`
--

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizador`, `nome`, `pass`, `tipo`) VALUES
(1, 'admin', '$2y$10$wv4eAq5VnCZZIo0Z88392uroSKERxrem6QYtQbjoR8q7ujO4AUsGa', 2),
(2, 'admin1', '$2y$10$9IMMk3NuxqloswbwXbuHEOjbunxSgnk16AKTTQHv7NDtFQF3gSzC.', 2),
(3, 'admin2', '$2y$10$kZ9SMH5Rhvl.kPsD58R/D.hoJjk6HSVnFd0j3D3PPWBcSSK3wAgfi', 2),
(4, 'admin23', '$2y$10$T6MBqyr/c4IbxZv1dQC3LOh4y.3eIoNcb6NRAiL60Jd.4FgI8tud2', 2),
(5, 'teste123', '$2y$10$Y2MSaryt6WJDal93U1GLG.ie2XBbcxCibT1MDPw23D2RcH6/7JcsG', 2),
(6, 'admin9', '$2y$10$FtiHajKVOlGcyjci141pkO5hb5rAzpOzByJLUQ4X0R9u9/pn5u9Yy', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id_marca`);

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
  ADD KEY `id_modelo` (`id_marca`);

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
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `trotinetes`
--
ALTER TABLE `trotinetes`
  MODIFY `id_trotinete` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `trotinetes`
--
ALTER TABLE `trotinetes`
  ADD CONSTRAINT `trotinetes_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `modelos` (`id_marca`);

--
-- Limitadores para a tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD CONSTRAINT `utilizadores_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipoutilizador` (`id_tipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
