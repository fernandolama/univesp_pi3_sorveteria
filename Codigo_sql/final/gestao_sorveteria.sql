-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/11/2024 às 06:54
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestao_sorveteria`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(5) NOT NULL,
  `produto` varchar(80) NOT NULL,
  `marca` varchar(60) NOT NULL,
  `descricao` text NOT NULL,
  `departamento` varchar(40) NOT NULL,
  `secao` varchar(40) NOT NULL,
  `quantidade` int(5) NOT NULL,
  `preco` decimal(15,2) NOT NULL,
  `foto1` varchar(60) NOT NULL,
  `foto2` varchar(60) NOT NULL,
  `foto3` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `produto`, `marca`, `descricao`, `departamento`, `secao`, `quantidade`, `preco`, `foto1`, `foto2`, `foto3`) VALUES
(1, 'MORANGO', 'OUTROS', 'picolé de morango', 'OUTROS', 'OUTROS', 60, 2.50, '5e8a35bdb4d8849dd4f9d2edf062e402.jpg', '54b638c9e2c8b3533c0bb866e67a7cdb.jpg', '3d18ab79c03262de92affe79675879a3.jpg'),
(2, 'AÇAÍ', 'acai', 'Açaí natural.', 'OUTROS', 'OUTROS', 58, 15.00, '63f1715180879bf381535e839115704a.jpg', 'bf757c15468a98ddcab79dccffbf4e00.jpg', '3378d8cbbd2fec2e15d992d225d63453.jpg'),
(24, 'ABACAXI AO VINHO', 'Pote', 'Sorvete com pedaços de abacaxi e sabor de vinho.', 'CASQUINHA', 'MORANGO', 100, 4.50, '312f950dc87d5c65864cdadf0541046f.jpeg', '4084c268b0599691010ad91aea47a410.jpeg', '00bbfe5aebc06c84590ae42821fbe9b9.jpeg'),
(25, 'CHOCOLATE', 'sorvete de Massa', 'Sorvete de chocolate meio amargo.', 'MASSA', 'CHOCOLATE', 50, 4.50, 'c8eaa908b72f2d3820fa809d29869320.jpg', 'c0e32d81a25f31e74bddce637a6b2c66.jpeg', '30dffea0b8d9ddafb4d9b1f7c2e61277.jpeg'),
(26, 'Abacaxi', 'sorvete de palito', 'Sorvete de abacaxi', 'PALITO', 'OUTROS', 200, 2.50, '20486ce7ee23c6fedb657099ac30c259.jpg', '31d672c01d099ba3084b52519f81802a.jpg', 'd6f28e685876e142d127207362a305c9.jpg'),
(27, 'Flocos', 'sorvete de Massa', 'Sorvete de Flocos', 'MASSA', 'OUTROS', 50, 4.50, 'be97fa8c5dcb5c53a47571dca35bbe09.jpg', '0638c8ef7b7316887be3e54bc5c1c6a8.jpg', '178801884b9014d45926deb62cbc10fd.jpg'),
(28, 'Ninho Trufado', 'sorvete de Massa', 'Ninho Trufado', 'MASSA', 'NINHO_TRUFADO', 50, 4.50, 'cddbcd15677396f72668c856f26ea420.jpeg', 'e1cfe8d8e9c86a34567be98cb6b87b79.jpeg', 'c9601d9fc700b1f1984707aec65a003d.jpeg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_user` int(4) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `sobrenome` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `adm` tinyint(1) NOT NULL,
  `endereco` text NOT NULL,
  `numero` varchar(11) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_user`, `nome`, `sobrenome`, `email`, `senha`, `adm`, `endereco`, `numero`, `cidade`, `cep`) VALUES
(1, 'Administrador', 'Administrador', 'adm@email.com', '123', 1, 'Endereço Teste', '', 'Teste', '14871370'),
(2, 'Usuario', 'Usuario', 'user@email.com', '123', 0, 'Endereço Teste', '', 'Itamogi', '37973000'),
(3, 'Edriano', 'Moreira Santana', 'edrianoms@gmail.com', '123', 0, 'Rua: Joaquim José de Medeiros, nº 1181, Jd. das Palmeiras.', '', 'Itamogi', '37 973-00'),
(4, 'Leandro', 'Santana', 'leandro@email.com', '123', 0, 'Rua: Joaquim José de Medeiros, nº 1170, Jd. das Palmeiras.', '', 'Itamogi', '37973000'),
(5, 'Maria', 'Aparecida', 'univespcursos@outlook.com', '123', 0, 'Rua: Joaquim José de Medeiros, nº 1170, Jd. das Palmeiras.', '', 'Itamogi', '37973000'),
(6, 'Marisa', 'Aparecida', 'leandro@gmail.com', '123', 0, 'Rua: Joaquim José de Medeiros, nº 1181, Jd. das Palmeiras.', '', 'Itamogi', '37973000'),
(7, 'Jose', 'Silva', 'silva@gmail.com', '123', 0, 'Rua Presidente Vargas, n 427', '', 'Itamogi', '37973970'),
(8, 'Elisa', 'Santana', 'elisa@gmail.com', '123', 0, 'Praça Nossa Senhora dos Milagres', '', 'Monte Santo de Minas', '37969971'),
(13, 'Gabriella', 'Santana', 'gabi@gmail.com', '123', 0, 'Rua Adholpho Coelho Lemos', '500', 'Passos', '37900973'),
(14, 'Leonardo', 'Silva', 'leonardo@gmail.com', '123', 0, 'Rua Coronel João de Barros', '223', 'Passos', '37900970'),
(15, 'Nivaldo', 'Moreira Santana', 'nivaldo@gmail.com', '123', 0, 'Rua Coronel Lucas Magalhães', '50', 'Arceburgo', '37820970');

-- --------------------------------------------------------

--
-- Estrutura para tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(4) NOT NULL,
  `ticket` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_comprador` int(4) NOT NULL,
  `id_produto` int(4) NOT NULL,
  `quantidade` int(4) NOT NULL,
  `data` date NOT NULL,
  `valor` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `ticket`, `id_comprador`, `id_produto`, `quantidade`, `data`, `valor`) VALUES
(1, '67255fe2dc227', 3, 1, 1, '2024-11-01', 2.50),
(2, '672562c19b786', 3, 1, 4, '2024-11-01', 2.50),
(3, '6725632b198e8', 3, 1, 3, '2024-11-01', 15.00),
(4, '672564bad70dd', 3, 23, 3, '2024-11-01', 0.00),
(5, '672564bad70dd', 3, 1, 1, '2024-11-01', 2.50),
(6, '672568d03c927', 1, 1, 2, '2024-11-02', 2.50),
(7, '672568d03c927', 1, 2, 2, '2024-11-02', 15.00),
(8, '6725690b830dc', 1, 1, 2, '2024-11-02', 2.50),
(9, '6725690b830dc', 1, 2, 2, '2024-11-02', 15.00),
(10, '67256939983f5', 1, 1, 1, '2024-11-02', 2.50),
(11, '67257d4728071', 2, 2, 2, '2024-11-02', 15.00),
(12, '6725839538fd5', 1, 1, 1, '2024-11-02', 2.50),
(13, '672583de2a0f1', 1, 1, 1, '2024-11-02', 2.50),
(14, '672583de2a0f1', 1, 2, 1, '2024-11-02', 15.00),
(15, '6725858bd9c72', 1, 1, 1, '2024-11-02', 2.50),
(16, '6725858bd9c72', 1, 2, 1, '2024-11-02', 15.00),
(17, '6725912a17193', 2, 1, 1, '2024-11-02', 2.50),
(18, '6725a4312d051', 2, 2, 1, '2024-11-02', 15.00),
(19, '6725a7eb8b118', 6, 1, 1, '2024-11-02', 2.50),
(20, '6725a7eb8b118', 6, 2, 1, '2024-11-02', 15.00),
(21, '6725bd411c15c', 1, 26, 1, '2024-11-02', 2.50),
(22, '6725bd411c15c', 1, 1, 1, '2024-11-02', 2.50),
(23, '6725bd411c15c', 1, 24, 3, '2024-11-02', 4.50),
(24, '6725bd411c15c', 1, 2, 2, '2024-11-02', 15.00),
(25, '6725bd68eac7d', 1, 26, 1, '2024-11-02', 2.50),
(26, '6725bd68eac7d', 1, 1, 1, '2024-11-02', 2.50),
(27, '6725bd68eac7d', 1, 24, 4, '2024-11-02', 4.50),
(28, '6725bd68eac7d', 1, 2, 2, '2024-11-02', 15.00),
(29, '6725bdd1f17f2', 2, 24, 2, '2024-11-02', 4.50),
(30, '6725bdd1f17f2', 2, 2, 1, '2024-11-02', 15.00),
(31, '6725bdd1f17f2', 2, 1, 1, '2024-11-02', 2.50),
(32, '6725bdd1f17f2', 2, 25, 1, '2024-11-02', 4.50),
(33, '6725be0ca9d8d', 2, 24, 2, '2024-11-02', 4.50),
(34, '6725be0ca9d8d', 2, 2, 1, '2024-11-02', 15.00),
(35, '6725be0ca9d8d', 2, 1, 1, '2024-11-02', 2.50),
(36, '6725be0ca9d8d', 2, 25, 1, '2024-11-02', 4.50),
(37, '6725be0ca9d8d', 2, 28, 1, '2024-11-02', 4.50);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_user`);

--
-- Índices de tabela `vendas`
--
ALTER TABLE `vendas`
  ADD PRIMARY KEY (`id_venda`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `vendas`
--
ALTER TABLE `vendas`
  MODIFY `id_venda` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
