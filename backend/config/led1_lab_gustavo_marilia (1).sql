-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30-Jan-2026 às 17:33
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `led1_lab_gustavo_marilia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `ID_admin` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`ID_admin`, `Nome`, `Email`, `password`) VALUES
(1, 'Admin Master', 'admin@led1lab.com', '$2y$10$DRo9ZNj3DoYq2gjGf3Zib.f6lZih8MizCuPCsmZPP5tv03cnL2x4C'),
(2, 'Gustavo', 'gustavo@led1lab.com', '$2y$10$Ybs7MvGnpGQ6KCDp4YwEFO2.iDXG0BeD.nIuPaERmKOjCfyTeCSHC');

-- --------------------------------------------------------

--
-- Estrutura da tabela `footer`
--

CREATE TABLE `footer` (
  `id` int(11) NOT NULL,
  `texto_copyright` varchar(255) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `morada` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `footer`
--

INSERT INTO `footer` (`id`, `texto_copyright`, `email`, `telefone`, `morada`, `instagram`, `linkedin`, `github`) VALUES
(1, '© ', 'contato@led1lab.com', '(11) 99999-9999', 'Av. da Tecnologia, 1000 - Tech Park', 'https://instagram.com/led1lab', 'https://linkedin.com/company/led1lab', 'https://github.com/led1lab');

-- --------------------------------------------------------

--
-- Estrutura da tabela `menu`
--

CREATE TABLE `menu` (
  `ID_menu` int(11) NOT NULL,
  `nome_menu` varchar(50) NOT NULL,
  `tipo_menu` varchar(50) NOT NULL,
  `ordem_menu` int(11) NOT NULL,
  `link_menu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `menu`
--

INSERT INTO `menu` (`ID_menu`, `nome_menu`, `tipo_menu`, `ordem_menu`, `link_menu`) VALUES
(1, 'Contactos', 'todos', 3, '/LED1_LAB_GUSTAVO_MARILIA/LED1_LAB_Gustavo_Marilia/pages/contactos.php'),
(2, 'Home', 'todos', 1, '/LED1_LAB_GUSTAVO_MARILIA/LED1_LAB_Gustavo_Marilia/pages/index.php'),
(3, 'Componentes', 'todos', 2, '/LED1_LAB_GUSTAVO_MARILIA/LED1_LAB_Gustavo_Marilia/pages/lab.php'),
(4, 'Login', 'todos', 1, '/LED1_LAB_GUSTAVO_MARILIA/LED1_LAB_Gustavo_Marilia/pages/login.php');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `ID_produto` int(11) NOT NULL,
  `nome_produto` varchar(50) NOT NULL,
  `descricao_produto` text DEFAULT NULL,
  `imagem_produto` text NOT NULL,
  `quantidade` int(11) DEFAULT 0,
  `tipo_led` varchar(20) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`ID_produto`, `nome_produto`, `descricao_produto`, `imagem_produto`, `quantidade`, `tipo_led`, `categoria`) VALUES
(4, 'Computador portátil', 'Portátil de elevada performance destinado à utilização em contexto educativo no âmbito dos Laboratórios de Educação Digital (LED). \r\nPermite a realização de tarefas exigentes como edição de imagem e vídeo, programação avançada, processamento de dados, desenvolvimento de projetos digitais e programação de placas eletrónicas. \r\nO equipamento dispõe de placa gráfica dedicada, com um mínimo de 4 GB de memória gráfica, garantindo um desempenho adequado para aplicações multimédia e processamento gráfico mais intensivo. \r\nA utilização deve ser restrita ao espaço escolar, em contexto de ensino e aprendizagem, não devendo ser cedido para uso individual ou particular.', 'portatil.png', 10, 'AMBOS', 'Equipamento Comum'),
(5, 'Impressora 3D Modular', 'Impressora 3D destinada à criação de protótipos, peças e modelos tridimensionais, permitindo aos alunos desenvolver competências nas áreas do design, engenharia, modelação e pensamento computacional. Utilizada em projetos interdisciplinares e atividades de fabricação digital.', 'impressora3d.png', 1, 'AMBOS', 'Equipamento Comum'),
(6, 'Kit A', 'Kit de iniciação à eletrónica', 'kit_a.png', 10, 'AMBOS', 'Programação e Robótica'),
(7, 'Kit A 37', 'Kit de sensores e atuadores', 'kit_a37.png', 10, 'AMBOS', 'Programação e Robótica'),
(8, 'Kit B', 'Kit Arduino UNO Rev3 compatível', 'kit_b.png', 10, 'AMBOS', 'Programação e Robótica'),
(9, 'Kit B 37', 'Kit Arduino e Raspberry Pi compatível', 'kit_b37.png', 5, 'AMBOS', 'Programação e Robótica'),
(10, 'Placa Protótipo', 'Placa de ensaio utilizada para a montagem de circuitos eletrónicos sem necessidade de soldadura. Facilita a experimentação, testes e desenvolvimento de protótipos em projetos educativos.', 'protoshield.png', 20, 'AMBOS', 'Programação e Robótica'),
(11, 'Sensor Temperatura Submersível', 'Sensor de temperatura à prova de água', 'temp_sub.png', 10, 'AMBOS', 'Programação e Robótica'),
(12, 'Sensor de Som', 'Módulo destinado à deteção da intensidade sonora do ambiente. Utilizado em projetos de medição de ruído, automação e interação sonora.', 'som.png', 15, 'AMBOS', 'STEM'),
(13, 'Sensor MQ-2', 'Sensor destinado à deteção de gases e fumo. Utilizado em projetos educativos relacionados com segurança, qualidade do ar e monitorização ambiental.', 'mq2.png', 15, 'AMBOS', 'STEM'),
(14, 'Sensor Temp/Humidade', 'Sensor de temperatura e humidade', 'temphum.png', 15, 'AMBOS', 'STEM'),
(15, 'Sensor de Cor', 'Sensor que permite a deteção e identificação de cores visíveis (RGB). Utilizado em projetos de robótica, automação e reconhecimento de padrões.', 'cor.png', 10, 'AMBOS', 'STEM'),
(16, 'Sensor de Movimento', 'Sensor destinado à deteção de movimento físico no ambiente envolvente. Utilizado em projetos de automação, segurança e robótica educativa.', 'movimento.png', 10, 'AMBOS', 'STEM'),
(17, 'Sensor de Luz', 'Sensor de deteção de luz ambiente', 'luz.png', 15, 'AMBOS', 'STEM'),
(18, 'Microscópio Didático', 'Microscópio de laboratório destinado à observação de amostras biológicas e materiais diversos, promovendo a aprendizagem prática nas áreas da ciência e investigação científica.', 'microscopio.png', 2, 'AMBOS', 'STEM'),
(19, 'Câmara Ocular CMOS', 'Câmara digital com sensor CMOS para microscópios, permitindo a captura e visualização de imagens microscópicas em tempo real.', 'camera_cmos.png', 2, 'AMBOS', 'STEM'),
(20, 'Placa Captura HDMI-USB', 'Placa de captura de vídeo', 'captura_hdmi.png', 2, 'LED 2', 'Artes e Multimédia'),
(21, 'Controlador de Streaming', 'Equipamento destinado ao controlo de transmissões de vídeo ao vivo, facilitando a gestão de cenas e fontes de vídeo e áudio.', 'streaming.png', 1, 'LED 2', 'Artes e Multimédia'),
(22, 'Mesa de Mistura de Áudio', 'Mesa de som que permite misturar e controlar várias fontes de áudio em projetos de gravação e produção audiovisual.', 'mesa_audio.png', 1, 'LED 2', 'Artes e Multimédia'),
(23, 'Máquina Fotográfica', 'Câmara fotográfica digital utilizada na captura de imagens para projetos educativos e multimédia.', 'camera_foto.png', 2, 'LED 2', 'Artes e Multimédia'),
(24, 'Microfone Externo', 'Microfone para câmara', 'mic_externo.png', 3, 'LED 2', 'Artes e Multimédia'),
(25, 'Câmara de Vídeo', 'Câmara digital para gravação de vídeo utilizada na criação de conteúdos audiovisuais em contexto educativo.', 'camera_video.png', 2, 'LED 2', 'Artes e Multimédia'),
(26, 'Teleponto', 'Sistema de apoio à leitura de texto durante gravações de vídeo, facilitando apresentações e produções audiovisuais.', 'teleponto.png', 1, 'LED 2', 'Artes e Multimédia'),
(27, 'Tripé', 'Tripé com cabeça giratória', 'tripe.png', 3, 'LED 2', 'Artes e Multimédia'),
(28, 'Microfone sem fios', 'Microfone sem fios destinado à captação de áudio em gravações de vídeo, entrevistas e projetos multimédia.', 'micro_semfio.png', 4, 'LED 2', 'Artes e Multimédia'),
(29, 'Microfone com Fios', 'Microfone com tripé', 'micro.png', 3, 'LED 2', 'Artes e Multimédia'),
(30, 'Gravador de Áudio', 'Gravador de áudio portátil', 'gravador.png', 2, 'LED 2', 'Artes e Multimédia'),
(31, 'Mesa Digitalizadora 4K', 'Mesa gráfica com caneta digital destinada ao desenho, ilustração e design digital em projetos criativos.', 'mesa_digi.png', 2, 'LED 2', 'Artes e Multimédia');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_admin`);

--
-- Índices para tabela `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID_menu`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`ID_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `footer`
--
ALTER TABLE `footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `ID_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `ID_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
